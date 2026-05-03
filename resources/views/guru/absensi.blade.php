@extends('layouts.app')

@section('title', 'Data Kehadiran')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">

        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-bold" style="color:var(--text-main)" tracking-tight">Sistem Absensi RFID</h1>
            <p class="text-sm mt-2" style="color:var(--text-muted)">Monitoring kehadiran dan kedisiplinan harian.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ── Kartu Scanner ── --}}
            <div class="lg:col-span-1">
                <div class="rounded-3xl p-10 text-center relative overflow-hidden h-full flex flex-col items-center justify-center"
                    style="background:var(--card-bg);border:1px solid var(--card-border);">

                    {{-- Garis atas --}}
                    <div class="absolute top-0 left-0 w-full h-1.5 rounded-t-3xl"
                        style="background: linear-gradient(90deg, #f97316, #eab308);"></div>

                    <h2 class="text-xl font-semibold text-white mb-2">Scan Kartu RFID</h2>
                    <p class="text-gray-400 text-sm mb-10">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>

                    {{-- Icon status --}}
                    <div class="w-48 h-48 rounded-full flex items-center justify-center mb-10"
                        style="{{ $sudahAbsen
                            ? 'background: rgba(16,185,129,0.1); border: 2px solid rgba(16,185,129,0.3);'
                            : 'background: rgba(255,255,255,0.02); border: 4px solid rgba(255,255,255,0.05);' }}">
                        @if ($sudahAbsen)
                            <svg class="w-24 h-24 text-emerald-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg class="w-20 h-20 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        @endif
                    </div>

                    @if ($sudahAbsen)
                        <p class="text-emerald-400 font-medium mb-6">Absensi sudah tercatat hari ini</p>
                    @endif

                    {{-- Tombol scan --}}
                    <form method="POST" action="{{ route('guru.absensi.scan') }}" class="w-full">
                        @csrf
                        <button type="submit" {{ $sudahAbsen ? 'disabled' : '' }}
                            class="w-full flex items-center justify-center gap-3 py-4 rounded-2xl font-semibold text-white transition-all"
                            style="{{ $sudahAbsen
                                ? 'background: rgba(255,255,255,0.05); color: #6b7280; cursor: not-allowed;'
                                : 'background: linear-gradient(135deg, #f97316, #eab308); box-shadow: 0 8px 32px rgba(249,115,22,0.3);' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                            {{ $sudahAbsen ? 'Sudah Absen Hari Ini' : 'Simulasi Tap Kartu' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── Stats + Riwayat ── --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Statistik bulan ini --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    @foreach ([['label' => 'Hadir', 'value' => $statistik['hadir'], 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.1)', 'border' => 'rgba(16,185,129,0.2)'], ['label' => 'Izin', 'value' => $statistik['izin'], 'color' => '#60a5fa', 'bg' => 'rgba(59,130,246,0.1)', 'border' => 'rgba(59,130,246,0.2)'], ['label' => 'Sakit', 'value' => $statistik['sakit'], 'color' => '#fbbf24', 'bg' => 'rgba(245,158,11,0.1)', 'border' => 'rgba(245,158,11,0.2)'], ['label' => 'Alpha', 'value' => $statistik['alpha'], 'color' => '#f87171', 'bg' => 'rgba(239,68,68,0.1)', 'border' => 'rgba(239,68,68,0.2)']] as $stat)
                        <div class="rounded-3xl p-6 flex flex-col items-center justify-center text-center"
                            style="background:var(--card-bg);border:1px solid var(--card-border);">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4"
                                style="background: {{ $stat['bg'] }}; border: 1px solid {{ $stat['border'] }};">
                                <span class="text-2xl font-bold" style="color: {{ $stat['color'] }};">
                                    {{ $stat['value'] }}
                                </span>
                            </div>
                            <span class="text-sm font-medium text-gray-400">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Tabel riwayat --}}
                <div class="rounded-3xl overflow-hidden"
                    style="background:var(--card-bg);border:1px solid var(--card-border);">

                    <div class="p-6 flex justify-between items-center"
                        style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                        <h3 class="font-semibold text-white flex items-center gap-3">
                            <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Riwayat Kehadiran
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-xs" style="color:var(--text-muted);border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                                    <th class="p-5 font-medium">Tanggal</th>
                                    <th class="p-5 font-medium">Status</th>
                                    <th class="p-5 font-medium">Jam Masuk</th>
                                    <th class="p-5 font-medium">Jam Keluar</th>
                                    <th class="p-5 font-medium">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($riwayat as $absen)
                                    <tr style="border-bottom:1px solid var(--card-border-soft);"
                                        onmouseover="this.style.background='rgba(26,22,19,0.03)'" onmouseout="this.style.background='transparent'" >
                                        <td class="p-5 font-medium text-gray-200">
                                            {{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="p-5">
                                            @php
                                                $statusStyle = match ($absen->status) {
                                                    'hadir' => [
                                                        'bg' => 'rgba(16,185,129,0.1)',
                                                        'color' => '#34d399',
                                                        'border' => 'rgba(16,185,129,0.2)',
                                                    ],
                                                    'terlambat' => [
                                                        'bg' => 'rgba(245,158,11,0.1)',
                                                        'color' => '#fbbf24',
                                                        'border' => 'rgba(245,158,11,0.2)',
                                                    ],
                                                    'izin' => [
                                                        'bg' => 'rgba(59,130,246,0.1)',
                                                        'color' => '#60a5fa',
                                                        'border' => 'rgba(59,130,246,0.2)',
                                                    ],
                                                    'sakit' => [
                                                        'bg' => 'rgba(139,92,246,0.1)',
                                                        'color' => '#a78bfa',
                                                        'border' => 'rgba(139,92,246,0.2)',
                                                    ],
                                                    default => [
                                                        'bg' => 'rgba(239,68,68,0.1)',
                                                        'color' => '#f87171',
                                                        'border' => 'rgba(239,68,68,0.2)',
                                                    ],
                                                };
                                            @endphp
                                            <span class="px-3 py-1.5 rounded-xl text-xs font-bold capitalize"
                                                style="background: {{ $statusStyle['bg'] }}; color: {{ $statusStyle['color'] }}; border: 1px solid {{ $statusStyle['border'] }};">
                                                {{ $absen->status }}
                                            </span>
                                        </td>
                                        <td class="p-5 text-gray-400">{{ $absen->jam_masuk ?? '-' }}</td>
                                        <td class="p-5 text-gray-400">{{ $absen->jam_keluar ?? '-' }}</td>
                                        <td class="p-5 text-gray-500">{{ $absen->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-10 text-center text-gray-500">
                                            Belum ada data kehadiran.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($riwayat->hasPages())
                        <div class="p-5" style="border-top: 1px solid rgba(255,255,255,0.06);">
                            {{ $riwayat->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
