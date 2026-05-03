@extends('layouts.app')
@section('title', 'Monitoring Sistem')
@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-bold tracking-tight" style="color: var(--text-main)">Monitoring Sistem</h1>
        <p class="mt-2 text-sm" style="color: var(--text-muted)">Pantau aktivitas AI K-Means Clustering dan status operasional sistem STQM.</p>
    </div>

    {{-- Status Server --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ([
            ['label' => 'Web Server',      'status' => 'Online', 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.1)',  'border' => 'rgba(16,185,129,0.2)'],
            ['label' => 'Database',        'status' => 'Online', 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.1)',  'border' => 'rgba(16,185,129,0.2)'],
            ['label' => 'Python (K-Means)','status' => 'Siap',   'color' => '#60a5fa', 'bg' => 'rgba(59,130,246,0.1)',  'border' => 'rgba(59,130,246,0.2)'],
            ['label' => 'Storage',         'status' => 'Online', 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.1)',  'border' => 'rgba(16,185,129,0.2)'],
        ] as $srv)
            <div class="rounded-3xl p-5 flex items-center justify-between"
                 style="background: var(--card-bg); border: 1px solid var(--card-border);">
                <div>
                    <p class="text-xs mb-1" style="color: var(--text-muted)">{{ $srv['label'] }}</p>
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background: {{ $srv['color'] }}"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2" style="background: {{ $srv['color'] }}"></span>
                        </span>
                        <span class="text-sm font-semibold" style="color: {{ $srv['color'] }}">{{ $srv['status'] }}</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center" style="background: {{ $srv['bg'] }}; border: 1px solid {{ $srv['border'] }};">
                    <svg class="w-5 h-5" fill="none" stroke="{{ $srv['color'] }}" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>
        @endforeach
    </div>

    {{-- AI Clustering Stats --}}
    <div>
        <div class="flex items-center gap-3 mb-5">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background: rgba(139,92,246,0.15); border: 1px solid rgba(139,92,246,0.3);">
                <svg class="w-4 h-4" fill="none" stroke="#a78bfa" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
            <h2 class="text-lg font-bold" style="color: var(--text-main)">Hasil AI K-Means Clustering</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-5">
            <div class="rounded-3xl p-6 text-center" style="background: var(--card-bg); border: 1px solid var(--card-border);">
                <p class="text-xs mb-2" style="color: var(--text-muted)">Total Guru</p>
                <p class="text-4xl font-black" style="color: #fb923c">{{ $totalGuru }}</p>
                <p class="text-xs mt-2" style="color: var(--text-muted)">guru terdaftar</p>
            </div>
            <div class="rounded-3xl p-6 text-center" style="background: var(--card-bg); border: 1px solid var(--card-border);">
                <p class="text-xs mb-2" style="color: var(--text-muted)">Sudah Dipetakan</p>
                <p class="text-4xl font-black" style="color: #34d399">{{ $sudahDicluster }}</p>
                <p class="text-xs mt-2" style="color: var(--text-muted)">oleh K-Means AI</p>
            </div>
            <div class="rounded-3xl p-6 text-center" style="background: var(--card-bg); border: 1px solid var(--card-border);">
                <p class="text-xs mb-2" style="color: var(--text-muted)">Belum Dipetakan</p>
                <p class="text-4xl font-black" style="color: #f87171">{{ $belumDicluster }}</p>
                <p class="text-xs mt-2" style="color: var(--text-muted)">perlu diproses</p>
            </div>
            <div class="rounded-3xl p-6 text-center" style="background: var(--card-bg); border: 1px solid var(--card-border);">
                <p class="text-xs mb-2" style="color: var(--text-muted)">Akurasi Data</p>
                <p class="text-4xl font-black" style="color: #a78bfa">
                    {{ $totalGuru > 0 ? round(($sudahDicluster / $totalGuru) * 100) : 0 }}%
                </p>
                <p class="text-xs mt-2" style="color: var(--text-muted)">data terproses</p>
            </div>
        </div>

        {{-- Distribusi Cluster --}}
        <div class="rounded-3xl p-6" style="background: var(--card-bg); border: 1px solid var(--card-border);">
            <h3 class="font-semibold text-sm mb-5 flex items-center gap-2" style="color: var(--text-main)">
                <svg class="w-4 h-4" fill="none" stroke="#a78bfa" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                Distribusi Hasil Clustering per Klaster
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $clusterConfig = [
                        'A' => ['label' => 'Sangat Baik', 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.1)', 'border' => 'rgba(16,185,129,0.25)'],
                        'B' => ['label' => 'Baik',        'color' => '#60a5fa', 'bg' => 'rgba(59,130,246,0.1)', 'border' => 'rgba(59,130,246,0.25)'],
                        'C' => ['label' => 'Cukup',       'color' => '#fbbf24', 'bg' => 'rgba(245,158,11,0.1)', 'border' => 'rgba(245,158,11,0.25)'],
                        'D' => ['label' => 'Perlu Pembinaan','color' => '#f87171','bg' => 'rgba(239,68,68,0.1)','border' => 'rgba(239,68,68,0.25)'],
                    ];
                @endphp
                @foreach ($clusterConfig as $key => $cfg)
                    <div class="rounded-2xl p-5 text-center" style="background: {{ $cfg['bg'] }}; border: 1px solid {{ $cfg['border'] }};">
                        <div class="text-xs font-bold mb-1" style="color: {{ $cfg['color'] }}">Klaster {{ $key }}</div>
                        <div class="text-3xl font-black my-2" style="color: {{ $cfg['color'] }}">{{ $clusterDistribusi[$key] }}</div>
                        <div class="text-xs" style="color: var(--text-muted)">{{ $cfg['label'] }}</div>
                        @if($sudahDicluster > 0)
                            <div class="mt-3 h-1.5 rounded-full" style="background: rgba(255,255,255,0.06);">
                                <div class="h-1.5 rounded-full" style="background: {{ $cfg['color'] }}; width: {{ round(($clusterDistribusi[$key] / $sudahDicluster) * 100) }}%;"></div>
                            </div>
                            <div class="text-xs mt-1" style="color: var(--text-muted)">{{ $sudahDicluster > 0 ? round(($clusterDistribusi[$key] / $sudahDicluster) * 100) : 0 }}%</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Rata-rata Kompetensi + Kuesioner --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Rata-rata Nilai Kompetensi --}}
        <div class="rounded-3xl p-6" style="background: var(--card-bg); border: 1px solid var(--card-border);">
            <h3 class="font-semibold text-sm mb-5 flex items-center gap-2" style="color: var(--text-main)">
                <svg class="w-4 h-4" fill="none" stroke="#60a5fa" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Rata-rata Nilai Kompetensi Guru (AI)
            </h3>
            @if($rataKompetensi && $rataKompetensi->rata_rata)
                @php
                    $kompetensiList = [
                        ['label' => 'Pedagogik',    'value' => $rataKompetensi->pedagogik,    'color' => '#60a5fa'],
                        ['label' => 'Profesional',  'value' => $rataKompetensi->profesional,  'color' => '#fb923c'],
                        ['label' => 'Sosial',       'value' => $rataKompetensi->sosial,       'color' => '#34d399'],
                        ['label' => 'Kepribadian',  'value' => $rataKompetensi->kepribadian,  'color' => '#a78bfa'],
                    ];
                @endphp
                <div class="space-y-4">
                    @foreach ($kompetensiList as $k)
                        <div>
                            <div class="flex justify-between text-xs mb-2">
                                <span style="color: var(--text-muted)">{{ $k['label'] }}</span>
                                <span class="font-bold" style="color: {{ $k['color'] }}">{{ number_format($k['value'], 2) }}</span>
                            </div>
                            <div class="h-2 rounded-full" style="background: rgba(255,255,255,0.06);">
                                <div class="h-2 rounded-full transition-all" style="background: {{ $k['color'] }}; width: {{ min(100, ($k['value'] / 5) * 100) }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                    <div class="pt-3 mt-2" style="border-top: 1px solid var(--card-divider);">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-medium" style="color: var(--text-muted)">Rata-rata Keseluruhan</span>
                            <span class="text-xl font-black" style="color: #fbbf24">{{ number_format($rataKompetensi->rata_rata, 2) }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-10 text-center">
                    <svg class="w-12 h-12 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <p class="text-sm" style="color: var(--text-muted)">Belum ada data clustering.</p>
                    <p class="text-xs mt-1" style="color: var(--text-muted)">Jalankan K-Means untuk melihat statistik.</p>
                </div>
            @endif
        </div>

        {{-- Statistik Kuesioner --}}
        <div class="rounded-3xl p-6" style="background: var(--card-bg); border: 1px solid var(--card-border);">
            <h3 class="font-semibold text-sm mb-5 flex items-center gap-2" style="color: var(--text-main)">
                <svg class="w-4 h-4" fill="none" stroke="#f472b6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Data Kuesioner (Input AI)
            </h3>
            <div class="space-y-4">
                @foreach ([
                    ['label' => 'Kuesioner dari Siswa', 'value' => $kuesionerStats['dari_siswa'], 'color' => '#a78bfa', 'bg' => 'rgba(139,92,246,0.1)', 'border' => 'rgba(139,92,246,0.2)', 'desc' => 'Penilaian kinerja guru oleh siswa'],
                    ['label' => 'Kuesioner dari Guru',  'value' => $kuesionerStats['dari_guru'],  'color' => '#38bdf8', 'bg' => 'rgba(14,165,233,0.1)',  'border' => 'rgba(14,165,233,0.2)',  'desc' => 'Penilaian mandiri oleh guru'],
                    ['label' => 'Total Kuesioner',      'value' => $kuesionerStats['total'],      'color' => '#f472b6', 'bg' => 'rgba(236,72,153,0.1)',  'border' => 'rgba(236,72,153,0.2)',  'desc' => 'Semua kuesioner masuk sistem'],
                ] as $stat)
                    <div class="flex items-center gap-4 p-4 rounded-2xl" style="background: {{ $stat['bg'] }}; border: 1px solid {{ $stat['border'] }};">
                        <div class="text-3xl font-black shrink-0" style="color: {{ $stat['color'] }}">{{ $stat['value'] }}</div>
                        <div>
                            <p class="text-sm font-semibold" style="color: {{ $stat['color'] }}">{{ $stat['label'] }}</p>
                            <p class="text-xs mt-0.5" style="color: var(--text-muted)">{{ $stat['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Riwayat Clustering AI + Jalankan Clustering --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Jalankan Clustering --}}
        <div class="rounded-3xl p-6 flex flex-col justify-between" style="background: var(--card-bg); border: 1px solid var(--card-border);">
            <div>
                <h3 class="font-semibold text-sm mb-2" style="color: var(--text-main)">Jalankan AI Clustering</h3>
                <p class="text-xs mb-6" style="color: var(--text-muted)">
                    Algoritma K-Means akan memproses semua jawaban kuesioner dan memetakan setiap guru ke dalam 4 klaster berdasarkan kompetensi pedagogik, profesional, sosial, dan kepribadian.
                </p>
                <div class="space-y-3 text-xs" style="color: var(--text-muted)">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style="background: rgba(139,92,246,0.4);">1</span>
                        Ambil jawaban kuesioner dari database
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style="background: rgba(139,92,246,0.4);">2</span>
                        Hitung rata-rata nilai per kompetensi
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style="background: rgba(139,92,246,0.4);">3</span>
                        Proses Python K-Means (4 klaster)
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style="background: rgba(139,92,246,0.4);">4</span>
                        Simpan hasil ke database
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <form method="POST" action="{{ route('admin.clustering.run') }}" id="form-clustering">
                    @csrf
                    <button type="button"
                        class="swal-confirm w-full flex items-center justify-center gap-2 py-3 rounded-2xl text-sm font-semibold text-white transition-all"
                        data-judul="Jalankan Clustering?"
                        data-pesan="Proses ini akan memperbarui semua data cluster guru."
                        data-target="form-clustering"
                        style="background: linear-gradient(135deg, #8b5cf6, #6d28d9); box-shadow: 0 8px 32px rgba(139,92,246,0.3);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        Jalankan Clustering
                    </button>
                </form>
            </div>
        </div>

        {{-- Riwayat Clustering Terbaru --}}
        <div class="lg:col-span-2 rounded-3xl overflow-hidden" style="background: var(--card-bg); border: 1px solid var(--card-border);">
            <div class="px-6 py-5" style="border-bottom: 1px solid var(--card-divider); background: var(--card-bg-soft);">
                <h3 class="font-semibold text-sm flex items-center gap-2" style="color: var(--text-main)">
                    <svg class="w-4 h-4" fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Riwayat Hasil Clustering AI (10 Terbaru)
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--card-divider); color: var(--text-muted);">
                            <th class="px-5 py-3 font-medium text-xs">Nama Guru</th>
                            <th class="px-5 py-3 font-medium text-xs">Klaster</th>
                            <th class="px-5 py-3 font-medium text-xs">Nilai Rata-rata</th>
                            <th class="px-5 py-3 font-medium text-xs">Tanggal Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatClustering as $r)
                            @php
                                $cs = match($r->cluster) {
                                    'A' => ['color'=>'#34d399','bg'=>'rgba(16,185,129,0.1)','border'=>'rgba(16,185,129,0.25)'],
                                    'B' => ['color'=>'#60a5fa','bg'=>'rgba(59,130,246,0.1)','border'=>'rgba(59,130,246,0.25)'],
                                    'C' => ['color'=>'#fbbf24','bg'=>'rgba(245,158,11,0.1)','border'=>'rgba(245,158,11,0.25)'],
                                    'D' => ['color'=>'#f87171','bg'=>'rgba(239,68,68,0.1)', 'border'=>'rgba(239,68,68,0.25)'],
                                    default => ['color'=>'#9ca3af','bg'=>'rgba(255,255,255,0.05)','border'=>'rgba(255,255,255,0.1)'],
                                };
                            @endphp
                            <tr style="border-bottom: 1px solid var(--card-border-soft);">
                                <td class="px-5 py-3 font-medium text-xs" style="color: var(--text-main)">
                                    {{ $r->guru?->nama ?? '-' }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold"
                                        style="background: {{ $cs['bg'] }}; color: {{ $cs['color'] }}; border: 1px solid {{ $cs['border'] }};">
                                        {{ $r->cluster }} — {{ $r->label_cluster }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-xs font-semibold" style="color: #fbbf24">
                                    {{ number_format($r->nilai_rata_rata, 2) }}
                                </td>
                                <td class="px-5 py-3 text-xs" style="color: var(--text-muted)">
                                    {{ $r->tanggal ? \Carbon\Carbon::parse($r->tanggal)->format('d M Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-sm" style="color: var(--text-muted)">
                                    Belum ada riwayat clustering. Jalankan K-Means untuk mulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
