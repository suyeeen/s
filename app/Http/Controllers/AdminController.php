<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
        })
            ->latest()
            ->paginate(15)
            ->withQueryString();

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
            Guru::create([
                'user_id'        => $user->id,
                'nama'           => $user->name,
                'nip'            => '-',
                'mata_pelajaran' => '-',
            ]);
        } elseif ($request->role === 'siswa') {
            Siswa::create([
                'user_id' => $user->id,
                'nama'    => $user->name,
                'kelas'   => '-',
            ]);
        }

        return back()->with('success', "Pengguna \"{$user->name}\" berhasil ditambahkan.");
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

        $oldRole = $user->role;
        $newRole = $request->role;

        $data = $request->only('name', 'email', 'role');

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        // Buat profil jika role berubah dan belum punya profil
        if ($newRole === 'guru' && !$user->guru) {
            Guru::create([
                'user_id'        => $user->id,
                'nama'           => $user->name,
                'nip'            => '-',
                'mata_pelajaran' => '-',
            ]);
        } elseif ($newRole === 'siswa' && !$user->siswa) {
            Siswa::create([
                'user_id' => $user->id,
                'nama'    => $user->name,
                'kelas'   => '-',
            ]);
        }

        return back()->with('success', "Data pengguna \"{$user->name}\" berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun yang sedang aktif.');
        }

        $name = $user->name;
        $user->delete();
        return back()->with('success', "Pengguna \"{$name}\" berhasil dihapus.");
    }

    public function monitoring()
    {
        $stats = [
            'total_guru'    => Guru::count(),
            'total_siswa'   => Siswa::count(),
            'total_users'   => User::count(),
            'sudah_dinilai' => \App\Models\HasilClustering::distinct('guru_id')->count(),
        ];

        return view('admin.monitoring', compact('stats'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function saveSettings(Request $request)
    {
        return back()->with('success', 'Pengaturan disimpan.');
    }
}
