<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
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

        // Buat profil sesuai role
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

    public function monitoring()
    {
        $stats = [
            'total_guru'   => Guru::count(),
            'total_siswa'  => \App\Models\Siswa::count(),
            'total_users'  => User::count(),
            'sudah_dinilai' => \App\Models\HasilClustering::distinct('guru_id')->count(),
        ];

        return view('admin.monitoring', compact('stats'));
    }

    public function settings()
    {
        $settings = [
            'tahun_ajaran'    => Cache::get('stqm_tahun_ajaran', '2024/2025'),
            'semester'        => Cache::get('stqm_semester', 'ganjil'),
            'buka_kuesioner'  => Cache::get('stqm_buka_kuesioner', ''),
            'tutup_kuesioner' => Cache::get('stqm_tutup_kuesioner', ''),
            'rfid_aktif'      => Cache::get('stqm_rfid_aktif', false),
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
        ]);

        Cache::forever('stqm_tahun_ajaran',    $request->tahun_ajaran);
        Cache::forever('stqm_semester',        $request->semester);
        Cache::forever('stqm_buka_kuesioner',  $request->buka_kuesioner ?? '');
        Cache::forever('stqm_tutup_kuesioner', $request->tutup_kuesioner ?? '');
        Cache::forever('stqm_rfid_aktif',      $request->boolean('rfid_aktif'));

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
