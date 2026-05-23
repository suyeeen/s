<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Guru;
use App\Models\Absensi;
use App\Imports\AbsensiImport;
use App\Exports\TemplateAbsensiExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminAbsensiController extends Controller
{
    protected array $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    public function index(Request $request)
    {
        $search      = $request->get('search', '');
        $bulanFilter = $request->get('bulan', '');
        $tahunFilter = $request->get('tahun', date('Y'));

        $query = Absensi::with('guru')
            ->where('diinput_admin', true)
            ->when($tahunFilter, fn($q) => $q->where('tahun', $tahunFilter))
            ->when($bulanFilter, fn($q) => $q->where('bulan', $bulanFilter))
            ->when($search, fn($q) => $q->whereHas(
                'guru',
                fn($gq) =>
                $gq->where('nama', 'like', "%$search%")
                    ->orWhere('nip', 'like', "%$search%")
            ))
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->paginate(20)
            ->withQueryString();

        $guruList = Guru::all()->map(fn($g) => [
            'id'           => $g->id,
            'nama'         => $g->nama,
            'persen_hadir' => Absensi::rataPersenHadir($g->id),
        ]);

        return view('admin.absensi.index', compact(
            'query',
            'search',
            'bulanFilter',
            'tahunFilter',
            'guruList'
        ) + ['namaBulan' => $this->namaBulan]);
    }

    public function create()
    {
        $guru = Guru::orderBy('nama')->get();
        return view('admin.absensi.create', ['guru' => $guru, 'namaBulan' => $this->namaBulan]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id'          => 'required|exists:guru,id',
            'bulan'            => 'required|integer|min:1|max:12',
            'tahun'            => 'required|integer|min:2000|max:' . date('Y'),
            'jumlah_hadir'     => 'required|integer|min:0',
            'jumlah_izin'      => 'required|integer|min:0',
            'jumlah_sakit'     => 'required|integer|min:0',
            'jumlah_alpha'     => 'required|integer|min:0',
            'jumlah_terlambat' => 'required|integer|min:0',
            'total_hari_kerja' => 'required|integer|min:1',
            'keterangan'       => 'nullable|string|max:500',
        ]);

        $sudahAda = Absensi::where('guru_id', $request->guru_id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('diinput_admin', true)
            ->exists();

        if ($sudahAda) {
            return back()->withInput()
                ->with('error', 'Rekap absensi untuk guru dan bulan ini sudah ada. Gunakan fitur edit.');
        }

        Absensi::create([
            'guru_id'          => $request->guru_id,
            'bulan'            => $request->bulan,
            'tahun'            => $request->tahun,
            'tanggal'          => date('Y-m-d', mktime(0, 0, 0, $request->bulan, 1, $request->tahun)),
            'jumlah_hadir'     => $request->jumlah_hadir,
            'jumlah_izin'      => $request->jumlah_izin,
            'jumlah_sakit'     => $request->jumlah_sakit,
            'jumlah_alpha'     => $request->jumlah_alpha,
            'jumlah_terlambat' => $request->jumlah_terlambat,
            'total_hari_kerja' => $request->total_hari_kerja,
            'keterangan'       => $request->keterangan,
            'status'           => 'hadir',
            'diinput_admin'    => true,
            'admin_id'         => auth()->id(),
        ]);

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Rekap absensi berhasil disimpan.');
    }

    public function edit(Absensi $absensi)
    {
        $guru = Guru::orderBy('nama')->get();
        return view('admin.absensi.edit', [
            'absensi'   => $absensi,
            'guru'      => $guru,
            'namaBulan' => $this->namaBulan,
        ]);
    }

    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'jumlah_hadir'     => 'required|integer|min:0',
            'jumlah_izin'      => 'required|integer|min:0',
            'jumlah_sakit'     => 'required|integer|min:0',
            'jumlah_alpha'     => 'required|integer|min:0',
            'jumlah_terlambat' => 'required|integer|min:0',
            'total_hari_kerja' => 'required|integer|min:1',
            'keterangan'       => 'nullable|string|max:500',
        ]);

        $absensi->update([
            'jumlah_hadir'     => $request->jumlah_hadir,
            'jumlah_izin'      => $request->jumlah_izin,
            'jumlah_sakit'     => $request->jumlah_sakit,
            'jumlah_alpha'     => $request->jumlah_alpha,
            'jumlah_terlambat' => $request->jumlah_terlambat,
            'total_hari_kerja' => $request->total_hari_kerja,
            'keterangan'       => $request->keterangan,
            'admin_id'         => auth()->id(),
        ]);

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Rekap absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return back()->with('success', 'Rekap absensi berhasil dihapus.');
    }

    // ── IMPORT ──────────────────────────────────────────────────────────────

    /**
     * Step 1 — Validasi file (dry run) → tampilkan preview sebelum simpan
     * Route: POST /admin/absensi/import/preview
     */
    public function importPreview(Request $request)
    {
        $request->validate([
            'file_import' => 'required|file|mimes:xlsx,xls|max:5120',
        ], [
            'file_import.required' => 'Pilih file Excel terlebih dahulu.',
            'file_import.mimes'    => 'File harus berformat .xlsx atau .xls.',
        ]);

        $request->session()->forget('absensi_import_path');

        // Simpan file sementara
        $path = $request->file('file_import')->store('temp_import');
        $request->session()->put('absensi_import_path', $path);

        // FIX: Gunakan Storage::path() agar path-nya resolve dengan benar di Laravel 11+
        $import = new AbsensiImport(dryRun: true, adminId: auth()->id());
        Excel::import($import, Storage::path($path));

        return back()
            ->with('import_preview',  $import->preview)
            ->with('import_log_gagal', $import->logGagal)
            ->with('import_path',     $path);
    }

    /**
     * Step 2 — Konfirmasi dan simpan hasil import
     * Route: POST /admin/absensi/import/confirm
     */
    public function importConfirm(Request $request)
    {
        $path = $request->session()->pull('absensi_import_path');

        if (!$path || !Storage::exists($path)) {
            return redirect()->route('admin.absensi.index')
                ->with('error', 'Sesi import sudah kedaluwarsa. Silakan upload ulang.');
        }

        // FIX: Gunakan Storage::path() agar path-nya resolve dengan benar di Laravel 11+
        $import = new AbsensiImport(dryRun: false, adminId: auth()->id());
        Excel::import($import, Storage::path($path));

        Storage::delete($path);

        $pesan = "Import selesai: {$import->berhasil} rekap baru ditambahkan";
        if ($import->diupdate > 0) $pesan .= ", {$import->diupdate} rekap diperbarui";
        if ($import->gagal    > 0) $pesan .= ", {$import->gagal} baris gagal";

        return redirect()->route('admin.absensi.index')
            ->with('success', $pesan)
            ->with('import_log', $import->logGagal);
    }

    /**
     * Download template Excel
     * Route: GET /admin/absensi/template
     */
    public function downloadTemplate()
    {
        return Excel::download(
            new TemplateAbsensiExport(),
            'template_rekap_absensi.xlsx'
        );
    }
}
