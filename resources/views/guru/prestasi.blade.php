@extends('layouts.app')

@section('title', 'Data Prestasi')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8" x-data="{ modalOpen: false }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold" style="color:var(--text-main)" tracking-tight">Data Prestasi & Sertifikasi</h1>
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
            <div class="rounded-3xl p-6 relative overflow-hidden"
                style="background: linear-gradient(135deg, rgba(249,115,22,0.2), rgba(234,179,8,0.1)); border: 1px solid rgba(249,115,22,0.3);">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-medium text-orange-200">Total Tervalidasi</h3>
                    <div class="p-2.5 rounded-xl" style="background: rgba(249,115,22,0.2);">
                        <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold text-white">{{ $statistik['tervalidasi'] }}</div>
                <p class="text-sm text-orange-300 mt-2">Sertifikat terverifikasi</p>
            </div>

            <div class="rounded-3xl p-6"
                style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-medium text-gray-400">Menunggu Validasi</h3>
                    <div class="p-2.5 rounded-xl"
                        style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2);">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold text-white">{{ $statistik['menunggu'] }}</div>
            </div>

            <div class="rounded-3xl p-6"
                style="background:var(--card-bg);border:1px solid var(--card-border);">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-medium text-gray-400">Poin Portofolio</h3>
                    <div class="p-2.5 rounded-xl"
                        style="background: rgba(139,92,246,0.1); border: 1px solid rgba(139,92,246,0.2);">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold text-white">{{ $statistik['poin'] }}</div>
                <p class="text-sm text-gray-500 mt-2">Estimasi poin</p>
            </div>
        </div>

        {{-- Daftar Prestasi --}}
        <div class="rounded-3xl overflow-hidden"
            style="background:var(--card-bg);border:1px solid var(--card-border);">

            <div class="p-6"
                style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                <h3 class="font-semibold text-white text-lg">Riwayat Prestasi & Pelatihan</h3>
            </div>

            @forelse($prestasi as $item)
                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5 transition-colors"
                    style="border-bottom:1px solid var(--card-border-soft);"
                    onmouseover="this.style.background='rgba(26,22,19,0.03)'" onmouseout="this.style.background='transparent'" >

                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0"
                            style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);">
                            <svg class="w-7 h-7 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white text-lg">{{ $item->nama_prestasi }}</h4>
                            <div class="flex flex-wrap items-center gap-3 mt-2 text-sm text-gray-400">
                                <span class="px-2.5 py-1 rounded-lg text-gray-300 font-medium"
                                    style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                                    {{ $item->kategori }}
                                </span>
                                <span>•</span>
                                <span>{{ ucfirst($item->tingkat) }}</span>
                                <span>•</span>
                                <span>{{ $item->tahun }}</span>
                            </div>
                            @if ($item->file_bukti)
                                <a href="{{ Storage::url($item->file_bukti) }}" target="_blank"
                                    class="flex items-center gap-1.5 mt-3 text-sm text-blue-400 hover:text-blue-300 transition-colors w-fit">
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
                                    'bg' => 'rgba(16,185,129,0.1)',
                                    'color' => '#34d399',
                                    'border' => 'rgba(16,185,129,0.2)',
                                    'label' => 'Tervalidasi',
                                ],
                                'menunggu' => [
                                    'bg' => 'rgba(245,158,11,0.1)',
                                    'color' => '#fbbf24',
                                    'border' => 'rgba(245,158,11,0.2)',
                                    'label' => 'Menunggu',
                                ],
                                'ditolak' => [
                                    'bg' => 'rgba(239,68,68,0.1)',
                                    'color' => '#f87171',
                                    'border' => 'rgba(239,68,68,0.2)',
                                    'label' => 'Ditolak',
                                ],
                                default => [
                                    'bg' => 'rgba(255,255,255,0.05)',
                                    'color' => '#9ca3af',
                                    'border' => 'rgba(255,255,255,0.1)',
                                    'label' => $item->status,
                                ],
                            };
                        @endphp
                        <span class="px-3 py-1.5 rounded-xl text-xs font-bold"
                            style="background: {{ $statusStyle['bg'] }}; color: {{ $statusStyle['color'] }}; border: 1px solid {{ $statusStyle['border'] }};">
                            {{ $statusStyle['label'] }}
                        </span>

                        {{-- Hapus --}}
                        @if ($item->status === 'menunggu')
                            <form method="POST" action="{{ route('guru.prestasi.destroy', $item->id) }}"
                                class="swal-delete" data-nama="prestasi ini">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2.5 rounded-xl text-gray-500 hover:text-red-400 transition-all"
                                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
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
                <div class="p-10 text-center text-gray-500">
                    Belum ada data prestasi. Klik tombol "Tambah Prestasi" untuk menambahkan.
                </div>
            @endforelse
        </div>

        {{-- ── Modal Tambah Prestasi ── --}}
        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background: rgba(0,0,0,0.6); backdrop-filter: blur(8px);">

            <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="w-full max-w-xl rounded-3xl overflow-hidden shadow-2xl"
                style="background: #0e0e1a; border: 1px solid rgba(255,255,255,0.08);">

                {{-- Modal Header --}}
                <div class="p-6 flex justify-between items-center"
                    style="border-bottom:1px solid var(--card-divider);background:var(--card-bg-soft);">
                    <h3 class="font-bold text-white text-xl">Tambah Prestasi Baru</h3>
                    <button @click="modalOpen = false"
                        class="p-2 rounded-xl text-gray-400 hover:text-white transition-colors"
                        style="background: rgba(255,255,255,0.05);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Modal Form --}}
                <form method="POST" action="{{ route('guru.prestasi.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="p-8 space-y-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Judul Prestasi / Pelatihan</label>
                            <input type="text" name="nama_prestasi" required
                                placeholder="Contoh: Juara 1 Guru Teladan Tingkat Kota..."
                                class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none transition-all placeholder-gray-600"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);"
                                onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                                onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
                        </div>

                        <div class="grid grid-cols-2 gap-5">

    {{-- Kategori --}}
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">Kategori</label>
        <select name="kategori" id="selectKategori" required
                onchange="toggleKategoriLainnya(this.value)"
                class="w-full px-4 py-3 rounded-2xl text-sm outline-none"
                style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);"
                onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                onblur="this.style.borderColor='var(--input-border)'">
            <option value="" disabled selected style="background:var(--card-bg)">-- Pilih Kategori --</option>
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
                <option value="{{ $kat }}" style="background:var(--card-bg)">{{ $kat }}</option>
            @endforeach
        </select>

        {{-- Input teks muncul kalau pilih Lainnya --}}
        <div id="inputLainnya" style="display:none;" class="mt-3">
            <input type="text" name="kategori_lainnya"
                   id="kategoriLainnyaInput"
                   placeholder="Tuliskan kategori..."
                   class="w-full px-4 py-3 rounded-2xl text-sm outline-none"
                   style="background:var(--input-bg);border:1.5px solid rgba(249,115,22,0.4);color:var(--text-main);"
                   onfocus="this.style.borderColor='rgba(249,115,22,0.7)'"
                   onblur="this.style.borderColor='rgba(249,115,22,0.4)'">
        </div>
    </div>

    {{-- Tingkat --}}
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">Tingkat</label>
        <select name="tingkat"
                class="w-full px-4 py-3 rounded-2xl text-sm outline-none"
                style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);"
                onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                onblur="this.style.borderColor='var(--input-border)'">
            <option value="" style="background:var(--card-bg)">— (Tidak Ditentukan)</option>
            @foreach (['sekolah', 'kecamatan', 'kota', 'provinsi', 'nasional', 'internasional'] as $tkt)
                <option value="{{ $tkt }}" style="background:var(--card-bg)">{{ ucfirst($tkt) }}</option>
            @endforeach
        </select>
    </div>
