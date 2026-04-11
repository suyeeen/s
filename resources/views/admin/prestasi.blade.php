@extends('layouts.app')

@section('title', 'Konfirmasi Prestasi Guru')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8" x-data="{ tab: 'menunggu' }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Konfirmasi Prestasi</h1>
                <p class="text-gray-400 mt-2">Verifikasi data prestasi guru sebelum masuk ke laporan.</p>
            </div>
            @if ($prestasi_menunggu->total() > 0)
                <div class="flex items-center gap-2 px-5 py-3 rounded-2xl text-sm font-semibold"
                    style="background: rgba(249,115,22,0.1); border: 1px solid rgba(249,115,22,0.25); color: #fb923c;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                    {{ $prestasi_menunggu->total() }} menunggu verifikasi
                </div>
            @endif
        </div>

        {{-- Tab Navigation --}}
        <div class="flex gap-2 p-1 rounded-2xl w-fit"
            style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
            @foreach ([
            'menunggu' => ['label' => 'Menunggu', 'count' => $prestasi_menunggu->total(), 'color' => 'rgba(249,115,22,0.15)', 'border' => 'rgba(249,115,22,0.3)', 'text' => '#fb923c'],
            'tervalidasi' => ['label' => 'Tervalidasi', 'count' => $prestasi_tervalidasi->total(), 'color' => 'rgba(16,185,129,0.15)', 'border' => 'rgba(16,185,129,0.3)', 'text' => '#34d399'],
            'ditolak' => ['label' => 'Ditolak', 'count' => $prestasi_ditolak->total(), 'color' => 'rgba(239,68,68,0.15)', 'border' => 'rgba(239,68,68,0.3)', 'text' => '#f87171'],
        ] as $key => $cfg)
                <button @click="tab = '{{ $key }}'"
                    class="px-4 py-2 rounded-xl text-sm font-medium transition-all flex items-center gap-2"
                    :style="tab === '{{ $key }}'
                        ?
                        'background: {{ $cfg['color'] }}; border: 1px solid {{ $cfg['border'] }}; color: {{ $cfg['text'] }};' :
                        'color: #6b7280; border: 1px solid transparent;'">
                    {{ $cfg['label'] }}
                    <span class="px-2 py-0.5 rounded-lg text-xs font-bold"
                        :style="tab === '{{ $key }}'
                            ?
                            'background: {{ $cfg['color'] }}; color: {{ $cfg['text'] }};' :
                            'background: rgba(255,255,255,0.06); color: #6b7280;'">
                        {{ $cfg['count'] }}
                    </span>
                </button>
            @endforeach
        </div>

        {{-- ═══ TAB: MENUNGGU ═══ --}}
        <div x-show="tab === 'menunggu'" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="rounded-3xl overflow-hidden"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase tracking-wide"
                                style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                                <th class="p-5 font-medium">Guru</th>
                                <th class="p-5 font-medium">Prestasi</th>
                                <th class="p-5 font-medium">Kategori</th>
                                <th class="p-5 font-medium">Tingkat</th>
                                <th class="p-5 font-medium">Tahun</th>
                                <th class="p-5 font-medium">Bukti</th>
                                <th class="p-5 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse ($prestasi_menunggu as $item)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);"
                                    onmouseover="this.style.background='rgba(255,255,255,0.03)'"
                                    onmouseout="this.style.background='transparent'">
                                    <td class="p-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm shrink-0"
                                                style="background: linear-gradient(135deg, rgba(249,115,22,0.3), rgba(234,179,8,0.3)); color: #fbbf24;">
                                                {{ strtoupper(substr($item->guru->nama ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-white">{{ $item->guru->nama ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="p-5 text-gray-300 max-w-xs">
                                        <p class="truncate">{{ $item->nama_prestasi }}</p>
                                    </td>
                                    <td class="p-5">
                                        @php
                                            $katColor = match ($item->kategori) {
                                                'Sertifikasi' => [
                                                    'bg' => 'rgba(99,102,241,0.1)',
                                                    'color' => '#a5b4fc',
                                                    'border' => 'rgba(99,102,241,0.2)',
                                                ],
                                                'Pelatihan' => [
                                                    'bg' => 'rgba(59,130,246,0.1)',
                                                    'color' => '#93c5fd',
                                                    'border' => 'rgba(59,130,246,0.2)',
                                                ],
                                                'Penghargaan' => [
                                                    'bg' => 'rgba(234,179,8,0.1)',
                                                    'color' => '#fde047',
                                                    'border' => 'rgba(234,179,8,0.2)',
                                                ],
                                                'Publikasi' => [
                                                    'bg' => 'rgba(168,85,247,0.1)',
                                                    'color' => '#d8b4fe',
                                                    'border' => 'rgba(168,85,247,0.2)',
                                                ],
                                                default => [
                                                    'bg' => 'rgba(255,255,255,0.05)',
                                                    'color' => '#9ca3af',
                                                    'border' => 'rgba(255,255,255,0.1)',
                                                ],
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-xl text-xs font-semibold"
                                            style="background: {{ $katColor['bg'] }}; color: {{ $katColor['color'] }}; border: 1px solid {{ $katColor['border'] }};">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="p-5">
                                        @php
                                            $tingkatColor = match ($item->tingkat) {
                                                'internasional' => [
                                                    'bg' => 'rgba(249,115,22,0.1)',
                                                    'color' => '#fb923c',
                                                    'border' => 'rgba(249,115,22,0.2)',
                                                ],
                                                'nasional' => [
                                                    'bg' => 'rgba(239,68,68,0.1)',
                                                    'color' => '#fca5a5',
                                                    'border' => 'rgba(239,68,68,0.2)',
                                                ],
                                                'provinsi' => [
                                                    'bg' => 'rgba(234,179,8,0.1)',
                                                    'color' => '#fde047',
                                                    'border' => 'rgba(234,179,8,0.2)',
                                                ],
                                                'kota' => [
                                                    'bg' => 'rgba(16,185,129,0.1)',
                                                    'color' => '#6ee7b7',
                                                    'border' => 'rgba(16,185,129,0.2)',
                                                ],
                                                'kecamatan' => [
                                                    'bg' => 'rgba(59,130,246,0.1)',
                                                    'color' => '#93c5fd',
                                                    'border' => 'rgba(59,130,246,0.2)',
                                                ],
                                                default => [
                                                    'bg' => 'rgba(255,255,255,0.05)',
                                                    'color' => '#9ca3af',
                                                    'border' => 'rgba(255,255,255,0.1)',
                                                ],
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-xl text-xs font-semibold capitalize"
                                            style="background: {{ $tingkatColor['bg'] }}; color: {{ $tingkatColor['color'] }}; border: 1px solid {{ $tingkatColor['border'] }};">
                                            {{ $item->tingkat }}
                                        </span>
                                    </td>
                                    <td class="p-5 text-gray-400 text-xs">{{ $item->tahun }}</td>
                                    <td class="p-5">
                                        @if ($item->file_bukti)
                                            <a href="{{ asset('storage/' . $item->file_bukti) }}" target="_blank"
                                                class="flex items-center gap-1.5 text-xs font-medium hover:text-amber-400 transition-colors"
                                                style="color: #60a5fa;">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-600">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="p-5">
                                        <div class="flex items-center justify-end gap-2">

                                            {{-- Tombol Setujui → SweetAlert konfirmasi --}}
                                            <form method="POST"
                                                action="{{ route('admin.prestasi.verifikasi', $item->id) }}"
                                                class="swal-confirm-form" data-judul="Setujui Prestasi?"
                                                data-pesan="Prestasi {{ $item->nama_prestasi }} akan diverifikasi dan dianggap valid."
                                                data-icon="success" data-confirm-color="#10b981"
                                                data-confirm-text="Ya, Setujui!">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button"
                                                    class="swal-form-trigger flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                                                    style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); color: #34d399;"
                                                    onmouseover="this.style.background='rgba(16,185,129,0.2)'"
                                                    onmouseout="this.style.background='rgba(16,185,129,0.1)'">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Setujui
                                                </button>
                                            </form>

                                            {{-- Tombol Tolak → SweetAlert dengan textarea --}}
                                            <button type="button"
                                                class="swal-tolak flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                                                data-id="{{ $item->id }}" data-nama="{{ $item->nama_prestasi }}"
                                                data-url="{{ route('admin.prestasi.tolak', $item->id) }}"
                                                style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #f87171;"
                                                onmouseover="this.style.background='rgba(239,68,68,0.2)'"
                                                onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                                                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06);">
                                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 text-sm">Tidak ada prestasi yang menunggu verifikasi
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($prestasi_menunggu->hasPages())
                    <div class="p-5" style="border-top: 1px solid rgba(255,255,255,0.06);">
                        {{ $prestasi_menunggu->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- ═══ TAB: TERVALIDASI ═══ --}}
        <div x-show="tab === 'tervalidasi'" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="rounded-3xl overflow-hidden"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase tracking-wide"
                                style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                                <th class="p-5 font-medium">Guru</th>
                                <th class="p-5 font-medium">Prestasi</th>
                                <th class="p-5 font-medium">Kategori</th>
                                <th class="p-5 font-medium">Tingkat</th>
                                <th class="p-5 font-medium">Tahun</th>
                                <th class="p-5 font-medium">Divalidasi</th>
                                <th class="p-5 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse ($prestasi_tervalidasi as $item)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);"
                                    onmouseover="this.style.background='rgba(255,255,255,0.03)'"
                                    onmouseout="this.style.background='transparent'">
                                    <td class="p-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm shrink-0"
                                                style="background: linear-gradient(135deg, rgba(16,185,129,0.2), rgba(59,130,246,0.2)); color: #6ee7b7;">
                                                {{ strtoupper(substr($item->guru->nama ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-white">{{ $item->guru->nama ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="p-5 text-gray-300 max-w-xs">
                                        <p class="truncate">{{ $item->nama_prestasi }}</p>
                                    </td>
                                    <td class="p-5 text-gray-400 text-xs">{{ $item->kategori }}</td>
                                    <td class="p-5 text-gray-400 text-xs capitalize">{{ $item->tingkat }}</td>
                                    <td class="p-5 text-gray-400 text-xs">{{ $item->tahun }}</td>
                                    <td class="p-5 text-gray-500 text-xs">
                                        {{ $item->divalidasi_at ? \Carbon\Carbon::parse($item->divalidasi_at)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="p-5 text-right">
                                        <form method="POST" action="{{ route('admin.prestasi.reset', $item->id) }}"
                                            class="swal-confirm-form" data-judul="Reset Prestasi?"
                                            data-pesan="Prestasi ini akan dikembalikan ke status menunggu."
                                            data-icon="warning" data-confirm-color="#f59e0b"
                                            data-confirm-text="Ya, Reset!">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button"
                                                class="swal-form-trigger px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                                                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); color: #6b7280;"
                                                onmouseover="this.style.color='#f59e0b'; this.style.borderColor='rgba(245,158,11,0.3)'"
                                                onmouseout="this.style.color='#6b7280'; this.style.borderColor='rgba(255,255,255,0.08)'">
                                                Reset
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-16 text-center text-gray-500 text-sm">
                                        Belum ada prestasi yang tervalidasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($prestasi_tervalidasi->hasPages())
                    <div class="p-5" style="border-top: 1px solid rgba(255,255,255,0.06);">
                        {{ $prestasi_tervalidasi->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- ═══ TAB: DITOLAK ═══ --}}
        <div x-show="tab === 'ditolak'" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="rounded-3xl overflow-hidden"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase tracking-wide"
                                style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                                <th class="p-5 font-medium">Guru</th>
                                <th class="p-5 font-medium">Prestasi</th>
                                <th class="p-5 font-medium">Kategori</th>
                                <th class="p-5 font-medium">Tingkat</th>
                                <th class="p-5 font-medium">Tahun</th>
                                <th class="p-5 font-medium">Ditolak Pada</th>
                                <th class="p-5 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse ($prestasi_ditolak as $item)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);"
                                    onmouseover="this.style.background='rgba(255,255,255,0.03)'"
                                    onmouseout="this.style.background='transparent'">
                                    <td class="p-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm shrink-0"
                                                style="background: rgba(239,68,68,0.15); color: #fca5a5;">
                                                {{ strtoupper(substr($item->guru->nama ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-white">{{ $item->guru->nama ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="p-5 text-gray-300 max-w-xs">
                                        <p class="truncate">{{ $item->nama_prestasi }}</p>
                                    </td>
                                    <td class="p-5 text-gray-400 text-xs">{{ $item->kategori }}</td>
                                    <td class="p-5 text-gray-400 text-xs capitalize">{{ $item->tingkat }}</td>
                                    <td class="p-5 text-gray-400 text-xs">{{ $item->tahun }}</td>
                                    <td class="p-5 text-gray-500 text-xs">
                                        {{ $item->divalidasi_at ? \Carbon\Carbon::parse($item->divalidasi_at)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="p-5 text-right">
                                        <form method="POST" action="{{ route('admin.prestasi.reset', $item->id) }}"
                                            class="swal-confirm-form" data-judul="Kembalikan Prestasi?"
                                            data-pesan="Prestasi ini akan dikembalikan ke antrian menunggu agar guru dapat merevisi."
                                            data-icon="question" data-confirm-color="#f97316"
                                            data-confirm-text="Ya, Kembalikan!">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button"
                                                class="swal-form-trigger px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                                                style="background: rgba(249,115,22,0.1); border: 1px solid rgba(249,115,22,0.2); color: #fb923c;"
                                                onmouseover="this.style.background='rgba(249,115,22,0.2)'"
                                                onmouseout="this.style.background='rgba(249,115,22,0.1)'">
                                                Kembalikan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-16 text-center text-gray-500 text-sm">
                                        Tidak ada prestasi yang ditolak.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($prestasi_ditolak->hasPages())
                    <div class="p-5" style="border-top: 1px solid rgba(255,255,255,0.06);">
                        {{ $prestasi_ditolak->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ── Form tolak tersembunyi (disubmit via SweetAlert) ── --}}
    <form id="form-tolak-hidden" method="POST" action="" style="display:none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="alasan" id="input-alasan-tolak">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function getSwalTheme() {
                const theme = localStorage.getItem('stqm-theme') || 'dark';
                return {
                    background: theme === 'dark' ? '#0e0e1a' : '#ffffff',
                    color: theme === 'dark' ? '#ffffff' : '#0f172a',
                };
            }

            // ── Konfirmasi umum (Setujui, Reset, Kembalikan) ──────────────────
            document.querySelectorAll('.swal-form-trigger').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const form = btn.closest('.swal-confirm-form');
                    const judul = form.dataset.judul || 'Konfirmasi';
                    const pesan = form.dataset.pesan || 'Lanjutkan aksi ini?';
                    const icon = form.dataset.icon || 'question';
                    const confirmColor = form.dataset.confirmColor || '#f97316';
                    const confirmText = form.dataset.confirmText || 'Ya, Lanjutkan!';
                    const t = getSwalTheme();

                    Swal.fire({
                        icon: icon,
                        title: judul,
                        text: pesan,
                        showCancelButton: true,
                        confirmButtonColor: confirmColor,
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: confirmText,
                        cancelButtonText: 'Batal',
                        background: t.background,
                        color: t.color,
                        customClass: {
                            popup: 'swal2-popup'
                        },
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // ── Tombol Tolak → SweetAlert dengan input alasan ─────────────────
            document.querySelectorAll('.swal-tolak').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const url = btn.dataset.url;
                    const nama = btn.dataset.nama || 'prestasi ini';
                    const t = getSwalTheme();

                    Swal.fire({
                        title: 'Tolak Prestasi?',
                        html: `
                            <p style="color: ${t.color === '#ffffff' ? '#9ca3af' : '#64748b'}; font-size: 14px; margin-bottom: 16px;">
                                Prestasi <strong style="color: ${t.color}">${nama}</strong> akan ditolak.
                                Guru dapat mengajukan ulang setelah diperbaiki.
                            </p>
                            <textarea id="swal-alasan" rows="3"
                                placeholder="Alasan penolakan (opsional)..."
                                style="
                                    width: 100%;
                                    padding: 12px 16px;
                                    border-radius: 16px;
                                    background: rgba(255,255,255,0.05);
                                    border: 1px solid rgba(255,255,255,0.12);
                                    color: ${t.color};
                                    font-size: 13px;
                                    outline: none;
                                    resize: none;
                                    box-sizing: border-box;
                                "
                                onfocus="this.style.borderColor='rgba(239,68,68,0.5)'"
                                onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                            </textarea>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Tolak!',
                        cancelButtonText: 'Batal',
                        background: t.background,
                        color: t.color,
                        customClass: {
                            popup: 'swal2-popup'
                        },
                        preConfirm: () => {
                            return document.getElementById('swal-alasan').value;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const formTolak = document.getElementById('form-tolak-hidden');
                            formTolak.action = url;
                            document.getElementById('input-alasan-tolak').value = result
                                .value || '';
                            formTolak.submit();
                        }
                    });
                });
            });

        });
    </script>
@endsection
