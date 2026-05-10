<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kuesioner;
use Illuminate\Support\Facades\Cache;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $roleFilter = $request->get('role', 'semua');

        $query = User::latest();
        if ($roleFilter !== 'semua') {
            $query->where('role', $roleFilter);
        }
        $users = $query->paginate(15)->withQueryString();

        $stats = [
            'total_guru'   => \App\Models\Guru::count(),
            'total_siswa'  => \App\Models\Siswa::count(),
            'total_users'  => User::count(),
            'total_admin'  => User::where('role', 'admin')->count(),
            'total_kepsek' => User::where('role', 'kepsek')->count(),
        ];

        return view('admin.users', compact('users', 'stats', 'roleFilter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'role'     => 'required|in:admin,guru,siswa,kepsek',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => bcrypt($request->password),
        ]);

        if ($request->role === 'guru') {
            Guru::create(['user_id' => $user->id, 'nama' => $user->name, 'nip' => '-', 'mata_pelajaran' => '-']);
        } elseif ($request->role === 'siswa') {
            Siswa::create(['user_id' => $user->id, 'nama' => $user->name, 'kelas' => '-']);
        }

        return back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email,' . $user->id,
            'role'                  => 'required|in:admin,guru,siswa,kepsek',
            'password'              => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable',
        ]);

        $data = $request->only('name', 'email', 'role');
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        return back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Pengguna dihapus.');
    }

    /**
     * Import siswa massal dari file Excel.
     * Route: POST /admin/users/import
     */
    public function importSiswa(Request $request)
    {
        $request->validate([
            'file_import' => 'required|file|mimes:xlsx,xls|max:5120',
        ], [
            'file_import.required' => 'Pilih file Excel terlebih dahulu.',
            'file_import.mimes'    => 'File harus berformat .xlsx atau .xls.',
            'file_import.max'      => 'Ukuran file maksimal 5 MB.',
        ]);

        $import = new SiswaImport();
        Excel::import($import, $request->file('file_import'));

        $pesan = "Import selesai: {$import->berhasil} akun berhasil dibuat";
        if ($import->duplikat > 0) $pesan .= ", {$import->duplikat} duplikat di-skip";
        if ($import->gagal > 0)    $pesan .= ", {$import->gagal} baris gagal validasi";

        return back()
            ->with('import_success',  $pesan)
            ->with('import_berhasil', $import->berhasil)
            ->with('import_duplikat', $import->duplikat)
            ->with('import_gagal',    $import->gagal)
            ->with('import_log',      $import->logGagal);
    }

    /**
     * Download template Excel kosong untuk panduan admin.
     * Route: GET /admin/users/template
     */
    public function downloadTemplate()
    {
        $headers = [['nama', 'email', 'kelas', 'password']];
        $contoh  = [
            ['Nama Lengkap Siswa', 'email@domain.com',  'X-A',  'password123'],
            ['Contoh Siswa Dua',   'siswa2@domain.com', 'XI-B', 'rahasia123'],
        ];
        $data = array_merge($headers, $contoh);

        return Excel::download(
            new \App\Exports\TemplateSiswaExport($data),
            'template_import_siswa.xlsx'
        );
    }

    public function monitoring(Request $request)
    {
        $kuesionerStats = [
            'dari_siswa' => Kuesioner::where('tipe', 'siswa')->count(),
            'dari_guru'  => Kuesioner::where('tipe', 'guru')->count(),
            'total'      => Kuesioner::count(),
        ];

        $totalGuru       = Guru::count();
        $sudahDicluster  = \App\Models\HasilClustering::distinct('guru_id')->count();
        $belumDicluster  = max(0, $totalGuru - $sudahDicluster);

        $clusterDistribusi = [
            'A' => \App\Models\HasilClustering::where('cluster', 'A')->distinct('guru_id')->count(),
            'B' => \App\Models\HasilClustering::where('cluster', 'B')->distinct('guru_id')->count(),
            'C' => \App\Models\HasilClustering::where('cluster', 'C')->distinct('guru_id')->count(),
            'D' => \App\Models\HasilClustering::where('cluster', 'D')->distinct('guru_id')->count(),
        ];

        $riwayatClustering = \App\Models\HasilClustering::with('guru')
            ->orderByDesc('tanggal')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        $rataKompetensi = \App\Models\HasilClustering::selectRaw('
            AVG(nilai_pedagogik) as pedagogik,
            AVG(nilai_profesional) as profesional,
            AVG(nilai_sosial) as sosial,
            AVG(nilai_kepribadian) as kepribadian,
            AVG(nilai_rata_rata) as rata_rata
        ')->first();

        return view('admin.monitoring', compact(
            'kuesionerStats',
            'totalGuru',
            'sudahDicluster',
            'belumDicluster',
            'clusterDistribusi',
            'riwayatClustering',
            'rataKompetensi'
        ));
    }

    public function settings()
    {
        $settings = [
            'tahun_ajaran'    => Cache::get('stqm_tahun_ajaran', '2024/2025'),
            'semester'        => Cache::get('stqm_semester', 'ganjil'),
            'buka_kuesioner'  => Cache::get('stqm_buka_kuesioner', ''),
            'tutup_kuesioner' => Cache::get('stqm_tutup_kuesioner', ''),
            'rfid_aktif'      => Cache::get('stqm_rfid_aktif', false),
            'maks_penilaian'  => Cache::get('stqm_maks_penilaian', 1),
        ];
        return view('admin.settings', compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'tahun_ajaran'    => 'required|string',
            'semester'        => 'required|in:ganjil,genap',
            'buka_kuesioner'  => 'nullable|date',
            'tutup_kuesioner' => 'nullable|date|after_or_equal:buka_kuesioner',
            'maks_penilaian'  => 'required|integer|min:1|max:10',
        ]);

        Cache::forever('stqm_tahun_ajaran',    $request->tahun_ajaran);
        Cache::forever('stqm_semester',        $request->semester);
        Cache::forever('stqm_buka_kuesioner',  $request->buka_kuesioner ?? '');
        Cache::forever('stqm_tutup_kuesioner', $request->tutup_kuesioner ?? '');
        Cache::forever('stqm_rfid_aktif',      $request->boolean('rfid_aktif'));
        Cache::forever('stqm_maks_penilaian',  $request->maks_penilaian);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
    /**
     * Hapus banyak user sekaligus.
     * Route: POST /admin/users/bulk-destroy
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'user_ids'   => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        // Jangan sampai admin menghapus akunnya sendiri
        $ids = collect($request->user_ids)
            ->reject(fn($id) => (int)$id === auth()->id())
            ->values();

        if ($ids->isEmpty()) {
            return back()->with('error', 'Tidak ada akun yang dihapus (tidak bisa menghapus akun sendiri).');
        }

        $jumlah = $ids->count();
        User::whereIn('id', $ids)->delete();

        return back()->with('success', "{$jumlah} akun berhasil dihapus.");
    }
}
