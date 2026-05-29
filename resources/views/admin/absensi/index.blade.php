@extends('layouts.app')
@section('title', 'Rekap Absensi Guru')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-2xl font-black" style="color:var(--text-main); font-family:'Outfit',sans-serif;">
                    Rekap Absensi Guru</h1>
                <p class="text-sm mt-1" style="color:var(--text-muted);">Input dan kelola rekap absensi bulanan guru</p>
            </div>
            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('admin.absensi.template') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-bold text-sm"
                    style="background:var(--card-bg-soft); border:1px solid var(--card-border); color:var(--text-muted);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Template Excel
                </a>
                <button onclick="document.getElementById('modalImport').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-bold text-sm"
                    style="background:rgba(16,185,129,0.12); border:1px solid rgba(16,185,129,0.25); color:#10b981;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                    </svg>
                    Import Excel
                </button>
                <a href="{{ route('admin.absensi.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-bold text-sm text-white"
                    style="background:var(--accent);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Manual
                </a>
            </div>
        </div>

        {{-- Alert sukses/error --}}
        @if(session('success'))
            <div class="px-4 py-3 rounded-xl text-sm font-semibold"
                style="background:rgba(16,185,129,0.12); color:#10b981; border:1px solid rgba(16,185,129,0.2);">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="px-4 py-3 rounded-xl text-sm font-semibold"
                style="background:rgba(239,68,68,0.12); color:#ef4444; border:1px solid rgba(239,68,68,0.2);">
                {{ session('error') }}
            </div>
        @endif

        {{-- ── MODAL IMPORT ───────────────────────────────────────────────── --}}
        <div id="modalImport" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background:rgba(0,0,0,0.5); backdrop-filter:blur(4px);">
            <div class="w-full max-w-lg rounded-2xl p-6 space-y-4"
                style="background:var(--card-bg); border:1px solid var(--card-border);">
                <div class="flex items-center justify-between">
                    <h2 class="font-black text-lg" style="color:var(--text-main); font-family:'Outfit',sans-serif;">
                        Import Excel Rekap Absensi</h2>
                    <button onclick="document.getElementById('modalImport').classList.add('hidden')"
                        class="w-8 h-8 rounded-lg flex items-center justify-center"
                        style="color:var(--text-muted); background:var(--card-bg-soft);">✕</button>
                </div>

                <div class="rounded-xl px-4 py-3 text-xs leading-relaxed"
                    style="background:rgba(59,130,246,0.08); border:1px solid rgba(59,130,246,0.2); color:#3b82f6;">
                    <strong>Panduan:</strong> Download template Excel dulu, isi data sesuai format, lalu upload di sini.
                    Sistem akan menampilkan <strong>preview</strong> sebelum data benar-benar disimpan.
                </div>

                <form method="POST" action="{{ route('admin.absensi.import.preview') }}" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold mb-2" style="color:var(--text-main);">Pilih File Excel</label>
                        <input type="file" name="file_import" accept=".xlsx,.xls" required
                            class="w-full rounded-xl px-3 py-2 text-sm"
                            style="background:var(--card-bg-soft); border:1px solid var(--card-border); color:var(--text-main);">
                        <p class="text-xs mt-1" style="color:var(--text-muted);">Format: .xlsx atau .xls, maks 5MB</p>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 py-2 rounded-xl font-bold text-sm text-white"
                            style="background:#10b981;">
                            Validasi & Preview
                        </button>
                        <button type="button" onclick="document.getElementById('modalImport').classList.add('hidden')"
                            class="px-4 py-2 rounded-xl font-semibold text-sm"
                            style="background:var(--card-bg-soft); color:var(--text-muted); border:1px solid var(--card-border);">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── PREVIEW IMPORT (setelah validasi) ─────────────────────────── --}}
        @if(session('import_preview') || session('import_log_gagal'))
            @php
                $preview = session('import_preview', []);
                $logGagal = session('import_log_gagal', []);
                $path = session('import_path', '');
            @endphp

            <div class="rounded-2xl p-5 space-y-4" style="background:var(--card-bg); border:1px solid rgba(16,185,129,0.3);">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                        style="background:rgba(16,185,129,0.15);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="#10b981" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-black text-base" style="color:var(--text-main);">Preview Import</h3>
                        <p class="text-xs" style="color:var(--text-muted);">
                            {{ count($preview) }} baris valid, {{ count($logGagal) }} baris gagal validasi
                        </p>
                    </div>
                </div>

                {{-- Tabel preview --}}
                @if(count($preview) > 0)
                    <div class="overflow-x-auto rounded-xl" style="border:1px solid var(--card-border-soft);">
                        <table class="w-full text-xs">
                            <thead>
                                <tr style="background:var(--card-bg-soft); border-bottom:1px solid var(--card-border-soft);">
                                    <th class="text-left px-3 py-2 font-bold" style="color:var(--text-muted);">#</th>
                                    <th class="text-left px-3 py-2 font-bold" style="color:var(--text-muted);">Guru</th>
                                    <th class="text-left px-3 py-2 font-bold" style="color:var(--text-muted);">NIP</th>
                                    <th class="text-center px-3 py-2 font-bold" style="color:var(--text-muted);">Periode</th>
                                    <th class="text-center px-3 py-2 font-bold" style="color:#10b981;">Hadir</th>
                                    <th class="text-center px-3 py-2 font-bold" style="color:#f59e0b;">Izin</th>
                                    <th class="text-center px-3 py-2 font-bold" style="color:#3b82f6;">Sakit</th>
                                    <th class="text-center px-3 py-2 font-bold" style="color:#ef4444;">Alpha</th>
                                    <th class="text-center px-3 py-2 font-bold" style="color:#a855f7;">Terlambat</th>
                                    <th class="text-center px-3 py-2 font-bold" style="color:var(--text-muted);">% Hadir</th>
                                    <th class="text-center px-3 py-2 font-bold" style="color:var(--text-muted);">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($preview as $p)
                                    @php $isUpdate = $p['status'] === 'update'; @endphp
                                    <tr style="border-bottom:1px solid var(--card-border-soft);">
                                        <td class="px-3 py-2" style="color:var(--text-muted);">{{ $p['baris'] }}</td>
                                        <td class="px-3 py-2 font-semibold" style="color:var(--text-main);">{{ $p['guru'] }}</td>
                                        <td class="px-3 py-2" style="color:var(--text-muted);">{{ $p['nip'] }}</td>
                                        <td class="px-3 py-2 text-center" style="color:var(--text-main);">{{ $p['periode'] }}</td>
                                        <td class="px-3 py-2 text-center font-bold" style="color:#10b981;">{{ $p['hadir'] }}</td>
                                        <td class="px-3 py-2 text-center font-bold" style="color:#f59e0b;">{{ $p['izin'] }}</td>
                                        <td class="px-3 py-2 text-center font-bold" style="color:#3b82f6;">{{ $p['sakit'] }}</td>
                                        <td class="px-3 py-2 text-center font-bold" style="color:#ef4444;">{{ $p['alpha'] }}</td>
                                        <td class="px-3 py-2 text-center font-bold" style="color:#a855f7;">{{ $p['terlambat'] }}</td>
                                        <td class="px-3 py-2 text-center">
                                            @php $pct = $p['persen'];
                                            $pc = $pct >= 90 ? '#10b981' : ($pct >= 75 ? '#f59e0b' : '#ef4444'); @endphp
                                            <span style="color:{{ $pc }}; font-weight:700;">{{ $pct }}%</span>
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <span class="px-2 py-0.5 rounded-md text-xs font-bold"
                                                style="{{ $isUpdate ? 'background:rgba(245,158,11,0.15); color:#f59e0b;' : 'background:rgba(16,185,129,0.15); color:#10b981;' }}">
                                                {{ $isUpdate ? 'Update' : 'Baru' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Tombol konfirmasi simpan --}}
                    <form method="POST" action="{{ route('admin.absensi.import.confirm') }}">
                        @csrf
                        <input type="hidden" name="import_path" value="{{ $path }}">
                        <button type="submit" class="w-full py-3 rounded-xl font-black text-sm text-white"
                            style="background:#10b981;"
                            onclick="return confirm('Simpan {{ count($preview) }} rekap absensi ke database?')">
                            ✓ Konfirmasi & Simpan {{ count($preview) }} Rekap
                        </button>
                    </form>
                @endif

                {{-- Log gagal --}}
                @if(count($logGagal) > 0)
                    <div class="rounded-xl p-4" style="background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.2);">
                        <p class="text-xs font-bold mb-2" style="color:#ef4444;">{{ count($logGagal) }} Baris Gagal Validasi:</p>
                        <div class="space-y-1 max-h-40 overflow-y-auto">
                            @foreach($logGagal as $log)
                                <p class="text-xs" style="color:#ef4444;">
                                    Baris {{ $log['baris'] }} — {{ $log['nama'] }}
                                    (NIP: {{ $log['nip'] ?? '-' }}): {{ $log['alasan'] }}
                                </p>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Ringkasan persentase per guru --}}
        <div class="rounded-2xl p-5" style="background:var(--card-bg); border:1px solid var(--card-border);">
            <h2 class="font-bold text-sm mb-4" style="color:var(--text-main);">Ringkasan Kehadiran Semua Guru</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($guruList as $g)
                    @php $pct = $g['persen_hadir'];
                    $color = $pct >= 90 ? '#10b981' : ($pct >= 75 ? '#f59e0b' : '#ef4444'); @endphp
                    <div class="rounded-xl p-3 text-center"
                        style="background:var(--card-bg-soft); border:1px solid var(--card-border-soft);">
                        <p class="text-xs truncate mb-1" style="color:var(--text-muted);">{{ $g['nama'] }}</p>
                        <p class="text-xl font-black" style="color:{{ $color }}; font-family:'Outfit',sans-serif;">
                            {{ $pct > 0 ? number_format($pct, 1) . '%' : '—' }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Filter --}}
        <form method="GET" class="flex flex-col sm:flex-row flex-wrap gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama / NIP..."
                class="rounded-xl px-3 py-2 text-sm"
                style="background:var(--card-bg); border:1px solid var(--card-border); color:var(--text-main); min-width:0; flex:1;">
            <select name="bulan" class="rounded-xl px-3 py-2 text-sm"
                style="background:var(--card-bg); border:1px solid var(--card-border); color:var(--text-main);">
                <option value="">Semua Bulan</option>
                @foreach($namaBulan as $no => $nm)
                    <option value="{{ $no }}" @selected($bulanFilter == $no)>{{ $nm }}</option>
                @endforeach
            </select>
            <input type="number" name="tahun" value="{{ $tahunFilter }}" placeholder="Tahun"
                class="rounded-xl px-3 py-2 text-sm w-24"
                style="background:var(--card-bg); border:1px solid var(--card-border); color:var(--text-main);">
            <button type="submit" class="px-4 py-2 rounded-xl text-sm font-bold text-white"
                style="background:var(--accent);">Filter</button>
            <a href="{{ route('admin.absensi.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold"
                style="background:var(--card-bg-soft); color:var(--text-muted); border:1px solid var(--card-border);">Reset</a>
        </form>

        {{-- Tabel rekap --}}
        <div class="rounded-2xl overflow-hidden" style="background:var(--card-bg); border:1px solid var(--card-border);">
            <div class="table-responsive">
                <table class="w-full text-sm" style="min-width:640px;">
                    <thead>
                        <tr style="border-bottom:1px solid var(--card-border-soft);">
                            <th class="text-left px-4 py-3 font-bold text-xs uppercase tracking-wider"
                                style="color:var(--text-muted);">Guru</th>
                            <th class="text-center px-4 py-3 font-bold text-xs uppercase tracking-wider"
                                style="color:var(--text-muted);">Periode</th>
                            <th class="text-center px-4 py-3 font-bold text-xs uppercase tracking-wider"
                                style="color:#10b981;">Hadir</th>
                            <th class="text-center px-4 py-3 font-bold text-xs uppercase tracking-wider"
                                style="color:#f59e0b;">Izin</th>
                            <th class="text-center px-4 py-3 font-bold text-xs uppercase tracking-wider"
                                style="color:#3b82f6;">Sakit</th>
                            <th class="text-center px-4 py-3 font-bold text-xs uppercase tracking-wider"
                                style="color:#ef4444;">Alpha</th>
                            <th class="text-center px-4 py-3 font-bold text-xs uppercase tracking-wider"
                                style="color:#a855f7;">Terlambat</th>
                            <th class="text-center px-4 py-3 font-bold text-xs uppercase tracking-wider"
                                style="color:var(--text-muted);">% Hadir</th>
                            <th class="text-center px-4 py-3 font-bold text-xs uppercase tracking-wider"
                                style="color:var(--text-muted);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($query as $rekap)
                            @php $pct = $rekap->persen_hadir;
                            $color = $pct >= 90 ? '#10b981' : ($pct >= 75 ? '#f59e0b' : '#ef4444'); @endphp
                            <tr style="border-bottom:1px solid var(--card-border-soft);">
                                <td class="px-4 py-3 font-semibold" style="color:var(--text-main);">
                                    {{ $rekap->guru->nama ?? '—' }}
                                    <p class="text-xs font-normal" style="color:var(--text-muted);">
                                        {{ $rekap->guru->nip ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3 text-center" style="color:var(--text-main);">
                                    {{ $namaBulan[$rekap->bulan] ?? $rekap->bulan }} {{ $rekap->tahun }}
                                </td>
                                <td class="px-4 py-3 text-center font-bold" style="color:#10b981;">{{ $rekap->jumlah_hadir }}
                                </td>
                                <td class="px-4 py-3 text-center font-bold" style="color:#f59e0b;">{{ $rekap->jumlah_izin }}
                                </td>
                                <td class="px-4 py-3 text-center font-bold" style="color:#3b82f6;">{{ $rekap->jumlah_sakit }}
                                </td>
                                <td class="px-4 py-3 text-center font-bold" style="color:#ef4444;">{{ $rekap->jumlah_alpha }}
                                </td>
                                <td class="px-4 py-3 text-center font-bold" style="color:#a855f7;">
                                    {{ $rekap->jumlah_terlambat }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded-lg text-xs font-black"
                                        style="background:{{ $color }}22; color:{{ $color }};">
                                        {{ $rekap->total_hari_kerja > 0 ? number_format($pct, 1) . '%' : '—' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.absensi.edit', $rekap->id) }}"
                                            class="px-3 py-1 rounded-lg text-xs font-bold"
                                            style="background:rgba(59,130,246,0.12); color:#3b82f6;">Edit</a>
                                        <form method="POST" action="{{ route('admin.absensi.destroy', $rekap->id) }}"
                                            onsubmit="return confirm('Hapus rekap ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-3 py-1 rounded-lg text-xs font-bold"
                                                style="background:rgba(239,68,68,0.12); color:#ef4444;">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-10 text-center text-sm" style="color:var(--text-muted);">
                                    Belum ada rekap absensi.
                                    <a href="{{ route('admin.absensi.create') }}" style="color:var(--accent);">Tambah manual</a>
                                    atau <button onclick="document.getElementById('modalImport').classList.remove('hidden')"
                                        style="color:#10b981; font-weight:600;">Import Excel</button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $query->links() }}
    </div>
@endsection
