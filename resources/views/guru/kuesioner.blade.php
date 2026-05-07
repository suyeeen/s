@extends('layouts.app')

@section('title', 'Penilaian Guru')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold" style="color:var(--text-main); letter-spacing:-0.02em;">Penilaian Guru</h1>
                <p class="text-sm mt-2" style="color:var(--text-muted)">Nilai rekan guru berdasarkan indikator kompetensi.
                </p>
            </div>

            {{-- Pilih Guru Dropdown --}}
            <div class="w-full md:w-80 relative" id="dropdownWrapper">
                <input type="hidden" id="pilihGuruVal">
                <button type="button" id="dropdownTrigger" onclick="toggleDropdown()"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-sm transition-all"
                    style="background:var(--input-bg); border:1px solid var(--input-border); color:var(--text-muted);">
                    <span id="dropdownLabel">-- Pilih Guru yang Dinilai --</span>
                    <svg id="dropdownChevron" class="w-4 h-4 shrink-0 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="dropdownList"
                    class="hidden absolute right-0 left-0 z-50 mt-2 rounded-2xl overflow-y-auto shadow-2xl"
                    style="max-height:320px; background:var(--card-bg); border:1px solid var(--card-border);">
                    <div onclick="pilihGuruDrop('', '-- Pilih Guru yang Dinilai --')"
                        class="px-4 py-3 cursor-pointer text-sm font-semibold transition-colors"
                        style="color:var(--text-muted); border-bottom:1px solid var(--card-border-soft);"
                        onmouseover="this.style.background='var(--nav-hover-bg)'"
                        onmouseout="this.style.background='transparent'">
                        -- Pilih Guru yang Dinilai --
                    </div>
                    @foreach ($guru as $g)
                        @if ($g->id !== auth()->user()->guru->id)
                            <div onclick="pilihGuruDrop('{{ $g->id }}', '{{ $g->nama }} — {{ $g->mata_pelajaran }}')"
                                class="px-4 py-3 cursor-pointer text-sm transition-colors"
                                style="color:var(--text-main); border-bottom:1px solid var(--card-border-soft);"
                                onmouseover="this.style.background='var(--nav-hover-bg)'"
                                onmouseout="this.style.background='transparent'">
                                <span class="font-medium">{{ $g->nama }}</span>
                                <span style="color:var(--text-muted)"> — {{ $g->mata_pelajaran }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Info periode --}}
        <div class="kuesioner-info-periode px-5 py-3 rounded-2xl flex items-center gap-3 text-sm font-medium w-fit">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Periode Penilaian: Semester Ganjil 2024/2025
        </div>

        {{-- Info: belum pilih guru --}}
        <div id="infoTidakAdaGuru" class="kuesioner-info-box rounded-3xl p-6 flex items-start gap-5">
            <svg class="w-7 h-7 shrink-0 mt-0.5 kuesioner-info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="font-semibold text-lg kuesioner-info-title">Pilih Guru yang Akan Dinilai</h3>
                <p class="kuesioner-info-body mt-1 text-sm">
                    Pilih nama guru dari dropdown di atas untuk memulai pengisian kuesioner penilaian.
                </p>
            </div>
        </div>

        {{-- Form Kuesioner --}}
        <div id="formKuesioner" class="hidden">
            <form method="POST" action="{{ route('guru.kuesioner.submit') }}" id="formKuesionerEl">
                @csrf
                <input type="hidden" name="guru_id" id="inputGuruId">

                <div class="rounded-3xl overflow-hidden"
                    style="background:var(--card-bg);border:1px solid var(--card-border);">

                    {{-- Progress + Tab --}}
                    <div class="p-8" style="border-bottom:1px solid var(--card-divider);">
                        <div class="flex justify-between text-sm font-medium mb-3">
                            <span style="color:var(--text-muted);">Progress Pengisian</span>
                            <span style="color:var(--accent);">
                                <span id="progressPersen">0</span>%
                                <span style="color:var(--text-muted);">
                                    (<span id="progressIsi">0</span>/<span id="progressTotal">0</span>)
                                </span>
                            </span>
                        </div>
                        <div class="w-full rounded-full h-3"
                            style="background:var(--card-bg-soft); border:1px solid var(--card-border-soft);">
                            <div id="progressBar" class="h-full rounded-full transition-all duration-500"
                                style="width: 0%; background: linear-gradient(90deg, #f97316, #eab308);"></div>
                        </div>

                        {{-- Tab Kategori --}}
                        <div class="flex gap-3 mt-8 overflow-x-auto pb-2">
                            @foreach ($pertanyaan as $kategori => $soalList)
                                <button type="button" onclick="gantiKategori('{{ $kategori }}')" id="tab-{{ $kategori }}"
                                    class="kuesioner-tab-btn px-5 py-2.5 rounded-2xl text-sm font-medium whitespace-nowrap transition-all capitalize">
                                    Kompetensi {{ ucfirst($kategori) }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Soal per Kategori --}}
                    @foreach ($pertanyaan as $kategori => $soalList)
                        <div id="section-{{ $kategori }}" class="kategori-section hidden p-8">
                            <h3 class="text-xl font-semibold mb-8 flex items-center gap-4" style="color:var(--text-main);">
                                <span class="px-3 py-1.5 rounded-xl text-sm font-bold"
                                    style="background:rgba(234,88,12,0.1); color:#ea580c; border:1px solid rgba(234,88,12,0.25);">
                                    Bagian {{ $loop->iteration }} dari {{ $pertanyaan->count() }}
                                </span>
                                Kompetensi {{ ucfirst($kategori) }}
                            </h3>

                            <div class="space-y-6">
                                @foreach ($soalList as $soal)
                                    <div class="soal-card rounded-3xl p-6 transition-all duration-300"
                                        style="background:var(--card-bg-soft);border:1px solid var(--card-border-soft);">
                                        <p class="font-medium mb-6 flex gap-4 text-base leading-relaxed"
                                            style="color:var(--text-main);">
                                            <span class="font-bold shrink-0"
                                                style="color:var(--accent);">{{ $loop->iteration }}.</span>
                                            {{ $soal->teks_pertanyaan }}
                                        </p>
                                        <div class="grid grid-cols-5 gap-3">
                                            @foreach ([1 => 'Sangat Kurang', 2 => 'Kurang', 3 => 'Cukup', 4 => 'Baik', 5 => 'Sangat Baik'] as $val => $label)
                                                <label
                                                    class="jawaban-option flex flex-col items-center justify-center p-4 rounded-2xl cursor-pointer transition-all text-center">
                                                    <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $val }}"
                                                        class="sr-only" onchange="pilihJawaban(this)">
                                                    <span class="text-2xl font-bold mb-2">{{ $val }}</span>
                                                    <span class="text-[10px] leading-tight font-medium">{{ $label }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- Footer Navigasi --}}
                    <div class="p-8 flex justify-between items-center"
                        style="border-top:1px solid var(--card-divider); background:var(--card-bg-soft);">
                        <button type="button" onclick="prevKategori()" id="btnPrev"
                            class="kuesioner-btn-secondary flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-medium transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Sebelumnya
                        </button>
                        <button type="button" onclick="nextKategori()" id="btnNext"
                            class="flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-semibold text-white transition-all"
                            style="background: linear-gradient(135deg, #f97316, #eab308);">
                            Selanjutnya
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <button type="submit" id="btnSubmit"
                            class="hidden flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-semibold text-white transition-all"
                            style="background: linear-gradient(135deg, #10b981, #059669);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Penilaian
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <style>
        /* ─── Info Periode ─── */
        .kuesioner-info-periode {
            background: rgba(37, 99, 235, 0.08);
            border: 1px solid rgba(37, 99, 235, 0.2);
            color: #1D4ED8;
        }

        [data-theme="dark"] .kuesioner-info-periode {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
        }

        /* ─── Info Box (belum pilih guru) ─── */
        .kuesioner-info-box {
            background: rgba(37, 99, 235, 0.05);
            border: 1px solid rgba(37, 99, 235, 0.18);
        }

        [data-theme="dark"] .kuesioner-info-box {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.2);
        }

        .kuesioner-info-icon {
            color: #2563EB;
        }

        [data-theme="dark"] .kuesioner-info-icon {
            color: #60a5fa;
        }

        .kuesioner-info-title {
            color: #1E40AF;
        }

        [data-theme="dark"] .kuesioner-info-title {
            color: #93c5fd;
        }

        .kuesioner-info-body {
            color: #3B82F6;
        }

        [data-theme="dark"] .kuesioner-info-body {
            color: rgba(96, 165, 250, 0.8);
        }

        /* ─── Tab Kategori ─── */
        .kuesioner-tab-btn {
            background: var(--card-bg-soft);
            border: 1px solid var(--card-border-soft);
            color: var(--text-muted);
        }

        .kuesioner-tab-btn:hover {
            color: var(--text-main);
            border-color: var(--card-border);
        }

        .kuesioner-tab-btn.active {
            background: rgba(234, 88, 12, 0.1);
            border: 1px solid rgba(234, 88, 12, 0.3);
            color: #c2410c;
        }

        [data-theme="dark"] .kuesioner-tab-btn.active {
            background: rgba(249, 115, 22, 0.15);
            color: #fb923c;
        }

        /* ─── Soal Card hover ─── */
        .soal-card:hover {
            border-color: var(--card-border) !important;
        }

        /* ─── Jawaban Option ─── */
        .jawaban-option {
            background: var(--card-bg);
            border: 1px solid var(--card-border-soft);
            color: var(--text-muted);
        }

        .jawaban-option:hover {
            background: rgba(234, 88, 12, 0.04);
            border-color: rgba(234, 88, 12, 0.2);
            color: var(--text-main);
        }

        .jawaban-option.selected {
            background: rgba(234, 88, 12, 0.1) !important;
            border: 1px solid rgba(234, 88, 12, 0.4) !important;
            color: #c2410c !important;
        }

        [data-theme="dark"] .jawaban-option {
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 255, 255, 0.06);
            color: #9ca3af;
        }

        [data-theme="dark"] .jawaban-option:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #e5e7eb;
            border-color: rgba(255, 255, 255, 0.1);
        }

        [data-theme="dark"] .jawaban-option.selected {
            background: rgba(249, 115, 22, 0.1) !important;
            border-color: rgba(249, 115, 22, 0.4) !important;
            color: #f97316 !important;
        }

        /* ─── Tombol Sebelumnya ─── */
        .kuesioner-btn-secondary {
            background: var(--card-bg-soft);
            border: 1px solid var(--card-border);
            color: var(--text-muted);
        }

        .kuesioner-btn-secondary:not(:disabled):hover {
            background: var(--nav-hover-bg);
            color: var(--text-main);
        }

        .kuesioner-btn-secondary:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }
    </style>

    <script>
        const kategoriList = @json(array_keys($pertanyaan->toArray()));
        const totalSoal = {{ $pertanyaan->flatten()->count() }};
        let kategoriAktif = 0;

        function toggleDropdown() {
            const list = document.getElementById('dropdownList');
            const chevron = document.getElementById('dropdownChevron');
            const isOpen = !list.classList.contains('hidden');
            list.classList.toggle('hidden', isOpen);
            chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        function pilihGuruDrop(id, label) {
            document.getElementById('dropdownLabel').textContent = label;
            document.getElementById('dropdownLabel').style.color = id ? 'var(--text-main)' : 'var(--text-muted)';
            document.getElementById('dropdownList').classList.add('hidden');
            document.getElementById('dropdownChevron').style.transform = 'rotate(0deg)';
            gantiGuru(id);
        }

        document.addEventListener('click', function (e) {
            const wrapper = document.getElementById('dropdownWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                document.getElementById('dropdownList').classList.add('hidden');
                document.getElementById('dropdownChevron').style.transform = 'rotate(0deg)';
            }
        });

        function gantiGuru(id) {
            document.getElementById('inputGuruId').value = id;
            document.getElementById('infoTidakAdaGuru').classList.toggle('hidden', id !== '');
            document.getElementById('formKuesioner').classList.toggle('hidden', id === '');
            if (id !== '') gantiKategori(kategoriList[0]);
        }

        function gantiKategori(kategori) {
            document.querySelectorAll('.kategori-section').forEach(el => el.classList.add('hidden'));
            document.getElementById('section-' + kategori).classList.remove('hidden');
            kategoriAktif = kategoriList.indexOf(kategori);

            kategoriList.forEach(k => {
                const tab = document.getElementById('tab-' + k);
                tab.classList.toggle('active', k === kategori);
            });

            const btnPrev = document.getElementById('btnPrev');
            btnPrev.disabled = kategoriAktif === 0;
            document.getElementById('btnNext').classList.toggle('hidden', kategoriAktif === kategoriList.length - 1);
            document.getElementById('btnSubmit').classList.toggle('hidden', kategoriAktif !== kategoriList.length - 1);
        }

        function nextKategori() {
            if (kategoriAktif < kategoriList.length - 1) gantiKategori(kategoriList[kategoriAktif + 1]);
        }

        function prevKategori() {
            if (kategoriAktif > 0) gantiKategori(kategoriList[kategoriAktif - 1]);
        }

        function pilihJawaban(input) {
            const options = input.closest('.grid').querySelectorAll('.jawaban-option');
            options.forEach(opt => opt.classList.remove('selected'));
            input.closest('.jawaban-option').classList.add('selected');
            updateProgress();
        }

        function updateProgress() {
            const terisi = document.querySelectorAll('input[type=radio]:checked').length;
            const persen = Math.round(terisi / totalSoal * 100);
            document.getElementById('progressBar').style.width = persen + '%';
            document.getElementById('progressPersen').textContent = persen;
            document.getElementById('progressIsi').textContent = terisi;
            document.getElementById('progressTotal').textContent = totalSoal;
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('progressTotal').textContent = totalSoal;
        });
    </script>
@endsection
