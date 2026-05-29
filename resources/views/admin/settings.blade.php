@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-bold tracking-tight" style="color:var(--text-main)">Pengaturan Sistem</h1>
            <p class="mt-2 text-sm" style="color:var(--text-muted)">Konfigurasi parameter dan operasional aplikasi STQM.</p>
        </div>

        @if (session('success'))
            <div class="flex items-center gap-3 px-5 py-4 rounded-2xl text-sm font-medium"
                style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.25);color:#34d399;">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="flex items-start gap-3 px-5 py-4 rounded-2xl text-sm font-medium"
                style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);color:#f87171;">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                </svg>
                <ul class="list-disc ml-1 space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.save') }}" id="settingsForm">
            @csrf
            <div class="space-y-6">

                {{-- ── Periode Akademik ── --}}
                <div class="rounded-3xl overflow-hidden"
                    style="background:var(--card-bg);border:1px solid var(--card-border);box-shadow:0 1px 8px rgba(26,22,19,0.05);">
                    <div class="p-5 flex items-center gap-4"
                        style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                        <div class="p-2.5 rounded-xl"
                            style="background:rgba(232,86,10,0.1);border:1px solid rgba(232,86,10,0.2);">
                            <svg class="w-5 h-5" style="color:#E8560A" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-base" style="color:var(--text-main)">Periode Akademik & Evaluasi
                            </h3>
                            <p class="text-xs mt-0.5" style="color:var(--text-muted)">Atur tahun ajaran aktif dan semester
                                berjalan.</p>
                        </div>
                    </div>
                    <div class="p-7 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold mb-2 uppercase tracking-wide"
                                style="color:var(--text-muted)">Tahun Ajaran Aktif</label>
                            <select name="tahun_ajaran"
                                class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                                style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                                @foreach (['2023/2024', '2024/2025', '2025/2026', '2026/2027'] as $ta)
                                    <option value="{{ $ta }}" {{ ($settings['tahun_ajaran'] ?? '2024/2025') === $ta ? 'selected' : '' }}>{{ $ta }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-2 uppercase tracking-wide"
                                style="color:var(--text-muted)">Semester Aktif</label>
                            <select name="semester" class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                                style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                                <option value="ganjil" {{ ($settings['semester'] ?? 'ganjil') === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="genap" {{ ($settings['semester'] ?? 'ganjil') === 'genap' ? 'selected' : '' }}>
                                    Genap</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ── Jadwal Kuesioner ── --}}
                @php
                    $buka = $settings['buka_kuesioner'] ?? '';
                    $tutup = $settings['tutup_kuesioner'] ?? '';
                    $now = now()->toDateString();
                    $nowCarbon = now();

                    // Status logic
                    if (!$buka && !$tutup) {
                        $statusLabel = 'Selalu Terbuka';
                        $statusColor = '#059669';
                        $statusBg = 'rgba(5,150,105,0.08)';
                        $statusBorder = 'rgba(5,150,105,0.2)';
                        $statusIcon = 'check-circle';
                        $sisaHari = null;
                    } elseif ($buka && $now < $buka) {
                        $bukaDate = \Carbon\Carbon::parse($buka);
                        $sisaHari = $nowCarbon->diffInDays($bukaDate);
                        $statusLabel = 'Belum Dibuka';
                        $statusColor = '#B45309';
                        $statusBg = 'rgba(180,83,9,0.08)';
                        $statusBorder = 'rgba(180,83,9,0.2)';
                        $statusIcon = 'clock';
                    } elseif ($tutup && $now > $tutup) {
                        $statusLabel = 'Sudah Ditutup';
                        $statusColor = '#DC2626';
                        $statusBg = 'rgba(220,38,38,0.08)';
                        $statusBorder = 'rgba(220,38,38,0.2)';
                        $statusIcon = 'x-circle';
                        $sisaHari = null;
                    } else {
                        $sisaHari = $tutup ? $nowCarbon->diffInDays(\Carbon\Carbon::parse($tutup)) : null;
                        $statusLabel = 'Sedang Terbuka';
                        $statusColor = '#059669';
                        $statusBg = 'rgba(5,150,105,0.08)';
                        $statusBorder = 'rgba(5,150,105,0.2)';
                        $statusIcon = 'check-circle';
                    }
                @endphp

                <div class="rounded-3xl overflow-hidden"
                    style="background:var(--card-bg);border:1px solid var(--card-border);box-shadow:0 1px 8px rgba(26,22,19,0.05);">
                    <div class="p-5 flex items-center justify-between gap-4"
                        style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                        <div class="flex items-center gap-4">
                            <div class="p-2.5 rounded-xl"
                                style="background:rgba(79,70,229,0.1);border:1px solid rgba(79,70,229,0.2);">
                                <svg class="w-5 h-5" style="color:#6366f1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-base" style="color:var(--text-main)">Jadwal Buka / Tutup
                                    Kuesioner</h3>
                                <p class="text-xs mt-0.5" style="color:var(--text-muted)">Kontrol kapan siswa dan guru bisa
                                    mengisi kuesioner.</p>
                            </div>
                        </div>
                        {{-- Status Badge --}}
                        <div class="px-4 py-2 rounded-2xl text-xs font-bold flex items-center gap-2 shrink-0"
                            style="background:{{ $statusBg }};border:1px solid {{ $statusBorder }};color:{{ $statusColor }};">
                            <span class="w-2 h-2 rounded-full"
                                style="background:{{ $statusColor }};box-shadow:0 0 6px {{ $statusColor }};"></span>
                            {{ $statusLabel }}
                        </div>
                    </div>

                    <div class="p-7 space-y-6">

                        {{-- Status detail --}}
                        <div class="p-4 rounded-2xl"
                            style="background:{{ $statusBg }};border:1px solid {{ $statusBorder }};">
                            <div class="flex items-start gap-3 text-sm" style="color:{{ $statusColor }}">
                                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($statusIcon === 'check-circle')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @elseif($statusIcon === 'x-circle')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @endif
                                </svg>
                                <div class="font-medium">
                                    @if(!$buka && !$tutup)
                                        Kuesioner dapat diisi kapan saja (tidak dibatasi waktu).
                                    @elseif($buka && $now < $buka)
                                        Kuesioner belum dibuka. Akan dibuka pada
                                        <strong>{{ \Carbon\Carbon::parse($buka)->isoFormat('D MMMM Y') }}</strong>
                                        — {{ $sisaHari }} hari lagi.
                                    @elseif($tutup && $now > $tutup)
                                        Kuesioner sudah ditutup sejak
                                        <strong>{{ \Carbon\Carbon::parse($tutup)->isoFormat('D MMMM Y') }}</strong>.
                                        Siswa dan guru tidak dapat mengisi kuesioner.
                                    @else
                                        Kuesioner sedang terbuka.
                                        @if($buka) Dibuka sejak
                                        <strong>{{ \Carbon\Carbon::parse($buka)->isoFormat('D MMMM Y') }}</strong>.@endif
                                        @if($tutup) Akan ditutup pada
                                            <strong>{{ \Carbon\Carbon::parse($tutup)->isoFormat('D MMMM Y') }}</strong>
                                        — sisa <strong>{{ $sisaHari }} hari</strong>.@endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Quick-set presets --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide mb-3" style="color:var(--text-muted)">
                                Preset Cepat</p>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" onclick="setPreset(7)"
                                    class="px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                                    style="background:rgba(79,70,229,0.08);border:1px solid rgba(79,70,229,0.2);color:#818cf8;"
                                    onmouseover="this.style.background='rgba(79,70,229,0.15)'"
                                    onmouseout="this.style.background='rgba(79,70,229,0.08)'">
                                    Buka 7 hari ke depan
                                </button>
                                <button type="button" onclick="setPreset(14)"
                                    class="px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                                    style="background:rgba(79,70,229,0.08);border:1px solid rgba(79,70,229,0.2);color:#818cf8;"
                                    onmouseover="this.style.background='rgba(79,70,229,0.15)'"
                                    onmouseout="this.style.background='rgba(79,70,229,0.08)'">
                                    Buka 14 hari ke depan
                                </button>
                                <button type="button" onclick="setPreset(30)"
                                    class="px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                                    style="background:rgba(79,70,229,0.08);border:1px solid rgba(79,70,229,0.2);color:#818cf8;"
                                    onmouseover="this.style.background='rgba(79,70,229,0.15)'"
                                    onmouseout="this.style.background='rgba(79,70,229,0.08)'">
                                    Buka 1 bulan ke depan
                                </button>
                                <button type="button" onclick="clearJadwal()"
                                    class="px-3 py-2 rounded-xl text-xs font-semibold transition-all"
                                    style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);color:#f87171;"
                                    onmouseover="this.style.background='rgba(239,68,68,0.15)'"
                                    onmouseout="this.style.background='rgba(239,68,68,0.08)'">
                                    Hapus jadwal (selalu terbuka)
                                </button>
                            </div>
                        </div>

                        {{-- Date inputs --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold mb-2 uppercase tracking-wide"
                                    style="color:var(--text-muted)">
                                    Tanggal Buka Kuesioner
                                </label>
                                <input type="date" name="buka_kuesioner" id="inputBuka"
                                    value="{{ $settings['buka_kuesioner'] ?? '' }}"
                                    class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                                    style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);"
                                    oninput="validateJadwal()">
                                <p class="mt-1.5 text-xs" style="color:var(--text-muted)">Kosongkan = tidak dibatasi dari
                                    awal.</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-2 uppercase tracking-wide"
                                    style="color:var(--text-muted)">
                                    Tanggal Tutup Kuesioner
                                </label>
                                <input type="date" name="tutup_kuesioner" id="inputTutup"
                                    value="{{ $settings['tutup_kuesioner'] ?? '' }}"
                                    class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                                    style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);"
                                    oninput="validateJadwal()">
                                <p class="mt-1.5 text-xs" style="color:var(--text-muted)">Kosongkan = tidak dibatasi dari
                                    akhir.</p>
                            </div>
                        </div>

                        {{-- Inline validation warning --}}
                        <div id="jadwalWarning" class="hidden px-4 py-3 rounded-xl text-sm font-medium"
                            style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);color:#f87171;">
                            <svg class="w-4 h-4 inline mr-1.5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                            </svg>
                            Tanggal tutup tidak boleh lebih awal dari tanggal buka.
                        </div>
                    </div>
                </div>

                {{-- ── Pengaturan Kuesioner ── --}}
                <div class="rounded-3xl overflow-hidden"
                    style="background:var(--card-bg);border:1px solid var(--card-border);box-shadow:0 1px 8px rgba(26,22,19,0.05);">
                    <div class="p-5 flex items-center gap-4"
                        style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                        <div class="p-2.5 rounded-xl"
                            style="background:rgba(13,148,136,0.1);border:1px solid rgba(13,148,136,0.2);">
                            <svg class="w-5 h-5" style="color:#0D9488" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 011-1h4a2 2 0 011 1" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-base" style="color:var(--text-main)">Pengaturan Kuesioner</h3>
                            <p class="text-xs mt-0.5" style="color:var(--text-muted)">Batasi berapa kali penilai boleh
                                mengisi kuesioner per periode.</p>
                        </div>
                    </div>
                    <div class="p-7">
                        <div class="max-w-xs">
                            <label class="block text-xs font-semibold mb-2 uppercase tracking-wide"
                                style="color:var(--text-muted)">
                                Maksimal Pengisian per Target per Periode
                            </label>
                            <div class="flex items-center gap-4">
                                <input type="number" name="maks_penilaian" min="1" max="10"
                                    value="{{ $settings['maks_penilaian'] ?? 1 }}"
                                    class="w-28 px-4 py-3 rounded-xl text-sm text-center font-bold outline-none transition-all"
                                    style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);">
                                <p class="text-xs" style="color:var(--text-muted)">
                                    kali per guru, per semester.<br>
                                    <span style="color:var(--text-muted);">Set ke <strong>1</strong> agar tidak dapat
                                        diulang.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Tombol Simpan ── --}}
                <div class="flex justify-end">
                    <button type="submit" id="btnSimpan"
                        class="flex items-center gap-2 px-7 py-3.5 rounded-2xl font-semibold text-sm text-white transition-all"
                        style="background:#E8560A;box-shadow:0 4px 16px rgba(232,86,10,0.25);"
                        onmouseover="this.style.background='#C44608'" onmouseout="this.style.background='#E8560A'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </form>
    </div>

    <script>
        // ─── Validasi inline tanggal buka/tutup ───────────────────────────────
        function validateJadwal() {
            const buka = document.getElementById('inputBuka').value;
            const tutup = document.getElementById('inputTutup').value;
            const warn = document.getElementById('jadwalWarning');
            const btn = document.getElementById('btnSimpan');

            if (buka && tutup && tutup < buka) {
                warn.classList.remove('hidden');
                document.getElementById('inputTutup').style.borderColor = 'rgba(239,68,68,0.6)';
                btn.disabled = true;
                btn.style.opacity = '0.5';
                btn.style.cursor = 'not-allowed';
            } else {
                warn.classList.add('hidden');
                document.getElementById('inputTutup').style.borderColor = 'var(--input-border)';
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
            }
        }

        // ─── Preset cepat ────────────────────────────────────────────────────
        function setPreset(days) {
            const today = new Date();
            const tutup = new Date(today);
            tutup.setDate(tutup.getDate() + days);

            document.getElementById('inputBuka').value = formatDate(today);
            document.getElementById('inputTutup').value = formatDate(tutup);
            validateJadwal();
        }

        function clearJadwal() {
            document.getElementById('inputBuka').value = '';
            document.getElementById('inputTutup').value = '';
            validateJadwal();
        }

        function formatDate(d) {
            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            return `${y}-${m}-${dd}`;
        }

        // Jalankan validasi saat load (kalau ada nilai tersimpan yang sudah salah)
        document.addEventListener('DOMContentLoaded', validateJadwal);
    </script>
@endsection
