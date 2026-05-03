@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8" x-data="{ modalOpen: false, editUser: null }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight" style="color:var(--text-main)">Manajemen Pengguna</h1>
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

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="rounded-3xl p-5 flex items-center gap-4" style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0" style="background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.2);">
                    <svg class="w-5 h-5" fill="none" stroke="#60a5fa" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs" style="color:var(--text-muted)">Total Pengguna</p>
                    <p class="text-2xl font-bold" style="color:#60a5fa">{{ $stats['total_users'] }}</p>
                </div>
            </div>
            <div class="rounded-3xl p-5 flex items-center gap-4" style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0" style="background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.2);">
                    <svg class="w-5 h-5" fill="none" stroke="#fb923c" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <p class="text-xs" style="color:var(--text-muted)">Total Guru</p>
                    <p class="text-2xl font-bold" style="color:#fb923c">{{ $stats['total_guru'] }}</p>
                </div>
            </div>
            <div class="rounded-3xl p-5 flex items-center gap-4" style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0" style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);">
                    <svg class="w-5 h-5" fill="none" stroke="#fbbf24" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </div>
                <div>
                    <p class="text-xs" style="color:var(--text-muted)">Total Siswa</p>
                    <p class="text-2xl font-bold" style="color:#fbbf24">{{ $stats['total_siswa'] }}</p>
                </div>
            </div>
            <div class="rounded-3xl p-5 flex items-center gap-4" style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);">
                    <svg class="w-5 h-5" fill="none" stroke="#34d399" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <div>
                    <p class="text-xs" style="color:var(--text-muted)">Kepala Sekolah</p>
                    <p class="text-2xl font-bold" style="color:#34d399">{{ $stats['total_kepsek'] }}</p>
                </div>
            </div>
            <div class="rounded-3xl p-5 flex items-center gap-4" style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0" style="background:rgba(139,92,246,0.1);border:1px solid rgba(139,92,246,0.2);">
                    <svg class="w-5 h-5" fill="none" stroke="#a78bfa" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs" style="color:var(--text-muted)">Administrator</p>
                    <p class="text-2xl font-bold" style="color:#a78bfa">{{ $stats['total_admin'] }}</p>
                </div>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="rounded-3xl overflow-hidden" style="background:var(--card-bg);border:1px solid var(--card-border);">

            {{-- Search + Filter --}}
            <div class="p-6 flex flex-col sm:flex-row sm:items-center gap-4"
                style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex-1">
                    <input type="hidden" name="role" value="{{ $roleFilter }}">
                    <div class="relative w-full max-w-sm">
                        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2" style="color:var(--text-muted)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                            class="w-full pl-12 pr-4 py-3 rounded-2xl text-sm outline-none"
                            style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                    </div>
                </form>
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2 flex-wrap">
                    @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                    @foreach (['semua' => 'Semua', 'admin' => 'Admin', 'guru' => 'Guru', 'siswa' => 'Siswa', 'kepsek' => 'Kepsek'] as $val => $label)
                        <button type="submit" name="role" value="{{ $val }}"
                            class="px-4 py-1.5 rounded-xl text-xs font-medium transition-all"
                            style="{{ $roleFilter === $val ? 'background: linear-gradient(135deg, #f97316, #eab308); color: white;' : 'background: var(--btn-bg); border: 1px solid var(--btn-border); color: var(--text-muted);' }}">
                            {{ $label }}
                        </button>
                    @endforeach
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
                                onmouseover="this.style.background='rgba(26,22,19,0.03)'" onmouseout="this.style.background='transparent'">
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm shrink-0" style="background:rgba(232,86,10,0.12);color:#E8560A;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="font-semibold" style="color:var(--text-main)">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="p-5" style="color:var(--text-muted)">{{ $user->email }}</td>
                                <td class="p-5">
                                    @php
                                        $rs = match($user->role) {
                                            'admin'  => ['bg'=>'rgba(139,92,246,0.1)','color'=>'#a78bfa','border'=>'rgba(139,92,246,0.2)','label'=>'Admin'],
                                            'kepsek' => ['bg'=>'rgba(16,185,129,0.1)','color'=>'#34d399','border'=>'rgba(16,185,129,0.2)','label'=>'Kepala Sekolah'],
                                            'guru'   => ['bg'=>'rgba(249,115,22,0.1)','color'=>'#fb923c','border'=>'rgba(249,115,22,0.2)','label'=>'Guru'],
                                            'siswa'  => ['bg'=>'rgba(59,130,246,0.1)','color'=>'#60a5fa','border'=>'rgba(59,130,246,0.2)','label'=>'Siswa'],
                                            default  => ['bg'=>'rgba(255,255,255,0.05)','color'=>'#9ca3af','border'=>'rgba(255,255,255,0.1)','label'=>$user->role],
                                        };
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold"
                                        style="background:{{ $rs['bg'] }};color:{{ $rs['color'] }};border:1px solid {{ $rs['border'] }};">
                                        {{ $rs['label'] }}
                                    </span>
                                </td>
                                <td class="p-5 text-xs" style="color:var(--text-muted)">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="p-5">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="modalOpen = true; editUser = {{ $user->toJson() }}"
                                            class="p-2.5 rounded-xl transition-all"
                                            style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.05);color:#9ca3af;"
                                            onmouseover="this.style.background='rgba(59,130,246,0.1)';this.style.borderColor='rgba(59,130,246,0.2)';this.style.color='#60a5fa'"
                                            onmouseout="this.style.background='rgba(255,255,255,0.03)';this.style.borderColor='rgba(255,255,255,0.05)';this.style.color='#9ca3af'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="swal-delete" data-nama="{{ $user->name }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2.5 rounded-xl transition-all"
                                                    style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.05);color:#9ca3af;"
                                                    onmouseover="this.style.background='rgba(239,68,68,0.1)';this.style.borderColor='rgba(239,68,68,0.2)';this.style.color='#f87171'"
                                                    onmouseout="this.style.background='rgba(255,255,255,0.03)';this.style.borderColor='rgba(255,255,255,0.05)';this.style.color='#9ca3af'">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-10 text-center text-sm" style="color:var(--text-muted)">Tidak ada pengguna ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="p-5" style="border-top:1px solid rgba(255,255,255,0.06);">{{ $users->links() }}</div>
            @endif
        </div>

        {{-- Modal --}}
        <div x-show="modalOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,0.6);backdrop-filter:blur(8px);">
            <div x-show="modalOpen" x-transition class="w-full max-w-md rounded-3xl overflow-hidden shadow-2xl" style="background:#0e0e1a;border:1px solid rgba(255,255,255,0.08);">
                <div class="p-6 flex justify-between items-center" style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                    <h3 class="font-bold text-white text-xl" x-text="editUser ? 'Edit Pengguna' : 'Tambah Pengguna Baru'"></h3>
                    <button @click="modalOpen = false" class="p-2 rounded-xl text-gray-400 hover:text-white" style="background:rgba(255,255,255,0.05);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                {{-- Form Tambah --}}
                <div x-show="!editUser">
                    <form method="POST" action="{{ route('admin.users.store') }}">@csrf
                        <div class="p-8 space-y-5">
                            <div><label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" required placeholder="Masukkan nama lengkap..." class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none placeholder-gray-600" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);" onfocus="this.style.borderColor='rgba(249,115,22,0.5)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'"></div>
                            <div><label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                                <input type="email" name="email" required placeholder="email@stqm.sch.id" class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none placeholder-gray-600" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);" onfocus="this.style.borderColor='rgba(249,115,22,0.5)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'"></div>
                            <div><label class="block text-sm font-medium text-gray-300 mb-2">Role</label>
                                <select name="role" required class="w-full px-4 py-3 rounded-2xl text-sm outline-none" style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                                    @foreach(['siswa'=>'Siswa','guru'=>'Guru','kepsek'=>'Kepala Sekolah','admin'=>'Administrator'] as $v=>$l)<option value="{{ $v }}" style="background:#0a0a14">{{ $l }}</option>@endforeach
                                </select></div>
                            <div><label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                                <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none placeholder-gray-600" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);" onfocus="this.style.borderColor='rgba(249,115,22,0.5)'" onblur="this.style.borderColor='rgba(255,255,255,0.08)'"></div>
                        </div>
                        <div class="p-6 flex justify-end gap-4" style="border-top:1px solid rgba(255,255,255,0.06);background:rgba(255,255,255,0.02);">
                            <button type="button" @click="modalOpen=false" class="px-6 py-3 rounded-2xl text-sm font-medium text-gray-400" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);">Batal</button>
                            <button type="submit" class="px-6 py-3 rounded-2xl text-sm font-semibold text-white" style="background:linear-gradient(135deg,#f97316,#eab308);">Simpan</button>
                        </div>
                    </form>
                </div>
                {{-- Form Edit --}}
                <div x-show="editUser" x-data="{gantiSandi:false,lihatSandi:false}">
                    <form method="POST" :action="`/admin/users/${editUser?.id}`">@csrf @method('PUT')
                        <div class="p-8 space-y-5">
                            <div><label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" :value="editUser?.name" required class="w-full px-4 py-3 rounded-2xl text-sm outline-none" style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);"></div>
                            <div><label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                                <input type="email" name="email" :value="editUser?.email" required class="w-full px-4 py-3 rounded-2xl text-sm outline-none" style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);"></div>
                            <div><label class="block text-sm font-medium text-gray-300 mb-2">Role</label>
                                <select name="role" required class="w-full px-4 py-3 rounded-2xl text-sm outline-none" style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                                    @foreach(['siswa'=>'Siswa','guru'=>'Guru','kepsek'=>'Kepala Sekolah','admin'=>'Administrator'] as $v=>$l)<option value="{{ $v }}" :selected="editUser?.role==='{{ $v }}'" style="background:#0a0a14">{{ $l }}</option>@endforeach
                                </select></div>
                            <div>
                                <button type="button" @click="gantiSandi=!gantiSandi" class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-sm transition-all" :style="gantiSandi?'background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.3);color:#fb923c;':'background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:#9ca3af;'">
                                    <span>Ubah Kata Sandi</span>
                                    <svg class="w-4 h-4 transition-transform" :class="gantiSandi?'rotate-180':''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="gantiSandi" x-transition class="mt-3 space-y-3 p-4 rounded-2xl" style="background:rgba(249,115,22,0.04);border:1px solid rgba(249,115,22,0.15);">
                                    <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengubah.</p>
                                    <div><label class="block text-xs font-medium text-gray-400 mb-1.5">Kata Sandi Baru</label>
                                        <input :type="lihatSandi?'text':'password'" name="password" placeholder="Min. 6 karakter" class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none placeholder-gray-600" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);"></div>
                                    <div><label class="block text-xs font-medium text-gray-400 mb-1.5">Konfirmasi</label>
                                        <input :type="lihatSandi?'text':'password'" name="password_confirmation" placeholder="Ulangi kata sandi" class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none placeholder-gray-600" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);"></div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 flex justify-end gap-4" style="border-top:1px solid rgba(255,255,255,0.06);background:rgba(255,255,255,0.02);">
                            <button type="button" @click="modalOpen=false;gantiSandi=false" class="px-6 py-3 rounded-2xl text-sm font-medium text-gray-400" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);">Batal</button>
                            <button type="submit" class="px-6 py-3 rounded-2xl text-sm font-semibold text-white" style="background:linear-gradient(135deg,#f97316,#eab308);">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