</div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tahun</label>
                            <input type="number" name="tahun" required min="2000" max="{{ date('Y') }}"
                                value="{{ date('Y') }}"
                                class="w-full px-4 py-3 rounded-2xl text-sm outline-none" style="background:var(--input-bg);border:1.5px solid var(--input-border);color:var(--text-main);"
                                onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                                onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Upload Sertifikat / Bukti
                                (PDF/JPG/PNG)</label>
                            <label class="block rounded-2xl p-10 text-center cursor-pointer transition-all"
                                style="background: rgba(255,255,255,0.02); border: 2px dashed rgba(255,255,255,0.1);"
                                onmouseover="this.style.borderColor='rgba(249,115,22,0.4)'"
                                onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                                    style="background: rgba(255,255,255,0.05);">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                </div>
                                <p class="text-base font-medium text-gray-200">Klik untuk upload atau drag & drop</p>
                                <p class="text-sm text-gray-500 mt-2">Maksimal ukuran file 5MB</p>
                                <input type="file" name="file_bukti" required class="hidden"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    onchange="document.getElementById('namaFile').textContent = this.files[0]?.name ?? ''">
                            </label>
                            <p id="namaFile" class="text-sm text-orange-400 mt-2 text-center"></p>
                        </div>
                    </div>

                    <div class="p-6 flex justify-end gap-4"
                        style="border-top: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                        <button type="button" @click="modalOpen = false"
                            class="px-6 py-3 rounded-2xl text-sm font-medium text-gray-400 transition-all"
                            style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
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
@endsection
