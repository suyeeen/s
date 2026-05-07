@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-bold tracking-tight" style="color:var(--text-main)">Pengaturan Sistem</h1>
        <p class="mt-2 text-sm" style="color:var(--text-muted)">Konfigurasi parameter dan operasional aplikasi STQM.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.save') }}">
        @csrf
        <div class="space-y-6">

            {{-- ── Periode Akademik ── --}}
            <div class="rounded-3xl overflow-hidden" style="background:var(--card-bg);border:1px solid var(--card-border);box-shadow:0 1px 8px rgba(26,22,19,0.05);">
                <div class="p-5 flex items-center gap-4" style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                    <div class="p-2.5 rounded-xl" style="background:rgba(232,86,10,0.1);border:1px solid rgba(232,86,10,0.2);">
                        <svg class="w-5 h-5" style="color:#E8560A" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-base" style="color:var(--text-main)">Periode Akademik & Evaluasi</h3>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted)">Atur tahun ajaran, semester, dan jendela pengisian kuesioner.</p>
                    </div>
                </div>
                <div class="p-7 grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-xs font-semibold mb-2 uppercase tracking-wide" style="color:var(--text-muted)">Tahun Ajaran Aktif</label>
                        <select name="tahun_ajaran" class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                            style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                            @foreach (['2024/2025', '2025/2026', '2023/2024'] as $ta)
                                <option value="{{ $ta }}" {{ ($settings['tahun_ajaran'] ?? '2024/2025') === $ta ? 'selected' : '' }}>{{ $ta }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-2 uppercase tracking-wide" style="color:var(--text-muted)">Semester Aktif</label>
                        <select name="semester" class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                            style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                            <option value="ganjil" {{ ($settings['semester'] ?? 'ganjil') === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap"  {{ ($settings['semester'] ?? 'ganjil') === 'genap'  ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-2 uppercase tracking-wide" style="color:var(--text-muted)">Buka Akses Kuesioner</label>
                        <input type="date" name="buka_kuesioner" value="{{ $settings['buka_kuesioner'] ?? '' }}"
                            class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                            style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-2 uppercase tracking-wide" style="color:var(--text-muted)">Tutup Akses Kuesioner</label>
                        <input type="date" name="tutup_kuesioner" value="{{ $settings['tutup_kuesioner'] ?? '' }}"
                            class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                            style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                    </div>

                </div>
            </div>

            {{-- ── Integrasi RFID ──
            <div class="rounded-3xl overflow-hidden" style="background:var(--card-bg);border:1px solid var(--card-border);box-shadow:0 1px 8px rgba(26,22,19,0.05);">
                <div class="p-5 flex items-center gap-4" style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                    <div class="p-2.5 rounded-xl" style="background:rgba(29,111,191,0.1);border:1px solid rgba(29,111,191,0.2);">
                        <svg class="w-5 h-5" style="color:#1D6FBF" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-base" style="color:var(--text-main)">Integrasi Hardware RFID</h3>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted)">Kontrol koneksi ke perangkat pembaca kartu RFID.</p>
                    </div>
                </div>
                <div class="p-7" x-data="{ rfid: {{ $settings['rfid_aktif'] ?? false ? 'true' : 'false' }} }">
                    <div class="flex items-center justify-between p-5 rounded-2xl" style="background:var(--card-bg-soft);border:1px solid var(--card-border-soft);">
                        <div>
                            <h4 class="font-semibold text-sm" style="color:var(--text-main)">Modul Absensi RFID</h4>
                            <p class="text-xs mt-1" style="color:var(--text-muted)">Status koneksi ke perangkat pembaca kartu RFID.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="rfid_aktif" x-model="rfid" class="sr-only">
                            <div class="w-12 h-6 rounded-full transition-all relative"
                                :style="rfid ? 'background:#E8560A;' : 'background:var(--btn-border);'">
                                <div class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow transition-all"
                                    :style="rfid ? 'transform:translateX(24px);' : 'transform:translateX(0);'"></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div> --}}

            {{-- ── Pengaturan Kuesioner ── --}}
            <div class="rounded-3xl overflow-hidden" style="background:var(--card-bg);border:1px solid var(--card-border);box-shadow:0 1px 8px rgba(26,22,19,0.05);">
                <div class="p-5 flex items-center gap-4" style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                    <div class="p-2.5 rounded-xl" style="background:rgba(13,148,136,0.1);border:1px solid rgba(13,148,136,0.2);">
                        <svg class="w-5 h-5" style="color:#0D9488" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 011-1h4a2 2 0 011 1"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-base" style="color:var(--text-main)">Pengaturan Kuesioner</h3>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted)">Batasi berapa kali penilai boleh mengisi kuesioner per periode.</p>
                    </div>
                </div>
                <div class="p-7">
                    <div class="max-w-xs">
                        <label class="block text-xs font-semibold mb-2 uppercase tracking-wide" style="color:var(--text-muted)">
                            Maksimal Pengisian per Target per Periode
                        </label>
                        <div class="flex items-center gap-4">
                            <input type="number" name="maks_penilaian" min="1" max="10"
                                value="{{ $settings['maks_penilaian'] ?? 1 }}"
                                class="w-28 px-4 py-3 rounded-xl text-sm text-center font-bold outline-none transition-all"
                                style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                            <p class="text-xs" style="color:var(--text-muted)">
                                kali per guru, per semester.<br>
                                <span style="color:var(--text-muted);">Set ke <strong>1</strong> agar tidak dapat diulang.</span>
                            </p>
                        </div>
                    </div>

                    {{-- Status kuesioner --}}
                    <div class="mt-6 p-4 rounded-2xl flex items-center gap-3 text-sm"
                        style="background:rgba(232,86,10,0.07);border:1px solid rgba(232,86,10,0.14);">
                        <svg class="w-4 h-4 shrink-0" style="color:#E8560A" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span style="color:var(--text-muted)">
                            Status kuesioner saat ini:&nbsp;
                            @php
                                $buka  = $settings['buka_kuesioner'] ?? '';
                                $tutup = $settings['tutup_kuesioner'] ?? '';
                                $now   = now()->toDateString();
                            @endphp
                            @if(!$buka && !$tutup)
                                <span style="color:#059669;font-weight:600;">Selalu Terbuka</span>
                            @elseif($buka && $now < $buka)
                                <span style="color:#B45309;font-weight:600;">Belum Dibuka (dibuka {{ $buka }})</span>
                            @elseif($tutup && $now > $tutup)
                                <span style="color:#DC2626;font-weight:600;">Sudah Ditutup ({{ $tutup }})</span>
                            @else
                                <span style="color:#059669;font-weight:600;">Sedang Terbuka</span>
                                @if($tutup) <span style="color:var(--text-muted)">— tutup {{ $tutup }}</span> @endif
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- ── Tombol Simpan ── --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="flex items-center gap-2 px-7 py-3.5 rounded-2xl font-semibold text-sm text-white transition-all"
                    style="background:#E8560A;box-shadow:0 4px 16px rgba(232,86,10,0.25);"
                    onmouseover="this.style.background='#C44608'"
                    onmouseout="this.style.background='#E8560A'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
