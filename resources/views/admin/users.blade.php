@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6" x-data="{ modalOpen: false, editUser: null, importOpen: false }">

        {{-- Header --}}
        <div class="flex flex-col gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold tracking-tight" style="color:var(--text-main)">Manajemen Pengguna
                </h1>
                <p class="text-sm mt-1" style="color:var(--text-muted)">Kelola akses dan data pengguna sistem STQM.</p>
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('admin.users.template') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-2xl font-semibold text-sm transition-all"
                    style="background:var(--btn-bg);border:1px solid var(--btn-border);color:var(--text-muted);">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <span class="hidden sm:inline">Template Excel</span>
                    <span class="sm:hidden">Template</span>
                </a>

                <button @click="importOpen = true"
                    class="flex items-center gap-2 px-3 py-2 rounded-2xl font-semibold text-white text-sm transition-all"
                    style="background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 4px 16px rgba(16,185,129,0.3);">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Import Excel
                </button>

                <button @click="modalOpen = true; editUser = null"
                    class="flex items-center gap-2 px-3 py-2 rounded-2xl font-semibold text-white text-sm transition-all"
                    style="background:linear-gradient(135deg,#f97316,#eab308);box-shadow:0 4px 16px rgba(249,115,22,0.3);">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </button>
            </div>

            {{-- MODAL IMPORT EXCEL --}}
            <div x-show="importOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="background:var(--overlay-bg);backdrop-filter:blur(8px);">
                <div x-show="importOpen" x-transition class="w-full max-w-md rounded-3xl overflow-hidden shadow-2xl"
                    style="background:var(--modal-bg);border:1px solid var(--modal-border);">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-xl stqm-modal-text">Import Siswa via Excel</h3>
                            <button @click="importOpen = false" class="p-2 rounded-xl"
                                style="background:var(--btn-bg);color:var(--text-muted);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data">
                            @csrf
                            <label
                                class="flex flex-col items-center justify-center w-full h-36 rounded-2xl cursor-pointer transition-all"
                                style="border:2px dashed rgba(16,185,129,0.4);background:rgba(16,185,129,0.05);"
                                x-data="{ filename: '' }" @dragover.prevent
                                @drop.prevent="filename = $event.dataTransfer.files[0]?.name ?? ''; $refs.fileInput.files = $event.dataTransfer.files;">
                                <svg class="w-8 h-8 mb-2" style="color:#10b981" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-sm font-medium" style="color:#10b981"
                                    x-text="filename || 'Klik atau drag file .xlsx di sini'"></p>
                                <p class="text-xs mt-1" style="color:var(--text-muted)">Format: .xlsx / .xls, maks 5 MB</p>
                                <input type="file" name="file_import" accept=".xlsx,.xls" class="hidden" x-ref="fileInput"
                                    @change="filename = $event.target.files[0]?.name ?? ''" />
                            </label>

                            @error('file_import')
                                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                            @enderror

                            <p class="text-xs mt-3" style="color:var(--text-muted)">
                                Belum punya template?
                                <a href="{{ route('admin.users.template') }}" class="underline"
                                    style="color:#10b981;">Download di sini</a>
                            </p>

                            <div class="flex gap-3 mt-6">
                                <button type="button" @click="importOpen = false"
                                    class="flex-1 px-4 py-3 rounded-2xl text-sm font-medium"
                                    style="background:var(--btn-bg);border:1px solid var(--btn-border);color:var(--text-muted);">
                                    Batal
                                </button>
                                <button type="submit" class="flex-1 px-4 py-3 rounded-2xl text-sm font-semibold text-white"
                                    style="background:linear-gradient(135deg,#10b981,#059669);">
                                    Proses Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
            <div class="rounded-3xl p-4 flex items-center gap-3"
                style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0"
                    style="background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.2);">
                    <svg class="w-5 h-5" fill="none" stroke="#60a5fa" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs" style="color:var(--text-muted)">Total</p>
                    <p class="text-xl font-bold" style="color:#60a5fa">{{ $stats['total_users'] }}</p>
                </div>
            </div>
            <div class="rounded-3xl p-4 flex items-center gap-3"
                style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0"
                    style="background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.2);">
                    <svg class="w-5 h-5" fill="none" stroke="#fb923c" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs" style="color:var(--text-muted)">Guru</p>
                    <p class="text-xl font-bold" style="color:#fb923c">{{ $stats['total_guru'] }}</p>
                </div>
            </div>
            <div class="rounded-3xl p-4 flex items-center gap-3"
                style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0"
                    style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);">
                    <svg class="w-5 h-5" fill="none" stroke="#fbbf24" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs" style="color:var(--text-muted)">Siswa</p>
                    <p class="text-xl font-bold" style="color:#fbbf24">{{ $stats['total_siswa'] }}</p>
                </div>
            </div>
            <div class="rounded-3xl p-4 flex items-center gap-3"
                style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0"
                    style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);">
                    <svg class="w-5 h-5" fill="none" stroke="#34d399" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs" style="color:var(--text-muted)">Kepsek</p>
                    <p class="text-xl font-bold" style="color:#34d399">{{ $stats['total_kepsek'] }}</p>
                </div>
            </div>
            <div class="rounded-3xl p-4 flex items-center gap-3"
                style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0"
                    style="background:rgba(139,92,246,0.1);border:1px solid rgba(139,92,246,0.2);">
                    <svg class="w-5 h-5" fill="none" stroke="#a78bfa" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs" style="color:var(--text-muted)">Admin</p>
                    <p class="text-xl font-bold" style="color:#a78bfa">{{ $stats['total_admin'] }}</p>
                </div>
            </div>
        </div>

        {{-- Notifikasi Hasil Import --}}
        @if (session('import_success'))
            <div class="rounded-3xl p-5 space-y-4"
                style="background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.2);">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                        style="background:rgba(16,185,129,0.15);">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-emerald-400 text-sm">{{ session('import_success') }}</p>
                        <div class="flex flex-wrap gap-4 mt-2 text-xs" style="color:var(--text-muted)">
                            <span>✓ {{ session('import_berhasil') }} berhasil</span>
                            @if(session('import_duplikat') > 0)<span>⚠ {{ session('import_duplikat') }} duplikat</span>@endif
                            @if(session('import_gagal') > 0)<span>✗ {{ session('import_gagal') }} gagal</span>@endif
                        </div>
                    </div>
                </div>
                @if(session('import_log') && count(session('import_log')) > 0)
                    <div class="rounded-2xl overflow-hidden table-responsive" style="border:1px solid var(--card-border);">
                        <div class="px-4 py-3 text-xs font-semibold"
                            style="background:var(--card-bg-soft);color:var(--text-muted);">Detail baris bermasalah</div>
                        <table class="w-full text-xs" style="min-width:480px;">
                            <thead>
                                <tr style="border-bottom:1px solid var(--card-border);">
                                    <th class="px-4 py-2 text-left" style="color:var(--text-muted);">Baris</th>
                                    <th class="px-4 py-2 text-left" style="color:var(--text-muted);">Nama</th>
                                    <th class="px-4 py-2 text-left" style="color:var(--text-muted);">Email</th>
                                    <th class="px-4 py-2 text-left" style="color:var(--text-muted);">Alasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(session('import_log') as $log)
                                    <tr style="border-bottom:1px solid var(--card-border-soft);">
                                        <td class="px-4 py-2" style="color:var(--text-muted);">#{{ $log['baris'] }}</td>
                                        <td class="px-4 py-2" style="color:var(--text-main);">{{ $log['nama'] }}</td>
                                        <td class="px-4 py-2" style="color:var(--text-muted);">{{ $log['email'] }}</td>
                                        <td class="px-4 py-2"><span class="px-2 py-0.5 rounded-lg text-xs"
                                                style="background:rgba(239,68,68,0.1);color:#f87171;">{{ $log['alasan'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif

        {{-- TABEL UTAMA --}}
        <div class="rounded-3xl overflow-hidden" style="background:var(--card-bg);border:1px solid var(--card-border);"
            x-data="bulkDelete({{ $selectableIds->toJson() }})">

            {{-- Search + Filter --}}
            <div class="p-4 md:p-6 flex flex-col gap-3"
                style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">

                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="flex-1" id="formSearch">
                        <input type="hidden" name="role" value="{{ $roleFilter }}">
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2"
                                    style="color:var(--text-muted)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" name="search" id="inputSearch" value="{{ request('search') }}"
                                    placeholder="Cari nama, email..." autocomplete="off"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-2xl text-sm outline-none"
                                    style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                            </div>
                            <button type="submit"
                                class="px-4 py-2.5 rounded-2xl text-sm font-semibold text-white flex items-center gap-1 transition-all shrink-0"
                                style="background:linear-gradient(135deg,#f97316,#eab308);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Cari
                            </button>
                        </div>
                    </form>
                </div>

                <div class="flex flex-wrap gap-2">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-1.5 flex-wrap">
                        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                        @foreach (['semua' => 'Semua', 'admin' => 'Admin', 'guru' => 'Guru', 'siswa' => 'Siswa', 'kepsek' => 'Kepsek'] as $val => $label)
                            <button type="submit" name="role" value="{{ $val }}"
                                class="px-3 py-1.5 rounded-xl text-xs font-medium transition-all"
                                style="{{ $roleFilter === $val ? 'background: linear-gradient(135deg, #f97316, #eab308); color: white;' : 'background: var(--btn-bg); border: 1px solid var(--btn-border); color: var(--text-muted);' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </form>

                    <button type="button" @click="toggleSelectionMode()"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition-all"
                        :style="selectionMode
                                ? 'background:rgba(239,68,68,0.15);border:1.5px solid rgba(239,68,68,0.4);color:#f87171;'
                                : 'background:var(--btn-bg);border:1.5px solid var(--btn-border);color:var(--text-muted);'">
                        <span x-text="selectionMode ? 'Nonaktifkan' : 'Mode Hapus'"></span>
                    </button>
                </div>

                <div x-show="selectionMode && selected.length === 0" x-transition
                    class="text-xs px-3 py-1.5 rounded-xl w-fit"
                    style="background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.15);color:#f87171;">
                    💡 Centang pengguna yang ingin dihapus
                </div>
            </div>

            {{-- Toolbar Bulk Delete --}}
            <div x-show="selected.length > 0" x-transition
                class="px-4 md:px-6 py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 flex-wrap"
                style="background:rgba(239,68,68,0.08);border-bottom:2px solid rgba(239,68,68,0.25);">
                <span class="text-sm font-semibold" style="color:#f87171">
                    <span x-text="selected.length">0</span> akun dipilih
                </span>
                <div class="flex items-center gap-2 flex-wrap">
                    <button type="button" @click="selectAll()" class="px-3 py-1.5 rounded-xl text-xs font-medium"
                        style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);color:#f87171;">
                        Pilih Semua (<span x-text="pageIds.length"></span>)
                    </button>
                    <button type="button" @click="clearSelection()" class="px-3 py-1.5 rounded-xl text-xs font-medium"
                        style="background:var(--btn-bg);border:1px solid var(--btn-border);color:var(--text-muted);">
                        Batalkan
                    </button>
                    <form method="POST" action="{{ route('admin.users.bulk-destroy') }}"
                        @submit.prevent="confirmBulkDelete($el)">
                        @csrf
                        <div id="bulk-hidden-inputs"></div>
                        <button type="submit"
                            class="flex items-center gap-1.5 px-4 py-1.5 rounded-xl text-xs font-semibold text-white"
                            style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                            Hapus <span x-text="selected.length">0</span>
                        </button>
                    </form>
                </div>
            </div>

            @if(request('search'))
                <div class="px-4 md:px-6 py-3 flex items-center gap-3 text-sm flex-wrap"
                    style="background:rgba(249,115,22,0.06);border-bottom:1px solid var(--card-divider);">
                    <span style="color:var(--text-muted);">
                        Hasil: <strong style="color:var(--text-main);">"{{ request('search') }}"</strong>
                        — <strong style="color:#f97316;">{{ $users->total() }} pengguna</strong>
                    </span>
                    <a href="{{ route('admin.users.index', ['role' => $roleFilter]) }}"
                        class="ml-auto text-xs font-medium px-3 py-1.5 rounded-xl"
                        style="color:#f87171;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);">
                        ✕ Hapus filter
                    </a>
                </div>
            @endif

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="w-full text-left" style="min-width:520px;">
                    <thead>
                        <tr class="text-xs"
                            style="color:var(--text-muted);border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                            <th class="font-medium transition-all duration-300" :class="selectionMode ? 'p-4' : 'p-0'"
                                :style="selectionMode ? 'width:3rem;opacity:1;' : 'width:0;overflow:hidden;opacity:0;'">
                                <input type="checkbox" x-ref="checkAll" x-show="selectionMode"
                                    class="w-4 h-4 rounded cursor-pointer accent-red-500"
                                    x-effect="$el.checked = allSelected()" @change="toggleAll($event)">
                            </th>
                            <th class="p-4 font-medium">Nama</th>
                            <th class="p-4 font-medium hidden sm:table-cell">Email</th>
                            <th class="p-4 font-medium">Role</th>
                            <th class="p-4 font-medium hidden md:table-cell">Dibuat</th>
                            <th class="p-4 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($users as $user)
                            <tr style="border-bottom:1px solid var(--card-border-soft);transition:background 0.15s;"
                                :style="selected.includes({{ $user->id }}) ? 'background:rgba(239,68,68,0.06);' : ''">

                                <td class="transition-all duration-300" :class="selectionMode ? 'p-4' : 'p-0'"
                                    :style="selectionMode ? 'width:3rem;opacity:1;' : 'width:0;overflow:hidden;opacity:0;'">
                                    @if($user->id !== auth()->id())
                                        <input type="checkbox" x-show="selectionMode"
                                            class="w-4 h-4 rounded cursor-pointer accent-red-500"
                                            x-effect="$el.checked = selected.includes({{ $user->id }})"
                                            @change="toggle({{ $user->id }})">
                                    @else
                                        <div x-show="selectionMode" class="w-4 h-4 rounded"
                                            style="background:var(--btn-bg);border:1px solid var(--btn-border);"></div>
                                    @endif
                                </td>

                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-sm shrink-0"
                                            :style="selected.includes({{ $user->id }})
                                                        ? 'background:rgba(239,68,68,0.15);color:#f87171;'
                                                        : 'background:rgba(232,86,10,0.12);color:#E8560A;'">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="font-semibold block truncate"
                                                style="color:var(--text-main)">{{ $user->name }}</span>
                                            <span class="text-xs sm:hidden block truncate"
                                                style="color:var(--text-muted)">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4 hidden sm:table-cell" style="color:var(--text-muted)">{{ $user->email }}</td>

                                <td class="p-4">
                                    @php
                                        $rs = match ($user->role) {
                                            'admin' => ['bg' => 'rgba(139,92,246,0.1)', 'color' => '#a78bfa', 'label' => 'Admin'],
                                            'kepsek' => ['bg' => 'rgba(16,185,129,0.1)', 'color' => '#34d399', 'label' => 'Kepsek'],
                                            'guru' => ['bg' => 'rgba(249,115,22,0.1)', 'color' => '#fb923c', 'label' => 'Guru'],
                                            'siswa' => ['bg' => 'rgba(59,130,246,0.1)', 'color' => '#60a5fa', 'label' => 'Siswa'],
                                            default => ['bg' => 'rgba(255,255,255,0.05)', 'color' => '#9ca3af', 'label' => $user->role],
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-xl text-xs font-bold"
                                        style="background:{{ $rs['bg'] }};color:{{ $rs['color'] }};">
                                        {{ $rs['label'] }}
                                    </span>
                                </td>

                                <td class="p-4 text-xs hidden md:table-cell" style="color:var(--text-muted)">
                                    {{ $user->created_at->format('d M Y') }}</td>

                                <td class="p-4">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button @click="modalOpen = true; editUser = {{ $user->toJson() }}"
                                            class="p-2 rounded-xl transition-all"
                                            style="background:var(--btn-bg);border:1px solid var(--btn-border);color:var(--text-muted);"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                                class="swal-delete hapus-single" data-nama="{{ $user->name }}"
                                                :style="selectionMode ? 'display:none' : ''">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 rounded-xl transition-all"
                                                    style="background:var(--btn-bg);border:1px solid var(--btn-border);color:var(--text-muted);"
                                                    title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                                <td colspan="6" class="p-10 text-center text-sm" style="color:var(--text-muted)">Tidak ada
                                    pengguna ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="p-4" style="border-top:1px solid var(--card-divider);">{{ $users->links() }}</div>
            @endif
        </div>

        {{-- Modal Tambah / Edit --}}
        <div x-show="modalOpen" x-transition
            class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
            style="background:var(--overlay-bg);backdrop-filter:blur(8px);">
            <div x-show="modalOpen" x-transition
                class="w-full sm:max-w-md rounded-t-3xl sm:rounded-3xl overflow-hidden shadow-2xl max-h-screen overflow-y-auto"
                style="background:var(--modal-bg);border:1px solid var(--modal-border);">
                <div class="p-5 flex justify-between items-center sticky top-0 z-10"
                    style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                    <h3 class="font-bold text-lg stqm-modal-text"
                        x-text="editUser ? 'Edit Pengguna' : 'Tambah Pengguna Baru'"></h3>
                    <button @click="modalOpen = false" class="p-2 rounded-xl"
                        style="background:var(--btn-bg);color:var(--text-muted);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                {{-- Form Tambah --}}
                <div x-show="!editUser">
                    <form method="POST" action="{{ route('admin.users.store') }}">@csrf
                        <div class="p-6 space-y-4">
                            <div><label class="block text-sm font-medium mb-1.5 stqm-modal-text">Nama Lengkap</label>
                                <input type="text" name="name" required placeholder="Masukkan nama lengkap..."
                                    class="w-full px-4 py-3 rounded-2xl text-sm outline-none stqm-modal-input">
                            </div>
                            <div><label class="block text-sm font-medium mb-1.5 stqm-modal-text">Email</label>
                                <input type="email" name="email" required placeholder="email@stqm.sch.id"
                                    class="w-full px-4 py-3 rounded-2xl text-sm outline-none stqm-modal-input">
                            </div>
                            <div><label class="block text-sm font-medium mb-1.5 stqm-modal-text">Role</label>
                                <select name="role" required
                                    class="w-full px-4 py-3 rounded-2xl text-sm outline-none stqm-modal-input">
                                    @foreach(['siswa' => 'Siswa', 'guru' => 'Guru', 'kepsek' => 'Kepala Sekolah', 'admin' => 'Administrator'] as $v => $l)
                                    <option value="{{ $v }}" style="background:var(--modal-bg)">{{ $l }}</option>@endforeach
                                </select>
                            </div>
                            <div><label class="block text-sm font-medium mb-1.5 stqm-modal-text">Password</label>
                                <input type="password" name="password" required placeholder="Minimal 6 karakter"
                                    class="w-full px-4 py-3 rounded-2xl text-sm outline-none stqm-modal-input">
                            </div>
                        </div>
                        <div class="p-5 flex justify-end gap-3"
                            style="border-top:1px solid var(--card-divider);background:var(--card-bg-soft);">
                            <button type="button" @click="modalOpen=false"
                                class="px-5 py-2.5 rounded-2xl text-sm font-medium"
                                style="background:var(--btn-bg);border:1px solid var(--btn-border);color:var(--text-muted);">Batal</button>
                            <button type="submit" class="px-5 py-2.5 rounded-2xl text-sm font-semibold text-white"
                                style="background:linear-gradient(135deg,#f97316,#eab308);">Simpan</button>
                        </div>
                    </form>
                </div>
                {{-- Form Edit --}}
                <div x-show="editUser" x-data="{gantiSandi:false}">
                    <form method="POST" :action="`/admin/users/${editUser?.id}`">@csrf @method('PUT')
                        <div class="p-6 space-y-4">
                            <div><label class="block text-sm font-medium mb-1.5 stqm-modal-text">Nama Lengkap</label>
                                <input type="text" name="name" :value="editUser?.name" required
                                    class="w-full px-4 py-3 rounded-2xl text-sm outline-none stqm-modal-input">
                            </div>
                            <div><label class="block text-sm font-medium mb-1.5 stqm-modal-text">Email</label>
                                <input type="email" name="email" :value="editUser?.email" required
                                    class="w-full px-4 py-3 rounded-2xl text-sm outline-none stqm-modal-input">
                            </div>
                            <div><label class="block text-sm font-medium mb-1.5 stqm-modal-text">Role</label>
                                <select name="role" required
                                    class="w-full px-4 py-3 rounded-2xl text-sm outline-none stqm-modal-input">
                                    @foreach(['siswa' => 'Siswa', 'guru' => 'Guru', 'kepsek' => 'Kepala Sekolah', 'admin' => 'Administrator'] as $v => $l)
                                        <option value="{{ $v }}" :selected="editUser?.role==='{{ $v }}'"
                                    style="background:var(--modal-bg)">{{ $l }}</option>@endforeach
                                </select>
                            </div>
                            <div>
                                <button type="button" @click="gantiSandi=!gantiSandi"
                                    class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-sm transition-all"
                                    :style="gantiSandi?'background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.3);color:#fb923c;':'background:var(--btn-bg);border:1px solid var(--btn-border);color:var(--text-muted);'">
                                    <span>Ubah Kata Sandi</span>
                                    <svg class="w-4 h-4 transition-transform" :class="gantiSandi?'rotate-180':''"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="gantiSandi" x-transition class="mt-3 space-y-3 p-4 rounded-2xl"
                                    style="background:rgba(249,115,22,0.04);border:1px solid rgba(249,115,22,0.15);">
                                    <p class="text-xs" style="color:var(--text-muted)">Kosongkan jika tidak ingin mengubah.
                                    </p>
                                    <input type="password" name="password" placeholder="Kata Sandi Baru"
                                        class="w-full px-4 py-3 rounded-2xl text-sm outline-none stqm-modal-input">
                                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Sandi"
                                        class="w-full px-4 py-3 rounded-2xl text-sm outline-none stqm-modal-input">
                                </div>
                            </div>
                        </div>
                        <div class="p-5 flex justify-end gap-3"
                            style="border-top:1px solid var(--card-divider);background:var(--card-bg-soft);">
                            <button type="button" @click="modalOpen=false;gantiSandi=false"
                                class="px-5 py-2.5 rounded-2xl text-sm font-medium"
                                style="background:var(--btn-bg);border:1px solid var(--btn-border);color:var(--text-muted);">Batal</button>
                            <button type="submit" class="px-5 py-2.5 rounded-2xl text-sm font-semibold text-white"
                                style="background:linear-gradient(135deg,#f97316,#eab308);">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                function bulkDelete(pageIds) {
                    return {
                        pageIds: pageIds || [],
                        selected: [],
                        selectionMode: false,
                        init() {
                            this.$watch('selected', () => this.syncCheckAll());
                            this.$watch('selectionMode', (val) => {
                                if (!val) this.selected = [];
                                this.$nextTick(() => this.syncCheckAll());
                            });
                        },
                        toggleSelectionMode() { this.selectionMode = !this.selectionMode; },
                        syncCheckAll() {
                            const el = this.$refs.checkAll;
                            if (!el) return;
                            const total = this.pageIds.length, checked = this.selected.length;
                            if (total === 0 || checked === 0) { el.indeterminate = false; el.checked = false; }
                            else if (checked === total) { el.indeterminate = false; el.checked = true; }
                            else { el.indeterminate = true; el.checked = false; }
                        },
                        toggle(id) { this.selected = this.selected.includes(id) ? this.selected.filter(i => i !== id) : [...this.selected, id]; },
                        toggleAll(event) { this.selected = event.target.checked ? [...this.pageIds] : []; },
                        selectAll() { this.selected = [...this.pageIds]; },
                        clearSelection() { this.selected = []; },
                        allSelected() { return this.pageIds.length > 0 && this.pageIds.every(id => this.selected.includes(id)); },
                        confirmBulkDelete(form) {
                            if (this.selected.length === 0) return;
                            const jumlah = this.selected.length;
                            const t = getSwalTheme();
                            Swal.fire({
                                icon: 'warning', title: `Hapus ${jumlah} akun?`,
                                html: `Tindakan ini <strong>tidak dapat dibatalkan</strong>.`,
                                showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#6b7280',
                                confirmButtonText: `Ya, Hapus!`, cancelButtonText: 'Batal',
                                background: t.background, color: t.color, customClass: { popup: 'swal2-popup' }
                            }).then((result) => {
                                if (!result.isConfirmed) return;
                                const container = form.querySelector('#bulk-hidden-inputs');
                                if (!container) return;
                                container.innerHTML = '';
                                this.selected.forEach(id => {
                                    const input = document.createElement('input');
                                    input.type = 'hidden'; input.name = 'user_ids[]'; input.value = id;
                                    container.appendChild(input);
                                });
                                form.submit();
                            });
                        }
                    };
                }
            </script>
        @endpush
    </div>

    <script>
        function clearSearch() {
            document.getElementById('inputSearch').value = '';
            document.getElementById('formSearch').submit();
        }
    </script>

@endsection
