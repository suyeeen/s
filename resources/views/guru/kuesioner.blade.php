@extends('layouts.app')

@section('title', 'Penilaian Guru')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold" style="color:var(--text-main)" tracking-tight">Penilaian Guru</h1>
                <p class="text-sm mt-2" style="color:var(--text-muted)">Nilai rekan guru berdasarkan indikator kompetensi.
                </p>
            </div>

            {{-- Pilih Guru yang Dinilai (Custom Dropdown) --}}
            <div class="w-full md:w-80 relative" id="dropdownWrapper">
                {{-- Hidden real input for form --}}
                <input type="hidden" id="pilihGuruVal">

                {{-- Trigger button --}}
                <button type="button" id="dropdownTrigger" onclick="toggleDropdown()"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-sm transition-all"
                    style="background:var(--input-bg); border:1px solid var(--input-border); color:var(--text-muted);">
                    <span id="dropdownLabel">-- Pilih Guru yang Dinilai --</span>
                    <svg id="dropdownChevron" class="w-4 h-4 shrink-0 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Dropdown list --}}
                <div id="dropdownList"
                    class="hidden absolute right-0 left-0 z-50 mt-2 rounded-2xl overflow-y-auto shadow-2xl"
                    style="max-height:320px; background:var(--card-bg); border:1px solid var(--card-border);">

                    {{-- Opsi default --}}
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
        <div class="px-5 py-3 rounded-2xl flex items-center gap-3 text-sm font-medium w-fit"
            style="background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2); color: #60a5fa;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Periode Penilaian: Semester Ganjil 2024/2025
        </div>

        {{-- Info: belum pilih guru --}}
        <div id="infoTidakAdaGuru" class="rounded-3xl p-6 flex items-start gap-5"
            style="background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2);">
            <svg class="w-7 h-7 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="font-semibold text-blue-300 text-lg">Pilih Guru yang Akan Dinilai</h3>
                <p class="text-blue-400/80 mt-1 text-sm">
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
                        <div class="flex justify-between text-sm font-medium text-gray-400 mb-3">
                            <span>Progress Pengisian</span>
                            <span class="text-orange-400">
                                <span id="progressPersen">0</span>%
                                <span class="text-gray-500">
                                    (<span id="progressIsi">0</span>/<span id="progressTotal">0</span>)
                                </span>
                            </span>
                        </div>
                        <div class="w-full rounded-full h-3"
                            style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.05);">
                            <div id="progressBar" class="h-full rounded-full transition-all duration-500"
                                style="width: 0%; background: linear-gradient(90deg, #f97316, #eab308);"></div>
                        </div>

                        {{-- Tab Kategori --}}
                        <div class="flex gap-3 mt-8 overflow-x-auto pb-2">
                            @foreach ($pertanyaan as $kategori => $soalList)
                                <button type="button" onclick="gantiKategori('{{ $kategori }}')" id="tab-{{ $kategori }}"
                                    class="px-5 py-2.5 rounded-2xl text-sm font-medium whitespace-nowrap transition-all capitalize"
                                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); color: #9ca3af;">
                                    Kompetensi {{ ucfirst($kategori) }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Soal per Kategori --}}
                    @foreach ($pertanyaan as $kategori => $soalList)
                        <div id="section-{{ $kategori }}" class="kategori-section hidden p-8">
                            <h3 class="text-xl font-semibold text-white mb-8 flex items-center gap-4">
                                <span class="px-3 py-1.5 rounded-xl text-sm font-bold"
                                    style="background: rgba(249,115,22,0.15); color: #f97316; border: 1px solid rgba(249,115,22,0.2);">
                                    Bagian {{ $loop->iteration }} dari {{ $pertanyaan->count() }}
                                </span>
                                Kompetensi {{ ucfirst($kategori) }}
                            </h3>

                            <div class="space-y-6">
                                @foreach ($soalList as $soal)
                                    <div class="rounded-3xl p-6 transition-all duration-300"
                                        style="background:var(--card-bg-soft);border:1px solid var(--card-border-soft);"
                                        onmouseover="this.style.background='rgba(255,255,255,0.04)'"
                                        onmouseout="this.style.background='rgba(255,255,255,0.02)'">

                                        <p class="font-medium text-gray-200 mb-6 flex gap-4 text-base leading-relaxed">
                                            <span class="text-orange-500 font-bold shrink-0">{{ $loop->iteration }}.</span>
                                            {{ $soal->teks_pertanyaan }}
                                        </p>

                                        <div class="grid grid-cols-5 gap-3">
                                            @foreach ([1 => 'Sangat Kurang', 2 => 'Kurang', 3 => 'Cukup', 4 => 'Baik', 5 => 'Sangat Baik'] as $val => $label)
                                                <label
                                                    class="jawaban-option flex flex-col items-center justify-center p-4 rounded-2xl cursor-pointer transition-all text-center"
                                                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); color: #9ca3af;"
                                                    onmouseover="if(!this.classList.contains('selected')){ this.style.background='rgba(255,255,255,0.06)'; this.style.color='#e5e7eb'; }"
                                                    onmouseout="if(!this.classList.contains('selected')){ this.style.background='rgba(255,255,255,0.03)'; this.style.color='#9ca3af'; }">
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
                        style="border-top: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">

                        <button type="button" onclick="prevKategori()" id="btnPrev"
                            class="flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-medium text-gray-400 transition-all"
                            style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
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

    <script>
        const kategoriList = @json(array_keys($pertanyaan->toArray()));
        const totalSoal = {{ $pertanyaan->flatten()->count() }};
        let kategoriAktif = 0;

        /* ── Custom Dropdown ── */
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

        // Tutup dropdown kalau klik di luar
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
                if (k === kategori) {
                    tab.style.background = 'linear-gradient(135deg, rgba(249,115,22,0.2), rgba(234,179,8,0.1))';
                    tab.style.border = '1px solid rgba(249,115,22,0.3)';
                    tab.style.color = 'white';
                } else {
                    tab.style.background = 'rgba(255,255,255,0.03)';
                    tab.style.border = '1px solid rgba(255,255,255,0.06)';
                    tab.style.color = '#9ca3af';
                }
            });

            document.getElementById('btnPrev').style.opacity = kategoriAktif === 0 ? '0.3' : '1';
            document.getElementById('btnPrev').disabled = kategoriAktif === 0;
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
            options.forEach(opt => {
                opt.classList.remove('selected');
                opt.style.background = 'rgba(255,255,255,0.03)';
                opt.style.border = '1px solid rgba(255,255,255,0.06)';
                opt.style.color = '#9ca3af';
            });
            const selected = input.closest('.jawaban-option');
            selected.classList.add('selected');
            selected.style.background = 'rgba(249,115,22,0.1)';
            selected.style.border = '1px solid rgba(249,115,22,0.4)';
            selected.style.color = '#f97316';
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
