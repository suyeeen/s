@extends('layouts.app')

@section('title', 'Data Prestasi')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8" x-data="{ modalOpen: false }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold" style="color:var(--text-main); letter-spacing:-0.02em;">Data Prestasi & Sertifikasi</h1>
                <p class="text-sm mt-2" style="color:var(--text-muted)">Kelola portofolio pengembangan profesional Anda.</p>
            </div>
            <button @click="modalOpen = true"
                class="flex items-center gap-2 px-5 py-3 rounded-2xl font-semibold text-white text-sm transition-all"
                style="background: linear-gradient(135deg, #f97316, #eab308); box-shadow: 0 8px 32px rgba(249,115,22,0.3);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Prestasi
            </button>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- Tervalidasi - highlighted card --}}
            <div class="prestasi-stat-highlight rounded-3xl p-6 relative overflow-hidden">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-medium prestasi-stat-highlight-label">Total Tervalidasi</h3>
                    <div class="p-2.5 rounded-xl prestasi-stat-highlight-icon-bg">
                        <svg class="w-6 h-6 prestasi-stat-highlight-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold prestasi-stat-highlight-value">{{ $statistik['tervalidasi'] }}</div>
                <p class="text-sm mt-2 prestasi-stat-highlight-sub">Sertifikat terverifikasi</p>
            </div>

            {{-- Menunggu Validasi --}}
            <div class="rounded-3xl p-6" style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-medium" style="color:var(--text-muted);">Menunggu Validasi</h3>
                    <div class="p-2.5 rounded-xl"
                        style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2);">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold" style="color:var(--text-main);">{{ $statistik['menunggu'] }}</div>
            </div>

            {{-- Poin Portofolio --}}
            <div class="rounded-3xl p-6" style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-medium" style="color:var(--text-muted);">Poin Portofolio</h3>
                    <div class="p-2.5 rounded-xl"
                        style="background: rgba(139,92,246,0.1); border: 1px solid rgba(139,92,246,0.2);">
                        <svg class="w-6 h-6 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold" style="color:var(--text-main);">{{ $statistik['poin'] }}</div>
                <p class="text-sm mt-2" style="color:var(--text-muted);">Estimasi poin</p>
            </div>
        </div>

        {{-- Daftar Prestasi --}}
        <div class="rounded-3xl overflow-hidden" style="background:var(--card-bg);border:1px solid var(--card-border);">

            <div class="p-6" style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                <h3 class="font-semibold text-lg" style="color:var(--text-main);">Riwayat Prestasi & Pelatihan</h3>
            </div>

            @forelse($prestasi as $item)
                <div class="prestasi-row p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5 transition-colors"
                    style="border-bottom:1px solid var(--card-border-soft);">

                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0"
                            style="background:var(--card-bg-soft); border:1px solid var(--card-border);">
                            <svg class="w-7 h-7" style="color:var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-lg" style="color:var(--text-main);">{{ $item->nama_prestasi }}</h4>
                            <div class="flex flex-wrap items-center gap-3 mt-2 text-sm" style="color:var(--text-muted);">
                                <span class="px-2.5 py-1 rounded-lg font-medium prestasi-badge-kategori">
                                    {{ $item->kategori }}
                                </span>
                                <span>•</span>
                                <span>{{ ucfirst($item->tingkat) }}</span>
                                <span>•</span>
                                <span>{{ $item->tahun }}</span>
                            </div>
                            @if ($item->file_bukti)
                                <a href="{{ Storage::url($item->file_bukti) }}" target="_blank"
                                    class="flex items-center gap-1.5 mt-3 text-sm transition-colors w-fit"
                                    style="color: #2563EB;"
                                    onmouseover="this.style.color='#1D4ED8'"
                                    onmouseout="this.style.color='#2563EB'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    Lihat Dokumen
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-4 shrink-0">
                        {{-- Badge status --}}
                        @php
                            $statusStyle = match ($item->status) {
                                'tervalidasi' => [
                                    'light_bg'    => 'rgba(5,150,105,0.08)',
                                    'light_color' => '#065F46',
                                    'light_border'=> 'rgba(5,150,105,0.2)',
                                    'dark_bg'     => 'rgba(16,185,129,0.1)',
                                    'dark_color'  => '#34d399',
                                    'dark_border' => 'rgba(16,185,129,0.2)',
                                    'label'       => 'Tervalidasi',
                                ],
                                'menunggu' => [
                                    'light_bg'    => 'rgba(180,83,9,0.08)',
                                    'light_color' => '#92400E',
                                    'light_border'=> 'rgba(180,83,9,0.2)',
                                    'dark_bg'     => 'rgba(245,158,11,0.1)',
                                    'dark_color'  => '#fbbf24',
                                    'dark_border' => 'rgba(245,158,11,0.2)',
                                    'label'       => 'Menunggu',
                                ],
                                'ditolak' => [
                                    'light_bg'    => 'rgba(185,28,28,0.08)',
                                    'light_color' => '#991B1B',
                                    'light_border'=> 'rgba(185,28,28,0.2)',
                                    'dark_bg'     => 'rgba(239,68,68,0.1)',
                                    'dark_color'  => '#f87171',
                                    'dark_border' => 'rgba(239,68,68,0.2)',
                                    'label'       => 'Ditolak',
                                ],
                                default => [
                                    'light_bg'    => 'rgba(100,116,139,0.08)',
                                    'light_color' => '#475569',
                                    'light_border'=> 'rgba(100,116,139,0.2)',
                                    'dark_bg'     => 'rgba(255,255,255,0.05)',
                                    'dark_color'  => '#9ca3af',
                                    'dark_border' => 'rgba(255,255,255,0.1)',
                                    'label'       => $item->status,
                                ],
                            };
                        @endphp
                        <span class="prestasi-status-badge px-3 py-1.5 rounded-xl text-xs font-bold"
                            data-light-bg="{{ $statusStyle['light_bg'] }}"
                            data-light-color="{{ $statusStyle['light_color'] }}"
                            data-light-border="{{ $statusStyle['light_border'] }}"
                            data-dark-bg="{{ $statusStyle['dark_bg'] }}"
                            data-dark-color="{{ $statusStyle['dark_color'] }}"
                            data-dark-border="{{ $statusStyle['dark_border'] }}">
                            {{ $statusStyle['label'] }}
                        </span>

                        {{-- Hapus --}}
                        @if ($item->status === 'menunggu')
                            <form method="POST" action="{{ route('guru.prestasi.destroy', $item->id) }}"
                                class="swal-delete" data-nama="prestasi ini">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="prestasi-btn-hapus p-2.5 rounded-xl transition-all"
                                    style="background:var(--card-bg-soft); border:1px solid var(--card-border-soft);">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-10 text-center" style="color:var(--text-muted);">
                    Belum ada data prestasi. Klik tombol "Tambah Prestasi" untuk menambahkan.
                </div>
            @endforelse
        </div>

        {{-- ── Modal Tambah Prestasi ── --}}
        <div x-show="modalOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background: rgba(0,0,0,0.5); backdrop-filter: blur(8px);">

            <div x-show="modalOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="w-full max-w-xl rounded-3xl overflow-hidden shadow-2xl"
                style="background:var(--card-bg); border:1px solid var(--card-border);">

                {{-- Modal Header --}}
                <div class="p-6 flex justify-between items-center"
                    style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                    <h3 class="font-bold text-xl" style="color:var(--text-main);">Tambah Prestasi Baru</h3>
                    <button @click="modalOpen = false"
                        class="p-2 rounded-xl transition-colors prestasi-modal-close"
                        style="background:var(--btn-bg);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Modal Form --}}
                <form method="POST" action="{{ route('guru.prestasi.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="p-8 space-y-5">

                        <div>
                            <label class="block text-sm font-medium mb-2" style="color:var(--text-main);">Judul Prestasi / Pelatihan</label>
                            <input type="text" name="nama_prestasi" required
                                placeholder="Contoh: Juara 1 Guru Teladan Tingkat Kota..."
                                class="w-full px-4 py-3 rounded-2xl text-sm outline-none transition-all"
                                style="background:var(--input-bg); border:1.5px solid var(--input-border); color:var(--text-main);"
                                onfocus="this.style.borderColor='rgba(234,88,12,0.5)'"
                                onblur="this.style.borderColor='var(--input-border)'">
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color:var(--text-main);">Kategori</label>
                                <select name="kategori" id="selectKategori" required
                                    onchange="toggleKategoriLainnya(this.value)"
                                    class="stqm-select w-full px-4 py-3 rounded-2xl text-sm outline-none"
                                    onfocus="this.style.borderColor='rgba(234,88,12,0.5)'"
                                    onblur="this.style.borderColor='var(--input-border)'">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach ([
                                        'Sertifikat Pendidik',
                                        'Pelatihan & Workshop',
                                        'Karya Ilmiah',
                                        'Guru Berprestasi',
                                        'Inovasi Pembelajaran',
                                        'Pengabdian Masyarakat',
                                        'Organisasi Profesi',
                                        'Lainnya',
                                    ] as $kat)
                                        <option value="{{ $kat }}">{{ $kat }}</option>
                                    @endforeach
                                </select>
                                <div id="inputLainnya" style="display:none;" class="mt-3">
                                    <input type="text" name="kategori_lainnya" id="kategoriLainnyaInput"
                                        placeholder="Tuliskan kategori..."
                                        class="w-full px-4 py-3 rounded-2xl text-sm outline-none"
                                        style="background:var(--input-bg);border:1.5px solid rgba(234,88,12,0.4);color:var(--text-main);"
                                        onfocus="this.style.borderColor='rgba(234,88,12,0.7)'"
                                        onblur="this.style.borderColor='rgba(234,88,12,0.4)'">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2" style="color:var(--text-main);">Tingkat</label>
                                <select name="tingkat"
                                    class="stqm-select w-full px-4 py-3 rounded-2xl text-sm outline-none"
                                    onfocus="this.style.borderColor='rgba(234,88,12,0.5)'"
                                    onblur="this.style.borderColor='var(--input-border)'">
                                    <option value="">— (Tidak Ditentukan)</option>
                                    @foreach (['sekolah', 'kecamatan', 'kota', 'provinsi', 'nasional', 'internasional'] as $tkt)
                                        <option value="{{ $tkt }}">{{ ucfirst($tkt) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2" style="color:var(--text-main);">Tahun</label>
                            <input type="number" name="tahun" required min="2000" max="{{ date('Y') }}"
                                value="{{ date('Y') }}"
                                class="w-full px-4 py-3 rounded-2xl text-sm outline-none"
                                style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);"
                                onfocus="this.style.borderColor='rgba(234,88,12,0.5)'"
                                onblur="this.style.borderColor='var(--input-border)'">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2" style="color:var(--text-main);">Upload Sertifikat / Bukti (PDF/JPG/PNG)</label>
                            <label class="prestasi-upload-zone block rounded-2xl p-10 text-center cursor-pointer transition-all">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                                    style="background:var(--card-bg-soft);">
                                    <svg class="w-8 h-8" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                </div>
                                <p class="text-base font-medium" style="color:var(--text-main);">Klik untuk upload atau drag & drop</p>
                                <p class="text-sm mt-2" style="color:var(--text-muted);">Maksimal ukuran file 5MB</p>
                                <input type="file" name="file_bukti" required class="hidden"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    onchange="document.getElementById('namaFile').textContent = this.files[0]?.name ?? ''">
                            </label>
                            <p id="namaFile" class="text-sm mt-2 text-center" style="color:var(--accent);"></p>
                        </div>
                    </div>

                    <div class="p-6 flex justify-end gap-4"
                        style="border-top:1px solid var(--card-divider); background:var(--card-bg-soft);">
                        <button type="button" @click="modalOpen = false"
                            class="prestasi-btn-batal px-6 py-3 rounded-2xl text-sm font-medium transition-all">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-3 rounded-2xl text-sm font-semibold text-white transition-all"
                            style="background: linear-gradient(135deg, #f97316, #eab308);">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <style>
        /* ─── Stat Card Highlight (Tervalidasi) ─── */
        .prestasi-stat-highlight {
            background: linear-gradient(135deg, rgba(234,88,12,0.1), rgba(234,179,8,0.06));
            border: 1px solid rgba(234,88,12,0.25);
        }
        [data-theme="dark"] .prestasi-stat-highlight {
            background: linear-gradient(135deg, rgba(249,115,22,0.2), rgba(234,179,8,0.1));
            border-color: rgba(249,115,22,0.3);
        }
        .prestasi-stat-highlight-label { color: #9A3412; }
        [data-theme="dark"] .prestasi-stat-highlight-label { color: #fed7aa; }
        .prestasi-stat-highlight-icon-bg { background: rgba(234,88,12,0.12); }
        [data-theme="dark"] .prestasi-stat-highlight-icon-bg { background: rgba(249,115,22,0.2); }
        .prestasi-stat-highlight-icon { color: #ea580c; }
        [data-theme="dark"] .prestasi-stat-highlight-icon { color: #fb923c; }
        .prestasi-stat-highlight-value { color: #7C2D12; }
        [data-theme="dark"] .prestasi-stat-highlight-value { color: #ffffff; }
        .prestasi-stat-highlight-sub { color: #C2410C; }
        [data-theme="dark"] .prestasi-stat-highlight-sub { color: #fdba74; }

        /* ─── Baris Prestasi hover ─── */
        .prestasi-row:hover {
            background: rgba(234, 88, 12, 0.03);
        }

        /* ─── Badge Kategori ─── */
        .prestasi-badge-kategori {
            background: var(--card-bg-soft);
            border: 1px solid var(--card-border);
            color: var(--text-main);
        }

        /* ─── Tombol Hapus ─── */
        .prestasi-btn-hapus {
            color: var(--text-muted);
        }
        .prestasi-btn-hapus:hover {
            color: #DC2626;
            background: rgba(220,38,38,0.08) !important;
            border-color: rgba(220,38,38,0.2) !important;
        }

        /* ─── Modal Close button ─── */
        .prestasi-modal-close {
            color: var(--text-muted);
        }
        .prestasi-modal-close:hover {
            color: var(--text-main);
        }

        /* ─── Tombol Batal ─── */
        .prestasi-btn-batal {
            background: var(--card-bg-soft);
            border: 1px solid var(--card-border);
            color: var(--text-muted);
        }
        .prestasi-btn-batal:hover {
            background: var(--nav-hover-bg);
            color: var(--text-main);
        }

        /* ─── Upload Zone ─── */
        .prestasi-upload-zone {
            background: var(--card-bg-soft);
            border: 2px dashed var(--card-border);
        }
        .prestasi-upload-zone:hover {
            border-color: rgba(234,88,12,0.4);
        }

        /* ─── Select ─── */
        .stqm-select {
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            color: var(--text-main);
            appearance: auto;
            -webkit-appearance: auto;
        }
        [data-theme="dark"] .stqm-select option {
            background-color: #1a1a2e;
            color: #e5e7eb;
        }
        [data-theme="light"] .stqm-select option {
            background-color: #ffffff;
            color: #1f2937;
        }
    </style>

    <script>
        /* ─── Apply status badge colors based on theme ─── */
        function applyStatusBadges() {
            const theme = document.documentElement.getAttribute('data-theme') || 'light';
            document.querySelectorAll('.prestasi-status-badge').forEach(badge => {
                const bg     = badge.dataset[theme + 'Bg'];
                const color  = badge.dataset[theme + 'Color'];
                const border = badge.dataset[theme + 'Border'];
                badge.style.background = bg;
                badge.style.color = color;
                badge.style.border = '1px solid ' + border;
            });
        }

        document.addEventListener('DOMContentLoaded', applyStatusBadges);

        /* Re-apply if theme toggles */
        const observer = new MutationObserver(applyStatusBadges);
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

        function toggleKategoriLainnya(val) {
            const wrapper = document.getElementById('inputLainnya');
            const input   = document.getElementById('kategoriLainnyaInput');
            if (!wrapper || !input) return;
            if (val === 'Lainnya') {
                wrapper.style.display = 'block';
                input.required = true;
            } else {
                wrapper.style.display = 'none';
                input.required = false;
                input.value = '';
            }
        }
    </script>
@endsection
