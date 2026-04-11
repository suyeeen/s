@extends('layouts.app')

@section('title', 'Dashboard Analisis')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">
                Halo, {{ auth()->user()->name }}!
            </h1>
            <p class="text-gray-400 mt-2">
                Lihat progress kompetensi, distribusi cluster, dan performa guru — semua di satu tempat.
            </p>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ([['title' => 'Total Guru', 'value' => $total, 'suffix' => '', 'color' => '#60a5fa', 'bg' => 'rgba(59,130,246,0.1)', 'border' => 'rgba(59,130,246,0.2)'], ['title' => 'Rata-rata Kompetensi', 'value' => number_format($rataKompetensi->pedagogik ?? 0, 2), 'suffix' => '/ 5.0', 'color' => '#fbbf24', 'bg' => 'rgba(245,158,11,0.1)', 'border' => 'rgba(245,158,11,0.2)'], ['title' => 'Guru Cluster A', 'value' => $distribusiCluster['A'] ?? 0, 'suffix' => ' Orang', 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.1)', 'border' => 'rgba(16,185,129,0.2)'], ['title' => 'Sudah Dipetakan', 'value' => $distribusiCluster->sum(), 'suffix' => ' Guru', 'color' => '#a78bfa', 'bg' => 'rgba(139,92,246,0.1)', 'border' => 'rgba(139,92,246,0.2)']] as $stat)
                <div class="rounded-3xl p-6 flex items-center gap-5 relative overflow-hidden transition-all"
                    style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);"
                    onmouseover="this.style.background='rgba(255,255,255,0.06)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.04)'">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0"
                        style="background: {{ $stat['bg'] }}; border: 1px solid {{ $stat['border'] }};">
                        <span class="text-2xl font-bold" style="color: {{ $stat['color'] }};">
                            {{ $stat['value'] }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400 mb-1">{{ $stat['title'] }}</p>
                        <p class="text-2xl font-bold text-white">
                            {{ $stat['value'] }}<span class="text-sm font-medium text-gray-500">{{ $stat['suffix'] }}</span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Distribusi Cluster --}}
            <div class="rounded-3xl p-6"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                <h3 class="font-semibold text-white mb-6 text-lg">Distribusi Cluster Guru</h3>

                <canvas id="chartCluster" height="220"></canvas>

                <div class="mt-6 space-y-3">
                    @foreach ([['label' => 'Sangat Baik (A)', 'key' => 'A', 'color' => '#10b981'], ['label' => 'Baik (B)', 'key' => 'B', 'color' => '#3b82f6'], ['label' => 'Cukup (C)', 'key' => 'C', 'color' => '#f59e0b'], ['label' => 'Perlu Pembinaan (D)', 'key' => 'D', 'color' => '#ef4444']] as $item)
                        <div class="flex items-center justify-between text-sm p-3 rounded-xl"
                            style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full" style="background: {{ $item['color'] }};"></div>
                                <span class="text-gray-300">{{ $item['label'] }}</span>
                            </div>
                            <span class="font-bold text-white">{{ $distribusiCluster[$item['key']] ?? 0 }} Guru</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Rata-rata Kompetensi --}}
            <div class="lg:col-span-2 rounded-3xl p-6"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                <h3 class="font-semibold text-white mb-6 text-lg">Rata-rata per Indikator Kompetensi</h3>
                <canvas id="chartKompetensi" height="220"></canvas>
            </div>

            {{-- Top 5 Guru --}}
            <div class="lg:col-span-3 rounded-3xl overflow-hidden"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">

                <div class="p-6 flex justify-between items-center"
                    style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                    <h3 class="font-semibold text-white text-lg">Top 5 Guru Berprestasi</h3>
                    <a href="{{ route('kepala.evaluasi') }}"
                        class="text-sm text-orange-400 font-semibold hover:text-orange-300 flex items-center gap-1 transition-colors">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                @forelse($topGuru as $index => $guru)
                    <a href="{{ route('kepala.guru.detail', $guru->id) }}"
                        class="flex items-center justify-between p-5 transition-colors block"
                        style="border-bottom: 1px solid rgba(255,255,255,0.04);"
                        onmouseover="this.style.background='rgba(255,255,255,0.03)'"
                        onmouseout="this.style.background='transparent'">

                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-lg shrink-0"
                                style="{{ $index === 0
                                    ? 'background: rgba(234,179,8,0.1); color: #fbbf24; border: 1px solid rgba(234,179,8,0.2);'
                                    : ($index === 1
                                        ? 'background: rgba(148,163,184,0.1); color: #cbd5e1; border: 1px solid rgba(148,163,184,0.2);'
                                        : 'background: rgba(255,255,255,0.05); color: #6b7280; border: 1px solid rgba(255,255,255,0.1);') }}">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <h4 class="font-semibold text-white">{{ $guru->nama }}</h4>
                                <p class="text-sm text-gray-400 mt-1">
                                    {{ $guru->mata_pelajaran }}
                                    <span class="mx-2 text-gray-600">•</span>
                                    NIP: {{ $guru->nip }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            @if ($guru->clusterTerakhir)
                                <div class="text-right hidden sm:block">
                                    <p class="text-xs text-gray-500 mb-1">Skor</p>
                                    <p class="font-bold text-white">{{ $guru->clusterTerakhir->nilai_rata_rata }}</p>
                                </div>
                                @php
                                    $clusterStyle = match ($guru->clusterTerakhir->cluster) {
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
                                <span class="px-4 py-1.5 rounded-xl text-xs font-bold" style="{{ $clusterStyle }}">
                                    Cluster {{ $guru->clusterTerakhir->cluster }}
                                </span>
                            @else
                                <span class="text-xs text-gray-500">Belum dipetakan</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="p-10 text-center text-gray-500">
                        Belum ada data clustering. Jalankan K-Means terlebih dahulu.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const darkGrid = 'rgba(255,255,255,0.06)';
        const darkTick = '#6b7280';
        const tooltip = {
            backgroundColor: 'rgba(15,15,25,0.9)',
            borderColor: 'rgba(255,255,255,0.1)',
            borderWidth: 1,
            titleColor: '#fff',
            bodyColor: '#f59e0b',
            padding: 12,
            cornerRadius: 12,
        };

        // ── Pie Chart: Distribusi Cluster ──
        new Chart(document.getElementById('chartCluster'), {
            type: 'doughnut',
            data: {
                labels: ['Sangat Baik (A)', 'Baik (B)', 'Cukup (C)', 'Perlu Pembinaan (D)'],
                datasets: [{
                    data: [
                        {{ $distribusiCluster['A'] ?? 0 }},
                        {{ $distribusiCluster['B'] ?? 0 }},
                        {{ $distribusiCluster['C'] ?? 0 }},
                        {{ $distribusiCluster['D'] ?? 0 }},
                    ],
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 6,
                }]
            },
            options: {
                cutout: '65%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.raw} Guru`
                        }
                    }
                }
            }
        });

        // ── Bar Chart: Kompetensi ──
        new Chart(document.getElementById('chartKompetensi'), {
            type: 'bar',
            data: {
                labels: ['Pedagogik', 'Kepribadian', 'Sosial', 'Profesional'],
                datasets: [{
                    label: 'Rata-rata',
                    data: [
                        {{ number_format($rataKompetensi->pedagogik ?? 0, 2) }},
                        {{ number_format($rataKompetensi->kepribadian ?? 0, 2) }},
                        {{ number_format($rataKompetensi->sosial ?? 0, 2) }},
                        {{ number_format($rataKompetensi->profesional ?? 0, 2) }},
                    ],
                    backgroundColor: '#f59e0b',
                    borderRadius: 8,
                    maxBarThickness: 60,
                }]
            },
            options: {
                scales: {
                    y: {
                        min: 0,
                        max: 5,
                        grid: {
                            color: darkGrid
                        },
                        ticks: {
                            color: darkTick
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: darkTick
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip
                }
            }
        });
    </script>
@endsection
