@extends('layouts.app')

@section('title', 'Monitoring Sistem')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">

        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Monitoring Sistem</h1>
            <p class="text-gray-400 mt-2">Pantau aktivitas dan status operasional sistem STQM.</p>
        </div>

        {{-- Status Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            @foreach ([['label' => 'Total Guru', 'value' => $stats['total_guru'], 'color' => '#fb923c', 'bg' => 'rgba(249,115,22,0.1)', 'border' => 'rgba(249,115,22,0.2)'], ['label' => 'Total Siswa', 'value' => $stats['total_siswa'], 'color' => '#fbbf24', 'bg' => 'rgba(245,158,11,0.1)', 'border' => 'rgba(245,158,11,0.2)'], ['label' => 'Total Pengguna', 'value' => $stats['total_users'], 'color' => '#60a5fa', 'bg' => 'rgba(59,130,246,0.1)', 'border' => 'rgba(59,130,246,0.2)'], ['label' => 'Sudah Dipetakan', 'value' => $stats['sudah_dinilai'], 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.1)', 'border' => 'rgba(16,185,129,0.2)']] as $stat)
                <div class="rounded-3xl p-6 flex items-center gap-5"
                    style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0"
                        style="background: {{ $stat['bg'] }}; border: 1px solid {{ $stat['border'] }};">
                        <span class="text-2xl font-bold" style="color: {{ $stat['color'] }};">
                            {{ $stat['value'] }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-bold text-white">{{ $stat['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Status Server --}}
            <div class="rounded-3xl p-6"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                <h3 class="font-semibold text-white text-lg mb-6">Status Server</h3>
                <div class="space-y-4">
                    @foreach ([['label' => 'Web Server', 'status' => 'Online'], ['label' => 'Database', 'status' => 'Online'], ['label' => 'Python (K-Means)', 'status' => 'Siap'], ['label' => 'Storage', 'status' => 'Online']] as $srv)
                        <div class="flex items-center justify-between p-4 rounded-2xl"
                            style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                            <span class="text-gray-300 text-sm">{{ $srv['label'] }}</span>
                            <div class="flex items-center gap-2">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                </span>
                                <span class="text-emerald-400 text-sm font-medium">{{ $srv['status'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Tombol Run Clustering --}}
                <div class="mt-6 pt-6" style="border-top: 1px solid rgba(255,255,255,0.06);">
                    <h4 class="text-sm font-medium text-gray-400 mb-4">Jalankan K-Means Clustering</h4>
                    <form method="POST" action="{{ route('admin.clustering.run') }}" id="form-clustering">
                        @csrf
                        <button type="button"
                            class="swal-confirm w-full flex items-center justify-center gap-2 py-3 rounded-2xl text-sm font-semibold text-white transition-all"
                            data-judul="Jalankan Clustering?"
                            data-pesan="Proses ini akan memperbarui semua data cluster guru." data-target="form-clustering"
                            style="background: linear-gradient(135deg, #8b5cf6, #6d28d9); box-shadow: 0 8px 32px rgba(139,92,246,0.3);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            Jalankan Clustering
                        </button>
                    </form>
                </div>
            </div>

            {{-- Kelengkapan Data --}}
            <div class="lg:col-span-2 rounded-3xl p-6"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                <h3 class="font-semibold text-white text-lg mb-6">Kelengkapan Data Master</h3>
                <div class="space-y-6">
                    @php
                        $dataItems = [
                            [
                                'label' => 'Data Guru',
                                'current' => $stats['total_guru'],
                                'total' => max($stats['total_guru'], 1),
                                'color' => '#10b981',
                            ],
                            [
                                'label' => 'Data Siswa',
                                'current' => $stats['total_siswa'],
                                'total' => max($stats['total_siswa'], 1),
                                'color' => '#3b82f6',
                            ],
                            [
                                'label' => 'Sudah Dinilai',
                                'current' => $stats['sudah_dinilai'],
                                'total' => max($stats['total_guru'], 1),
                                'color' => '#f59e0b',
                            ],
                            [
                                'label' => 'Data User',
                                'current' => $stats['total_users'],
                                'total' => max($stats['total_users'], 1),
                                'color' => '#8b5cf6',
                            ],
                        ];
                    @endphp
                    @foreach ($dataItems as $item)
                        @php $pct = $item['total'] > 0 ? round($item['current'] / $item['total'] * 100) : 0; @endphp
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="font-medium text-gray-300">{{ $item['label'] }}</span>
                                <span class="text-gray-400">
                                    <span class="text-white">{{ $item['current'] }}</span>/{{ $item['total'] }}
                                    <span style="color: {{ $item['color'] }};">({{ $pct }}%)</span>
                                </span>
                            </div>
                            <div class="w-full rounded-full h-3" style="background: rgba(255,255,255,0.05);">
                                <div class="h-full rounded-full transition-all"
                                    style="width: {{ $pct }}%; background: {{ $item['color'] }};"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
