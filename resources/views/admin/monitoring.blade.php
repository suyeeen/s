@extends('layouts.app')
@section('title', 'Monitoring Sistem')
@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-bold tracking-tight" style="color: var(--text-main)">Monitoring Sistem</h1>
        <p class="mt-2 text-sm" style="color: var(--text-muted)">Pantau aktivitas dan status operasional sistem STQM.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        @foreach ([
            ['label' => 'Total Guru',       'value' => $stats['total_guru'],    'color' => '#fb923c', 'bg' => 'rgba(249,115,22,0.1)',   'border' => 'rgba(249,115,22,0.2)'],
            ['label' => 'Total Siswa',      'value' => $stats['total_siswa'],   'color' => '#fbbf24', 'bg' => 'rgba(245,158,11,0.1)',   'border' => 'rgba(245,158,11,0.2)'],
            ['label' => 'Total Pengguna',   'value' => $stats['total_users'],   'color' => '#60a5fa', 'bg' => 'rgba(59,130,246,0.1)',   'border' => 'rgba(59,130,246,0.2)'],
            ['label' => 'Sudah Dipetakan',  'value' => $stats['sudah_dinilai'], 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.1)',   'border' => 'rgba(16,185,129,0.2)'],
        ] as $stat)
            <div class="rounded-3xl p-5 flex items-center gap-4"
                 style="background: var(--card-bg); border: 1px solid var(--card-border);">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"
                     style="background: {{ $stat['bg'] }}; border: 1px solid {{ $stat['border'] }};">
                    <span class="text-xl font-bold" style="color: {{ $stat['color'] }};">{{ $stat['value'] }}</span>
                </div>
                <div>
                    <p class="text-xs" style="color: var(--text-muted)">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold" style="color: var(--text-main)">{{ $stat['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Statistik Kuesioner --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        @foreach ([
            ['label' => 'Kuesioner dari Siswa', 'value' => $kuesionerStats['dari_siswa'], 'color' => '#a78bfa', 'bg' => 'rgba(139,92,246,0.1)', 'border' => 'rgba(139,92,246,0.2)'],
            ['label' => 'Kuesioner dari Guru',  'value' => $kuesionerStats['dari_guru'],  'color' => '#38bdf8', 'bg' => 'rgba(14,165,233,0.1)',  'border' => 'rgba(14,165,233,0.2)'],
            ['label' => 'Total Kuesioner',      'value' => $kuesionerStats['total'],      'color' => '#f472b6', 'bg' => 'rgba(236,72,153,0.1)',  'border' => 'rgba(236,72,153,0.2)'],
        ] as $stat)
            <div class="rounded-3xl p-5 flex items-center gap-4"
                 style="background: var(--card-bg); border: 1px solid var(--card-border);">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"
                     style="background: {{ $stat['bg'] }}; border: 1px solid {{ $stat['border'] }};">
                    <span class="text-xl font-bold" style="color: {{ $stat['color'] }};">{{ $stat['value'] }}</span>
                </div>
                <div>
                    <p class="text-xs" style="color: var(--text-muted)">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold" style="color: var(--text-main)">{{ $stat['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Status Server + Clustering --}}
        <div class="rounded-3xl p-6" style="background: var(--card-bg); border: 1px solid var(--card-border);">
            <h3 class="font-semibold text-lg mb-6" style="color: var(--text-main)">Status Server</h3>
            <div class="space-y-3">
                @foreach ([['label' => 'Web Server', 'status' => 'Online'], ['label' => 'Database', 'status' => 'Online'], ['label' => 'Python (K-Means)', 'status' => 'Siap'], ['label' => 'Storage', 'status' => 'Online']] as $srv)
                    <div class="flex items-center justify-between p-4 rounded-2xl"
                         style="background: var(--card-bg-soft); border: 1px solid var(--card-border-soft);">
                        <span class="text-sm" style="color: var(--text-muted)">{{ $srv['label'] }}</span>
                        <div class="flex items-center gap-2">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                            </span>
                            <span class="text-emerald-400 text-sm font-medium">{{ $srv['status'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 pt-6" style="border-top: 1px solid var(--card-divider);">
                <h4 class="text-sm font-medium mb-4" style="color: var(--text-muted)">Jalankan K-Means Clustering</h4>
                <form method="POST" action="{{ route('admin.clustering.run') }}" id="form-clustering">
                    @csrf
                    <button type="button"
                            class="swal-confirm w-full flex items-center justify-center gap-2 py-3 rounded-2xl text-sm font-semibold text-white transition-all"
                            data-judul="Jalankan Clustering?"
                            data-pesan="Proses ini akan memperbarui semua data cluster guru."
                            data-target="form-clustering"
                            style="background: linear-gradient(135deg, #8b5cf6, #6d28d9); box-shadow: 0 8px 32px rgba(139,92,246,0.3);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        Jalankan Clustering
                    </button>
                </form>
            </div>
        </div>

        {{-- Tabel User dengan Filter Role --}}
        <div class="lg:col-span-2 rounded-3xl overflow-hidden"
             style="background: var(--card-bg); border: 1px solid var(--card-border);">

            {{-- Header + Filter --}}
            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                 style="border-bottom: 1px solid var(--card-divider); background: var(--card-bg-soft);">
                <h3 class="font-semibold text-lg" style="color: var(--text-main)">Daftar Pengguna</h3>

                {{-- Filter Role --}}
                <form method="GET" action="{{ route('admin.monitoring') }}" class="flex gap-2 flex-wrap">
                    @foreach (['semua' => 'Semua', 'admin' => 'Admin', 'guru' => 'Guru', 'siswa' => 'Siswa', 'kepsek' => 'Kepsek'] as $val => $label)
                        <button type="submit" name="role" value="{{ $val }}"
                                class="px-4 py-1.5 rounded-xl text-xs font-medium transition-all"
                                style="{{ $roleFilter === $val
                                    ? 'background: linear-gradient(135deg, #f97316, #eab308); color: white;'
                                    : 'background: var(--btn-bg); border: 1px solid var(--btn-border); color: var(--text-muted);' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </form>
            </div>

            {{-- Tabel --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--card-divider); color: var(--text-muted);">
                            <th class="px-6 py-4 font-medium">Nama</th>
                            <th class="px-6 py-4 font-medium">Email</th>
                            <th class="px-6 py-4 font-medium">Role</th>
                            <th class="px-6 py-4 font-medium">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr style="border-bottom: 1px solid var(--card-border-soft);">
                                <td class="px-6 py-4 font-medium" style="color: var(--text-main)">{{ $user->name }}</td>
                                <td class="px-6 py-4" style="color: var(--text-muted)">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $roleStyle = match($user->role) {
                                            'admin'  => 'background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.2);',
                                            'guru'   => 'background: rgba(249,115,22,0.1); color: #fb923c; border: 1px solid rgba(249,115,22,0.2);',
                                            'siswa'  => 'background: rgba(59,130,246,0.1); color: #60a5fa; border: 1px solid rgba(59,130,246,0.2);',
                                            'kepsek' => 'background: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.2);',
                                            default  => 'background: rgba(255,255,255,0.05); color: #9ca3af;',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-medium capitalize"
                                          style="{{ $roleStyle }}">{{ $user->role }}</span>
                                </td>
                                <td class="px-6 py-4 text-xs" style="color: var(--text-muted)">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm" style="color: var(--text-muted)">
                                    Tidak ada pengguna dengan role ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($users->hasPages())
                <div class="px-6 py-4" style="border-top: 1px solid var(--card-divider);">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
