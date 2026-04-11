@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">

        {{-- Tombol kembali --}}
        <a href="{{ route('kepala.evaluasi') }}"
            class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors px-4 py-2 rounded-xl"
            style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Evaluasi
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ── Kolom Kiri ── --}}
            <div class="space-y-6 lg:col-span-1">

                {{-- Profil --}}
                <div class="rounded-3xl overflow-hidden"
                    style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                    <div class="h-24 w-full" style="background: linear-gradient(135deg, #f97316, #eab308);"></div>
                    <div class="px-6 pb-6 -mt-12 text-center">
                        <div class="w-24 h-24 mx-auto rounded-full flex items-center justify-center text-3xl font-bold mb-4"
                            style="background: #0a0a14; border: 4px solid rgba(255,255,255,0.1); color: #fbbf24;">
                            {{ strtoupper(substr($guru->nama, 0, 1)) }}
                        </div>
                        <h2 class="text-xl font-bold text-white">{{ $guru->nama }}</h2>
                        <p class="text-orange-400 text-sm mt-1">{{ $guru->mata_pelajaran }}</p>

                        <div class="mt-6 space-y-3 text-sm text-left"
                            style="border-top: 1px solid rgba(255,255,255,0.06); padding-top: 1.5rem;">
                            <div class="flex items-center gap-3 text-gray-300">
                                <div class="p-2 rounded-lg" style="background: rgba(255,255,255,0.05);">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <span>NIP: {{ $guru->nip }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-gray-300">
                                <div class="p-2 rounded-lg" style="background: rgba(255,255,255,0.05);">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span>{{ $guru->user->email }}</span>
                            </div>
                            @if ($guru->rfid_uid)
                                <div class="flex items-center gap-3 text-gray-300">
                                    <div class="p-2 rounded-lg" style="background: rgba(255,255,255,0.05);">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                                        </svg>
                                    </div>
                                    <span>RFID: {{ $guru->rfid_uid }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Hasil Cluster --}}
                @if ($guru->clusterTerakhir)
                    @php
                        $clusterInfo = match ($guru->clusterTerakhir->cluster) {
                            'A' => [
                                'bg' => 'rgba(16,185,129,0.1)',
                                'border' => '1px solid rgba(16,185,129,0.2)',
                                'color' => '#34d399',
                                'shadow' => '0 8px 32px rgba(16,185,129,0.1)',
                            ],
                            'B' => [
                                'bg' => 'rgba(59,130,246,0.1)',
                                'border' => '1px solid rgba(59,130,246,0.2)',
                                'color' => '#60a5fa',
                                'shadow' => '0 8px 32px rgba(59,130,246,0.1)',
                            ],
                            'C' => [
                                'bg' => 'rgba(245,158,11,0.1)',
                                'border' => '1px solid rgba(245,158,11,0.2)',
                                'color' => '#fbbf24',
                                'shadow' => '0 8px 32px rgba(245,158,11,0.1)',
                            ],
                            default => [
                                'bg' => 'rgba(239,68,68,0.1)',
                                'border' => '1px solid rgba(239,68,68,0.2)',
                                'color' => '#f87171',
                                'shadow' => '0 8px 32px rgba(239,68,68,0.1)',
                            ],
                        };
                    @endphp
                    <div class="rounded-3xl p-8"
                        style="background: {{ $clusterInfo['bg'] }}; border: {{ $clusterInfo['border'] }}; box-shadow: {{ $clusterInfo['shadow'] }};">
                        <h3 class="font-semibold text-white mb-3">Hasil Pemetaan (Cluster)</h3>
                        <div class="flex items-end gap-4 mb-4">
                            <span class="text-6xl font-black leading-none" style="color: {{ $clusterInfo['color'] }};">
                                {{ $guru->clusterTerakhir->cluster }}
                            </span>
                            <span class="text-xl font-bold mb-1" style="color: {{ $clusterInfo['color'] }};">
                                {{ $guru->clusterTerakhir->label_cluster }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-300 leading-relaxed">
                            @switch($guru->clusterTerakhir->cluster)
                                @case('A')
                                    Guru menunjukkan performa luar biasa. Layak dipertimbangkan sebagai guru penggerak atau mentor.
                                @break

                                @case('B')
                                    Guru menunjukkan performa baik. Perlu mempertahankan dan meningkatkan beberapa aspek spesifik.
                                @break

                                @case('C')
                                    Guru memerlukan peningkatan signifikan di beberapa area kompetensi dasar.
                                @break

                                @default
                                    Guru memerlukan program pembinaan intensif dan pendampingan khusus segera.
                            @endswitch
                        </p>
                    </div>
                @endif

                {{-- Quick Stats --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-3xl p-6 text-center"
                        style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                        <div class="w-12 h-12 mx-auto rounded-2xl flex items-center justify-center mb-4"
                            style="background: rgba(139,92,246,0.1); border: 1px solid rgba(139,92,246,0.2);">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-white mb-1">{{ $persenHadir }}%</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Kehadiran</p>
                    </div>
                    <div class="rounded-3xl p-6 text-center"
                        style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                        <div class="w-12 h-12 mx-auto rounded-2xl flex items-center justify-center mb-4"
                            style="background: rgba(249,115,22,0.1); border: 1px solid rgba(249,115,22,0.2);">
                            <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-white mb-1">
                            {{ $guru->prestasi->where('status', 'tervalidasi')->count() }}
                        </p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Prestasi</p>
                    </div>
                </div>
            </div>

            {{-- ── Kolom Kanan ── --}}
            <div class="space-y-8 lg:col-span-2">

                {{-- Profil Kompetensi --}}
                @if ($guru->clusterTerakhir)
                    <div class="rounded-3xl p-8"
                        style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="font-semibold text-white text-xl">Profil Kompetensi</h3>
                            <div class="px-4 py-2 rounded-xl font-bold text-lg"
                                style="background: rgba(249,115,22,0.15); color: #f97316; border: 1px solid rgba(249,115,22,0.3);">
                                Skor: {{ $guru->clusterTerakhir->nilai_rata_rata }}
                            </div>
                        </div>

                        <div class="space-y-5">
                            @foreach ([['label' => 'Pedagogik', 'value' => $guru->clusterTerakhir->nilai_pedagogik], ['label' => 'Kepribadian', 'value' => $guru->clusterTerakhir->nilai_kepribadian], ['label' => 'Sosial', 'value' => $guru->clusterTerakhir->nilai_sosial], ['label' => 'Profesional', 'value' => $guru->clusterTerakhir->nilai_profesional]] as $komp)
                                @php
                                    $pct = ($komp['value'] / 5) * 100;
                                    $color =
                                        $komp['value'] >= 4
                                            ? '#10b981'
                                            : ($komp['value'] >= 3
                                                ? '#3b82f6'
                                                : ($komp['value'] >= 2
                                                    ? '#f59e0b'
                                                    : '#ef4444'));
                                @endphp
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="font-medium text-gray-300">{{ $komp['label'] }}</span>
                                        <span class="font-bold text-white">
                                            {{ $komp['value'] }} <span class="text-gray-500 font-normal">/ 5.0</span>
                                        </span>
                                    </div>
                                    <div class="w-full rounded-full h-2.5" style="background: rgba(255,255,255,0.05);">
                                        <div class="h-full rounded-full transition-all"
                                            style="width: {{ $pct }}%; background: {{ $color }};"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Riwayat Prestasi --}}
                <div class="rounded-3xl overflow-hidden"
                    style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                    <div class="p-6"
                        style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                        <h3 class="font-semibold text-white text-lg">Riwayat Prestasi & Sertifikasi</h3>
                    </div>
                    @forelse($guru->prestasi->where('status', 'tervalidasi') as $p)
                        <div class="p-5 flex items-center justify-between transition-colors"
                            style="border-bottom: 1px solid rgba(255,255,255,0.04);"
                            onmouseover="this.style.background='rgba(255,255,255,0.03)'"
                            onmouseout="this.style.background='transparent'">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"
                                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);">
                                    <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-white">{{ $p->nama_prestasi }}</p>
                                    <p class="text-sm text-gray-400 mt-1">
                                        {{ $p->kategori }} • {{ ucfirst($p->tingkat) }} • {{ $p->tahun }}
                                    </p>
                                </div>
                            </div>
                            <span class="px-3 py-1.5 rounded-xl text-xs font-bold"
                                style="background: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.2);">
                                Tervalidasi
                            </span>
                        </div>
                    @empty
                        <div class="p-10 text-center text-gray-500">Belum ada prestasi tervalidasi.</div>
                    @endforelse
                </div>

                {{-- Rekomendasi --}}
                <div class="rounded-3xl p-8 relative overflow-hidden"
                    style="background: rgba(245,158,11,0.05); border: 1px solid rgba(245,158,11,0.15);">
                    <div class="absolute top-0 left-0 w-full h-1 rounded-t-3xl"
                        style="background: linear-gradient(90deg, #f97316, #eab308);"></div>
                    <h3 class="font-semibold text-white mb-5 flex items-center gap-3 text-lg">
                        <div class="p-2 rounded-xl" style="background: rgba(245,158,11,0.15);">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        Rekomendasi Tindak Lanjut
                    </h3>
                    <ul class="space-y-3 text-sm text-gray-300">
                        @if ($guru->clusterTerakhir)
                            @switch($guru->clusterTerakhir->cluster)
                                @case('A')
                                    <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span> Pertahankan
                                        kinerja sangat baik.</li>
                                    <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span>
                                        Direkomendasikan menjadi mentor bagi guru di Cluster C dan D.</li>
                                    <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span> Usulkan
                                        mengikuti seleksi Guru Penggerak angkatan berikutnya.</li>
                                @break

                                @case('B')
                                    <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span> Tingkatkan
                                        kompetensi di area yang skornya masih di bawah 4.0.</li>
                                    <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span> Ikuti
                                        pelatihan spesifik terkait inovasi pembelajaran.</li>
                                @break

                                @case('C')
                                    <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span> Wajib
                                        mengikuti program pendampingan selama 1 semester.</li>
                                    <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span> Fokus
                                        perbaikan pada kompetensi Pedagogik dan Profesional.</li>
                                    <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span> Evaluasi
                                        ulang akan dilakukan dalam 3 bulan.</li>
                                @break

                                @default
                                    <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span> Wajib
                                        mengikuti program pembinaan intensif dari Kepala Sekolah.</li>
                                    <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span> Peninjauan
                                        ulang beban mengajar sementara waktu.</li>
                                    <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span> Pemantauan
                                        kehadiran dan disiplin secara ketat.</li>
                            @endswitch
                        @else
                            <li class="flex gap-3"><span class="text-orange-500 font-bold shrink-0">•</span> Guru belum
                                memiliki data clustering. Jalankan K-Means terlebih dahulu.</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
