<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;

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
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,guru,siswa,kepsek',
        ]);

        $user->update($request->only('name', 'email', 'role'));
        return back()->with('success', 'Data pengguna diperbarui.');
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
            'sudah_dinilai'=> \App\Models\HasilClustering::distinct('guru_id')->count(),
        ];

        return view('admin.monitoring', compact('stats'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function saveSettings(Request $request)
    {
        // Simpan ke config/cache sesuai kebutuhan
        return back()->with('success', 'Pengaturan disimpan.');
    }
}
