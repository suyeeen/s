@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8" x-data="{ modalOpen: false, editUser: null }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold" style="color:var(--text-main)" tracking-tight">Manajemen Pengguna</h1>
                <p class="text-sm mt-2" style="color:var(--text-muted)">Kelola akses dan data pengguna sistem STQM.</p>
            </div>
            <button @click="modalOpen = true; editUser = null"
                class="flex items-center gap-2 px-5 py-3 rounded-2xl font-semibold text-white text-sm transition-all"
                style="background: linear-gradient(135deg, #f97316, #eab308); box-shadow: 0 8px 32px rgba(249,115,22,0.3);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengguna
            </button>
        </div>

        {{-- Tabel --}}
        <div class="rounded-3xl overflow-hidden"
            style="background:var(--card-bg);border:1px solid var(--card-border);">

            {{-- Search --}}
            <div class="p-6"
                style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                <form method="GET" action="{{ route('admin.users.index') }}">
                    <div class="relative w-full max-w-md">
                        <svg class="w-5 h-5 text-gray-500 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau email..."
                            class="w-full pl-12 pr-4 py-3 rounded-2xl text-sm outline-none" style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs" style="color:var(--text-muted);border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                            <th class="p-5 font-medium">Nama Lengkap</th>
                            <th class="p-5 font-medium">Email</th>
                            <th class="p-5 font-medium">Role</th>
                            <th class="p-5 font-medium">Dibuat</th>
                            <th class="p-5 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($users as $user)
                            <tr style="border-bottom:1px solid var(--card-border-soft);"
                                onmouseover="this.style.background='rgba(26,22,19,0.03)'" onmouseout="this.style.background='transparent'" >

                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm shrink-0"
                                            style="background:rgba(232,86,10,0.12);color:#E8560A;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="font-semibold text-white">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="p-5 text-gray-400">{{ $user->email }}</td>
                                <td class="p-5">
                                    @php
                                        $roleStyle = match ($user->role) {
                                            'admin' => [
                                                'bg' => 'rgba(139,92,246,0.1)',
                                                'color' => '#a78bfa',
                                                'border' => 'rgba(139,92,246,0.2)',
                                                'label' => 'Admin',
                                            ],
                                            'kepsek' => [
                                                'bg' => 'rgba(59,130,246,0.1)',
                                                'color' => '#60a5fa',
                                                'border' => 'rgba(59,130,246,0.2)',
                                                'label' => 'Kepala Sekolah',
                                            ],
                                            'guru' => [
                                                'bg' => 'rgba(249,115,22,0.1)',
                                                'color' => '#fb923c',
                                                'border' => 'rgba(249,115,22,0.2)',
                                                'label' => 'Guru',
                                            ],
                                            'siswa' => [
                                                'bg' => 'rgba(16,185,129,0.1)',
                                                'color' => '#34d399',
                                                'border' => 'rgba(16,185,129,0.2)',
                                                'label' => 'Siswa',
                                            ],
                                            default => [
                                                'bg' => 'rgba(255,255,255,0.05)',
                                                'color' => '#9ca3af',
                                                'border' => 'rgba(255,255,255,0.1)',
                                                'label' => $user->role,
                                            ],
                                        };
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold"
                                        style="background: {{ $roleStyle['bg'] }}; color: {{ $roleStyle['color'] }}; border: 1px solid {{ $roleStyle['border'] }};">
                                        {{ $roleStyle['label'] }}
                                    </span>
                                </td>
                                <td class="p-5 text-gray-500 text-xs">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="p-5">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Edit --}}
                                        <button @click="modalOpen = true; editUser = {{ $user->toJson() }}"
                                            class="p-2.5 rounded-xl text-gray-400 hover:text-blue-400 transition-all"
                                            style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);"
                                            onmouseover="this.style.background='rgba(59,130,246,0.1)'; this.style.borderColor='rgba(59,130,246,0.2)'"
                                            onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.borderColor='rgba(255,255,255,0.05)'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        {{-- Hapus --}}
                                        @if ($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                                class="swal-delete" data-nama="{{ $user->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2.5 rounded-xl text-gray-400 hover:text-red-400 transition-all"
                                                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);"
                                                    onmouseover="this.style.background='rgba(239,68,68,0.1)'; this.style.borderColor='rgba(239,68,68,0.2)'"
                                                    onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.borderColor='rgba(255,255,255,0.05)'">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center text-gray-500">Tidak ada pengguna ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($users->hasPages())
                <div class="p-5" style="border-top: 1px solid rgba(255,255,255,0.06);">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        {{-- ── Modal Tambah/Edit ── --}}
        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background: rgba(0,0,0,0.6); backdrop-filter: blur(8px);">

            <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="w-full max-w-md rounded-3xl overflow-hidden shadow-2xl"
                style="background: #0e0e1a; border: 1px solid rgba(255,255,255,0.08);">

                {{-- Header --}}
                <div class="p-6 flex justify-between items-center"
                    style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                    <h3 class="font-bold text-white text-xl" x-text="editUser ? 'Edit Pengguna' : 'Tambah Pengguna Baru'">
                    </h3>
                    <button @click="modalOpen = false" class="p-2 rounded-xl text-gray-400 hover:text-white"
                        style="background: rgba(255,255,255,0.05);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Form Tambah --}}
                <div x-show="!editUser">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div class="p-8 space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" required placeholder="Masukkan nama lengkap..."
                                    class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none placeholder-gray-600"
                                    style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);"
                                    onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                                <input type="email" name="email" required placeholder="email@stqm.sch.id"
                                    class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none placeholder-gray-600"
                                    style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);"
                                    onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Role</label>
                                <select name="role" required
                                    class="w-full px-4 py-3 rounded-2xl text-sm outline-none" style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                                    @foreach (['siswa' => 'Siswa', 'guru' => 'Guru', 'kepsek' => 'Kepala Sekolah', 'admin' => 'Administrator'] as $val => $label)
                                        <option value="{{ $val }}" style="background: #0a0a14;">
                                            {{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                                <input type="password" name="password" required placeholder="Minimal 6 karakter"
                                    class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none placeholder-gray-600"
                                    style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);"
                                    onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
                            </div>
                        </div>
                        <div class="p-6 flex justify-end gap-4"
                            style="border-top: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                            <button type="button" @click="modalOpen = false"
                                class="px-6 py-3 rounded-2xl text-sm font-medium text-gray-400"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-3 rounded-2xl text-sm font-semibold text-white"
                                style="background: linear-gradient(135deg, #f97316, #eab308);">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Form Edit --}}
                <div x-show="editUser" x-data="{ gantiSandi: false, lihatSandi: false }">
                    <form method="POST" :action="`/admin/users/${editUser?.id}`">
                        @csrf
                        @method('PUT')
                        <div class="p-8 space-y-5">

                            {{-- Nama --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" :value="editUser?.name" required
                                    class="w-full px-4 py-3 rounded-2xl text-sm outline-none" style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);"
                                    onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                                <input type="email" name="email" :value="editUser?.email" required
                                    class="w-full px-4 py-3 rounded-2xl text-sm outline-none" style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);"
                                    onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
                            </div>

                            {{-- Role --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Role</label>
                                <select name="role" required
                                    class="w-full px-4 py-3 rounded-2xl text-sm outline-none" style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                                    @foreach (['siswa' => 'Siswa', 'guru' => 'Guru', 'kepsek' => 'Kepala Sekolah', 'admin' => 'Administrator'] as $val => $label)
                                        <option value="{{ $val }}"
                                            :selected="editUser?.role === '{{ $val }}'"
                                            style="background: #0a0a14;">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Toggle Ubah Kata Sandi --}}
                            <div>
                                <button type="button" @click="gantiSandi = !gantiSandi"
                                    class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-sm transition-all"
                                    :style="gantiSandi
                                        ?
                                        'background: rgba(249,115,22,0.1); border: 1px solid rgba(249,115,22,0.3); color: #fb923c;' :
                                        'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); color: #9ca3af;'">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                        Ubah Kata Sandi
                                    </span>
                                    <svg class="w-4 h-4 transition-transform" :class="gantiSandi ? 'rotate-180' : ''"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Field Kata Sandi (muncul saat toggle aktif) --}}
                                <div x-show="gantiSandi" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="mt-3 space-y-3 p-4 rounded-2xl"
                                    style="background: rgba(249,115,22,0.04); border: 1px solid rgba(249,115,22,0.15);">

                                    <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengubah kata sandi.</p>

                                    {{-- Password Baru --}}
                                    <div>
                                        <label class="block text-xs font-medium text-gray-400 mb-1.5">Kata Sandi
                                            Baru</label>
                                        <div class="relative">
                                            <input :type="lihatSandi ? 'text' : 'password'" name="password"
                                                placeholder="Minimal 6 karakter"
                                                class="w-full pl-4 pr-10 py-3 rounded-2xl text-white text-sm outline-none placeholder-gray-600"
                                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);"
                                                onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                                                onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
                                            <button type="button" @click="lihatSandi = !lihatSandi"
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300">
                                                <svg x-show="!lihatSandi" class="w-4 h-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg x-show="lihatSandi" class="w-4 h-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Konfirmasi Password --}}
                                    <div>
                                        <label class="block text-xs font-medium text-gray-400 mb-1.5">Konfirmasi Kata
                                            Sandi</label>
                                        <input :type="lihatSandi ? 'text' : 'password'" name="password_confirmation"
                                            placeholder="Ulangi kata sandi baru"
                                            class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none placeholder-gray-600"
                                            style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);"
                                            onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                                            onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="p-6 flex justify-end gap-4"
                            style="border-top: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                            <button type="button" @click="modalOpen = false; gantiSandi = false"
                                class="px-6 py-3 rounded-2xl text-sm font-medium text-gray-400"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-3 rounded-2xl text-sm font-semibold text-white"
                                style="background: linear-gradient(135deg, #f97316, #eab308);">
                                Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
