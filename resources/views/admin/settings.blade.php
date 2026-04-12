@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Pengaturan Sistem</h1>
                <p class="text-gray-400 mt-2">Konfigurasi parameter dan operasional aplikasi STQM.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.settings.save') }}">
            @csrf
            <div class="space-y-8">

                {{-- Periode Akademik --}}
                <div class="rounded-3xl overflow-hidden"
                    style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                    <div class="p-6 flex items-center gap-4"
                        style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                        <div class="p-2.5 rounded-xl"
                            style="background: rgba(249,115,22,0.1); border: 1px solid rgba(249,115,22,0.2);">
                            <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-white text-lg">Periode Akademik & Evaluasi</h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tahun Ajaran Aktif</label>
                            <select name="tahun_ajaran" class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                                @foreach (['2024/2025', '2025/2026', '2023/2024'] as $ta)
                                    <option value="{{ $ta }}" style="background: #0a0a14;"
                                        {{ ($settings['tahun_ajaran'] ?? '2024/2025') === $ta ? 'selected' : '' }}>
                                        {{ $ta }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Semester Aktif</label>
                            <select name="semester" class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                                <option value="ganjil" style="background: #0a0a14;"
                                    {{ ($settings['semester'] ?? 'ganjil') === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="genap" style="background: #0a0a14;"
                                    {{ ($settings['semester'] ?? 'ganjil') === 'genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Buka Akses Kuesioner</label>
                            <input type="date" name="buka_kuesioner" value="{{ $settings['buka_kuesioner'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tutup Akses Kuesioner</label>
                            <input type="date" name="tutup_kuesioner" value="{{ $settings['tutup_kuesioner'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-2xl text-white text-sm outline-none"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                        </div>
                    </div>
                </div>

                {{-- Integrasi RFID --}}
                <div class="rounded-3xl overflow-hidden"
                    style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                    <div class="p-6 flex items-center gap-4"
                        style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                        <div class="p-2.5 rounded-xl"
                            style="background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2);">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-white text-lg">Integrasi Hardware RFID</h3>
                    </div>
                    <div class="p-8" x-data="{ rfid: {{ $settings['rfid_aktif'] ?? false ? 'true' : 'false' }} }">
                        <div class="flex items-center justify-between p-6 rounded-2xl"
                            style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06);">
                            <div>
                                <h4 class="font-semibold text-white">Modul Absensi RFID</h4>
                                <p class="text-sm text-gray-400 mt-1">Status koneksi ke perangkat pembaca kartu RFID.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="rfid_aktif" x-model="rfid" class="sr-only">
                                <div class="w-14 h-7 rounded-full transition-all relative"
                                    :style="rfid ? 'background: #f97316;' : 'background: rgba(255,255,255,0.1);'">
                                    <div class="absolute top-0.5 left-0.5 w-6 h-6 rounded-full bg-white transition-all"
                                        :style="rfid ? 'transform: translateX(28px);' : 'transform: translateX(0);'"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="flex items-center gap-2 px-8 py-3.5 rounded-2xl font-semibold text-white transition-all"
                        style="background: linear-gradient(135deg, #f97316, #eab308); box-shadow: 0 8px 32px rgba(249,115,22,0.3);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
