@extends('layouts.app')

@section('title', 'Laporan Evaluasi')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold" style="color:var(--text-main)" tracking-tight">Laporan Evaluasi Guru</h1>
                <p class="text-sm mt-2" style="color:var(--text-muted)">Daftar lengkap hasil pemetaan kualitas guru.</p>
            </div>
            <a href="{{ route('kepala.evaluasi.export') }}"
                class="flex items-center gap-2 px-5 py-3 rounded-2xl text-sm font-medium text-gray-300 transition-all"
                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export Excel
            </a>
        </div>

        <div class="rounded-3xl overflow-hidden" style="background:var(--card-bg);border:1px solid var(--card-border);">

            {{-- Filter --}}
            <div class="p-6 flex flex-col sm:flex-row gap-5"
                style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">

                <form method="GET" action="{{ route('kepala.evaluasi') }}" class="flex flex-col sm:flex-row gap-4 w-full">
                    <div class="relative flex-1">
                        <svg class="w-5 h-5 text-gray-500 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIP..."
                            class="w-full pl-12 pr-4 py-3 rounded-2xl text-sm outline-none"
                            style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                    </div>

                    <select name="cluster" onchange="this.form.submit()"
                        class="px-4 py-3 rounded-2xl text-white text-sm outline-none"
                        style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                        <option value="ALL" {{ $cluster === 'ALL' ? 'selected' : '' }} style="background:#0a0a14">Semua
                            Cluster</option>
                        @foreach (['A' => 'Cluster A (Sangat Baik)', 'B' => 'Cluster B (Baik)', 'C' => 'Cluster C (Cukup)', 'D' => 'Cluster D (Perlu Pembinaan)'] as $val => $label)
                            <option value="{{ $val }}" {{ $cluster === $val ? 'selected' : '' }} style="background:#0a0a14">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-6 py-3 rounded-2xl text-sm font-medium text-white transition-all"
                        style="background: linear-gradient(135deg, #f97316, #eab308);">
                        Cari
                    </button>
                </form>
            </div>

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="w-full text-left" style="min-width:640px;">
                    <thead>
                        <tr class="text-xs"
                            style="color:var(--text-muted);border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                            <th class="p-5 font-medium">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'dir' => $sort === 'nama' && $dir === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center gap-2 hover:text-white transition-colors">
                                    Nama Guru
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                </a>
                            </th>
                            <th class="p-5 font-medium">Mata Pelajaran</th>
                            <th class="p-5 font-medium">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'nilai_rata_rata', 'dir' => $sort === 'nilai_rata_rata' && $dir === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center gap-2 hover:text-white transition-colors">
                                    Skor
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                </a>
                            </th>
                            <th class="p-5 font-medium">Cluster</th>
                            <th class="p-5 font-medium">Kehadiran</th>
                            <th class="p-5 font-medium">Prestasi</th>
                            <th class="p-5"></th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($guru as $g)
                            <tr onclick="window.location='{{ route('kepala.guru.detail', $g->id) }}'"
                                class="cursor-pointer transition-colors"
                                style="border-bottom:1px solid var(--card-border-soft);"
                                onmouseover="this.style.background='rgba(26,22,19,0.03)'"
                                onmouseout="this.style.background='transparent'">

                                <td class="p-5">
                                    <p class="font-semibold text-white">{{ $g->nama }}</p>
                                    <p class="text-xs text-gray-500 mt-1">NIP: {{ $g->nip }}</p>
                                </td>
                                <td class="p-5 text-gray-400">{{ $g->mata_pelajaran }}</td>
                                <td class="p-5">
                                    @if ($g->clusterTerakhir)
                                        <span class="font-bold text-white">{{ $g->clusterTerakhir->nilai_rata_rata }}</span>
                                        <span class="text-xs text-gray-500 ml-1">/ 5.0</span>
                                    @else
                                        <span class="text-gray-600">—</span>
                                    @endif
                                </td>
                                <td class="p-5">
                                    @if ($g->clusterTerakhir)
                                        @php
                                            $cs = match ($g->clusterTerakhir->cluster) {
                                                'A'
                                                => 'background: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.2);',
                                                'B'
                                                => 'background: rgba(59,130,246,0.1); color: #60a5fa; border: 1px solid rgba(59,130,246,0.2);',
                                                'C'
                                                => 'background: rgba(245,158,11,0.1); color: #fbbf24; border: 1px solid rgba(245,158,11,0.2);',
                                                default
                                                => 'background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.2);',
                                            };
                                        @endphp
                                        <span class="px-3 py-1.5 rounded-xl text-xs font-bold" style="{{ $cs }}">
                                            {{ $g->clusterTerakhir->cluster }} — {{ $g->clusterTerakhir->label_cluster }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-600">Belum dipetakan</span>
                                    @endif
                                </td>
                                <td class="p-5">
                                    @php
                                        $totalAbsen = $g->absensi->count();
                                        $hadirCount = $g->absensi->where('status', 'hadir')->count();
                                        $persen = $totalAbsen > 0 ? round(($hadirCount / $totalAbsen) * 100) : 0;
                                    @endphp
                                    <div class="flex items-center gap-3">
                                        <div class="w-20 h-2.5 rounded-full overflow-hidden"
                                            style="background: rgba(255,255,255,0.05);">
                                            <div class="h-full rounded-full"
                                                style="width: {{ $persen }}%; background: {{ $persen >= 95 ? '#10b981' : ($persen >= 85 ? '#f59e0b' : '#ef4444') }};">
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-300">{{ $persen }}%</span>
                                    </div>
                                </td>
                                <td class="p-5 text-gray-400">
                                    {{ $g->prestasi->where('status', 'tervalidasi')->count() }} Sertifikat
                                </td>
                                <td class="p-5 text-right">
                                    <svg class="w-5 h-5 text-gray-600 ml-auto" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-10 text-center text-gray-500">
                                    Tidak ada data guru yang sesuai dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            <div class="p-5 flex justify-between items-center text-sm text-gray-500"
                style="border-top: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                <span>Menampilkan <strong class="text-gray-300">{{ $guru->count() }}</strong> dari {{ $guru->total() }}
                    guru</span>
                {{ $guru->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
