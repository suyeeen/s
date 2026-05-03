@extends('layouts.app')

@section('title', 'Isi Kuesioner')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold" style="color:var(--text-main)" tracking-tight">Evaluasi Kinerja Guru</h1>
                <p class="text-sm mt-2" style="color:var(--text-muted)">Isi kuesioner dengan jujur dan objektif.</p>
            </div>

            {{-- Pilih Guru --}}
            <div class="w-full md:w-80">
                <select id="pilihGuru" class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none transition-all"
                    style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);"
                    onchange="gantiGuru(this.value)">
                    <option value="">-- Pilih Guru yang Dinilai --</option>
                    @foreach ($guru as $g)
                        <option value="{{ $g->id }}" style="background: #0a0a14;">
                            {{ $g->nama }} - {{ $g->mata_pelajaran }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Info: belum pilih guru --}}
        <div id="infoTidakAdaGuru" class="rounded-3xl p-6 flex items-start gap-5"
            style="background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2);">
            <svg class="w-7 h-7 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="font-semibold text-blue-300 text-lg">Pilih Guru Terlebih Dahulu</h3>
                <p class="text-blue-400/80 mt-1 text-sm">
                    Silakan pilih guru yang ingin Anda evaluasi dari dropdown di atas untuk memulai pengisian kuesioner.
                </p>
            </div>
        </div>

        {{-- Form Kuesioner (tersembunyi sampai guru dipilih) --}}
        <div id="formKuesioner" class="hidden">
            <form method="POST" action="{{ route('siswa.kuesioner.submit') }}" id="formKuesionerEl">
                @csrf
                <input type="hidden" name="guru_id" id="inputGuruId">

                {{-- Progress Bar --}}
                <div class="rounded-3xl overflow-hidden"
                    style="background:var(--card-bg);border:1px solid var(--card-border);">

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
                                <button type="button" onclick="gantiKategori('{{ $kategori }}')"
                                    id="tab-{{ $kategori }}"
                                    class="px-5 py-2.5 rounded-2xl text-sm font-medium whitespace-nowrap transition-all capitalize">
                                    {{ $kategori }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Soal per Kategori --}}
                    @foreach ($pertanyaan as $kategori => $soalList)
                        <div id="section-{{ $kategori }}" class="kategori-section hidden p-8">
                            <h3 class="text-xl font-semibold text-white mb-8 flex items-center gap-4">
                                <span class="px-3 py-1.5 rounded-xl text-sm font-bold capitalize"
                                    style="background: rgba(249,115,22,0.15); color: #f97316; border: 1px solid rgba(249,115,22,0.2);">
                                    Kompetensi {{ ucfirst($kategori) }}
                                </span>
                            </h3>

                            <div class="space-y-6">
                                @foreach ($soalList as $index => $soal)
                                    <div class="rounded-3xl p-6 transition-all duration-300"
                                        style="background:var(--card-bg-soft);border:1px solid var(--card-border-soft);"
                                        onmouseover="this.style.background='rgba(255,255,255,0.04)'"
                                        onmouseout="this.style.background='rgba(255,255,255,0.02)'">

                                        <p class="font-medium text-gray-200 mb-6 flex gap-4 text-base leading-relaxed">
                                            <span class="text-orange-500 font-bold shrink-0">{{ $loop->iteration }}.</span>
                                            {{ $soal->teks_pertanyaan }}
                                        </p>

                                        <div class="grid grid-cols-5 gap-3">
                                            @foreach ([1 => 'Sangat Tidak Setuju', 2 => 'Tidak Setuju', 3 => 'Cukup Setuju', 4 => 'Setuju', 5 => 'Sangat Setuju'] as $val => $label)
                                                <label
                                                    class="jawaban-option flex flex-col items-center justify-center p-4 rounded-2xl cursor-pointer transition-all text-center"
                                                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); color: #9ca3af;"
                                                    onmouseover="if(!this.classList.contains('selected')) { this.style.background='rgba(255,255,255,0.06)'; this.style.color='#e5e7eb'; }"
                                                    onmouseout="if(!this.classList.contains('selected')) { this.style.background='rgba(255,255,255,0.03)'; this.style.color='#9ca3af'; }">
                                                    <input type="radio" name="jawaban[{{ $soal->id }}]"
                                                        value="{{ $val }}" class="sr-only"
                                                        onchange="pilihjawaban(this)">
                                                    <span class="text-2xl font-bold mb-2">{{ $val }}</span>
                                                    <span
                                                        class="text-[10px] leading-tight font-medium">{{ $label }}</span>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Kirim Evaluasi
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

        // Ganti guru
        function gantiGuru(id) {
            document.getElementById('inputGuruId').value = id;
            document.getElementById('infoTidakAdaGuru').classList.toggle('hidden', id !== '');
            document.getElementById('formKuesioner').classList.toggle('hidden', id === '');
            if (id !== '') gantiKategori(kategoriList[0]);
        }

        // Ganti kategori/tab
        function gantiKategori(kategori) {
            document.querySelectorAll('.kategori-section').forEach(el => el.classList.add('hidden'));
            document.getElementById('section-' + kategori).classList.remove('hidden');

            kategoriAktif = kategoriList.indexOf(kategori);

            // Update style tab
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

            // Tombol prev/next/submit
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

        // Pilih jawaban → update style + progress
        function pilihjawaban(input) {
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

        // Update progress bar
        function updateProgress() {
            const terisi = document.querySelectorAll('input[type=radio]:checked').length;
            const persen = Math.round(terisi / totalSoal * 100);
            document.getElementById('progressBar').style.width = persen + '%';
            document.getElementById('progressPersen').textContent = persen;
            document.getElementById('progressIsi').textContent = terisi;
            document.getElementById('progressTotal').textContent = totalSoal;
        }

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('progressTotal').textContent = totalSoal;
        });
    </script>
@endsection
