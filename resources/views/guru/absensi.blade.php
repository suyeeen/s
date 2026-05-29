@extends('layouts.app')

@section('title', 'Data Kehadiran Saya')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-black" style="color:var(--text-main); font-family:'Outfit',sans-serif;">
            Data Kehadiran Saya
        </h1>
        <p class="text-sm mt-1" style="color:var(--text-muted);">
            Rekap kehadiran bulanan yang telah diinput oleh admin
        </p>
    </div>

    {{-- Statistik ringkasan --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $statCards = [
                ['label' => 'Total Hadir',    'val' => $statistik['hadir'] ?? 0,  'color' => '#10b981', 'bg' => 'rgba(16,185,129,0.1)'],
                ['label' => 'Total Izin',     'val' => $statistik['izin'] ?? 0,   'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.1)'],
                ['label' => 'Total Sakit',    'val' => $statistik['sakit'] ?? 0,  'color' => '#3b82f6', 'bg' => 'rgba(59,130,246,0.1)'],
                ['label' => 'Total Alpha',    'val' => $statistik['alpha'] ?? 0,  'color' => '#ef4444', 'bg' => 'rgba(239,68,68,0.1)'],
            ];
        @endphp
        @foreach($statCards as $sc)
            <div class="rounded-2xl p-4 text-center" style="background:{{ $sc['bg'] }}; border:1px solid {{ $sc['color'] }}33;">
                <p class="text-2xl font-black mb-1" style="color:{{ $sc['color'] }}; font-family:'Outfit',sans-serif;">
                    {{ $sc['val'] }}
                </p>
                <p class="text-xs font-semibold" style="color:var(--text-muted);">{{ $sc['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Persentase kehadiran total --}}
    @php
        $pct      = $statistik['persen'] ?? 0;
        $pctColor = $pct >= 90 ? '#10b981' : ($pct >= 75 ? '#f59e0b' : '#ef4444');
        $pctLabel = $pct >= 90 ? 'Sangat Baik' : ($pct >= 75 ? 'Cukup Baik' : 'Perlu Perhatian');
    @endphp

    <div class="rounded-2xl p-6" style="background:var(--card-bg); border:1px solid var(--card-border);">
        <div class="flex flex-col md:flex-row items-center gap-6">

            {{-- Donut --}}
            <div class="relative w-28 h-28 flex-shrink-0">
                <svg viewBox="0 0 36 36" class="w-28 h-28 -rotate-90">
                    <circle cx="18" cy="18" r="14" fill="none" stroke="var(--card-bg-soft)" stroke-width="3"/>
                    @if($pct > 0)
                        <circle cx="18" cy="18" r="14" fill="none"
                            stroke="{{ $pctColor }}"
                            stroke-width="3"
                            stroke-dasharray="{{ number_format($pct * 0.879645943, 4) }} 87.9645943"
                            stroke-linecap="round"/>
                    @endif
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <p class="text-xl font-black leading-tight" style="color:{{ $pctColor }}; font-family:'Outfit',sans-serif;">
                        {{ $pct > 0 ? number_format($pct, 1).'%' : '—' }}
                    </p>
                </div>
            </div>

            <div>
                <p class="text-2xl font-black mb-1" style="color:{{ $pctColor }}; font-family:'Outfit',sans-serif;">
                    {{ $pct > 0 ? $pctLabel : 'Belum ada data' }}
                </p>
                <p class="text-sm" style="color:var(--text-muted);">
                    Persentase kehadiran rata-rata dari seluruh rekap bulanan
                </p>
                @if($pct > 0)
                    <div class="mt-3 flex flex-wrap gap-2">
                        @php $rekapCount = $rekapAdmin->count(); @endphp
                        <span class="px-3 py-1 rounded-lg text-xs font-semibold"
                              style="background:rgba(59,130,246,0.12); color:#3b82f6;">
                            {{ $rekapCount }} rekap bulanan
                        </span>
                        <span class="px-3 py-1 rounded-lg text-xs font-semibold"
                              style="background:{{ $pctColor }}18; color:{{ $pctColor }};">
                            Hadir + Terlambat dihitung sebagai kehadiran
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Tabel rekap per bulan --}}
    <div class="rounded-2xl overflow-hidden" style="background:var(--card-bg); border:1px solid var(--card-border);">
        <div class="px-5 py-4 border-b" style="border-color:var(--card-border-soft);">
            <h2 class="font-black text-base" style="color:var(--text-main); font-family:'Outfit',sans-serif;">
                Rekap Per Bulan
            </h2>
        </div>

        @if($rekapAdmin->count() > 0)
            <div class="table-responsive">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="border-bottom:1px solid var(--card-border-soft);">
                            <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider" style="color:var(--text-muted);">Periode</th>
                            <th class="text-center px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#10b981;">Hadir</th>
                            <th class="text-center px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#a855f7;">Terlambat</th>
                            <th class="text-center px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#f59e0b;">Izin</th>
                            <th class="text-center px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#3b82f6;">Sakit</th>
                            <th class="text-center px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#ef4444;">Alpha</th>
                            <th class="text-center px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:var(--text-muted);">Hari Kerja</th>
                            <th class="text-center px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:var(--text-muted);">% Hadir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapAdmin as $rekap)
                            @php
                                $rPct   = $rekap->persen_hadir;
                                $rColor = $rPct >= 90 ? '#10b981' : ($rPct >= 75 ? '#f59e0b' : '#ef4444');
                            @endphp
                            <tr style="border-bottom:1px solid var(--card-border-soft);">
                                <td class="px-5 py-3 font-semibold" style="color:var(--text-main);">
                                    {{ $namaBulan[$rekap->bulan] ?? $rekap->bulan }} {{ $rekap->tahun }}
                                </td>
                                <td class="px-4 py-3 text-center font-bold" style="color:#10b981;">{{ $rekap->jumlah_hadir }}</td>
                                <td class="px-4 py-3 text-center font-bold" style="color:#a855f7;">{{ $rekap->jumlah_terlambat }}</td>
                                <td class="px-4 py-3 text-center font-bold" style="color:#f59e0b;">{{ $rekap->jumlah_izin }}</td>
                                <td class="px-4 py-3 text-center font-bold" style="color:#3b82f6;">{{ $rekap->jumlah_sakit }}</td>
                                <td class="px-4 py-3 text-center font-bold" style="color:#ef4444;">{{ $rekap->jumlah_alpha }}</td>
                                <td class="px-4 py-3 text-center" style="color:var(--text-muted);">{{ $rekap->total_hari_kerja }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded-lg text-xs font-black"
                                          style="background:{{ $rColor }}18; color:{{ $rColor }};">
                                        {{ $rekap->total_hari_kerja > 0 ? number_format($rPct, 1).'%' : '—' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-16 text-center">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
                     style="background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.2);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="#10b981" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                    </svg>
                </div>
                <p class="font-bold text-sm" style="color:var(--text-main);">Belum ada rekap kehadiran</p>
                <p class="text-xs mt-1" style="color:var(--text-muted);">Data akan muncul setelah admin menginput rekap bulanan.</p>
            </div>
        @endif
    </div>

    {{-- Info box --}}
    <div class="rounded-2xl px-5 py-4 flex items-start gap-3"
         style="background:rgba(59,130,246,0.08); border:1px solid rgba(59,130,246,0.2);">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1.8" stroke="#3b82f6" class="w-5 h-5 flex-shrink-0 mt-0.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
        </svg>
        <p class="text-xs leading-relaxed" style="color:#3b82f6;">
            Data kehadiran ini dikelola oleh admin. Jika ada kesalahan data, hubungi administrator sekolah.
            Persentase kehadiran dihitung dari: <strong>(Hadir + Terlambat) ÷ Total Hari Kerja × 100%</strong>.
            Data ini juga digunakan sebagai salah satu faktor dalam penilaian kualitas guru (K-Means clustering).
        </p>
    </div>

</div>
@endsection
