@extends('layouts.app')

@section('title', 'Tambah Rekap Absensi')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.absensi.index') }}" class="text-sm font-semibold flex items-center gap-1"
                style="color:var(--text-muted);">
                ← Kembali ke Daftar Rekap
            </a>
        </div>

        <div class="rounded-2xl p-6" style="background:var(--card-bg); border:1px solid var(--card-border);">
            <h1 class="text-xl font-black mb-6" style="color:var(--text-main); font-family:'Outfit',sans-serif;">
                Tambah Rekap Absensi Bulanan
            </h1>

            @if($errors->any())
                <div class="mb-4 px-4 py-3 rounded-xl text-sm"
                    style="background:rgba(239,68,68,0.12); color:#ef4444; border:1px solid rgba(239,68,68,0.2);">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 px-4 py-3 rounded-xl text-sm font-semibold"
                    style="background:rgba(239,68,68,0.12); color:#ef4444; border:1px solid rgba(239,68,68,0.2);">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.absensi.store') }}" class="space-y-5">
                @csrf

                {{-- Guru --}}
                <div>
                    <label class="block text-sm font-bold mb-1" style="color:var(--text-main);">Guru <span
                            style="color:#ef4444;">*</span></label>
                    <select name="guru_id" required class="w-full rounded-xl px-3 py-2 text-sm"
                        style="background:var(--card-bg-soft); border:1px solid var(--card-border); color:var(--text-main);">
                        <option value="">— Pilih Guru —</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->id }}" @selected(old('guru_id') == $g->id)>
                                {{ $g->nama }} ({{ $g->nip }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Bulan & Tahun --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1" style="color:var(--text-main);">Bulan <span
                                style="color:#ef4444;">*</span></label>
                        <select name="bulan" required class="w-full rounded-xl px-3 py-2 text-sm"
                            style="background:var(--card-bg-soft); border:1px solid var(--card-border); color:var(--text-main);">
                            @foreach($namaBulan as $no => $nm)
                                <option value="{{ $no }}" @selected(old('bulan', date('n')) == $no)>{{ $nm }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1" style="color:var(--text-main);">Tahun <span
                                style="color:#ef4444;">*</span></label>
                        <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" min="2000"
                            max="{{ date('Y') }}" required class="w-full rounded-xl px-3 py-2 text-sm"
                            style="background:var(--card-bg-soft); border:1px solid var(--card-border); color:var(--text-main);">
                    </div>
                </div>

                {{-- Total hari kerja --}}
                <div>
                    <label class="block text-sm font-bold mb-1" style="color:var(--text-main);">Total Hari Kerja <span
                            style="color:#ef4444;">*</span></label>
                    <input type="number" name="total_hari_kerja" value="{{ old('total_hari_kerja') }}" min="1" max="31"
                        required id="totalHariKerja" class="w-full rounded-xl px-3 py-2 text-sm"
                        style="background:var(--card-bg-soft); border:1px solid var(--card-border); color:var(--text-main);"
                        placeholder="Misal: 22">
                    <p class="text-xs mt-1" style="color:var(--text-muted);">Jumlah hari kerja efektif dalam bulan ini</p>
                </div>

                {{-- Data kehadiran --}}
                <div class="rounded-xl p-4 space-y-3"
                    style="background:var(--card-bg-soft); border:1px solid var(--card-border-soft);">
                    <p class="text-sm font-bold" style="color:var(--text-main);">Rincian Kehadiran</p>

                    @php
                        $fields = [
                            ['name' => 'jumlah_hadir', 'label' => 'Hadir', 'color' => '#10b981'],
                            ['name' => 'jumlah_izin', 'label' => 'Izin', 'color' => '#f59e0b'],
                            ['name' => 'jumlah_sakit', 'label' => 'Sakit', 'color' => '#3b82f6'],
                            ['name' => 'jumlah_alpha', 'label' => 'Alpha', 'color' => '#ef4444'],
                            ['name' => 'jumlah_terlambat', 'label' => 'Terlambat', 'color' => '#a855f7'],
                        ];
                    @endphp

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($fields as $f)
                            <div>
                                <label class="block text-xs font-semibold mb-1"
                                    style="color:{{ $f['color'] }};">{{ $f['label'] }}</label>
                                <input type="number" name="{{ $f['name'] }}" value="{{ old($f['name'], 0) }}" min="0" required
                                    class="w-full rounded-xl px-3 py-2 text-sm font-bold kehadiran-input"
                                    style="background:var(--card-bg); border:1px solid {{ $f['color'] }}44; color:{{ $f['color'] }};">
                            </div>
                        @endforeach
                    </div>

                    {{-- Preview persentase --}}
                    <div class="mt-3 p-3 rounded-xl text-center"
                        style="background:var(--card-bg); border:1px solid var(--card-border);">
                        <p class="text-xs mb-1" style="color:var(--text-muted);">Estimasi Persentase Kehadiran</p>
                        <p class="text-2xl font-black" id="persenPreview"
                            style="color:#10b981; font-family:'Outfit',sans-serif;">—</p>
                    </div>
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-bold mb-1" style="color:var(--text-main);">Keterangan</label>
                    <textarea name="keterangan" rows="2" placeholder="Catatan tambahan (opsional)..."
                        class="w-full rounded-xl px-3 py-2 text-sm resize-none"
                        style="background:var(--card-bg-soft); border:1px solid var(--card-border); color:var(--text-main);">{{ old('keterangan') }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2 rounded-xl font-bold text-sm text-white"
                        style="background:var(--accent);">
                        Simpan Rekap
                    </button>
                    <a href="{{ route('admin.absensi.index') }}" class="px-6 py-2 rounded-xl font-semibold text-sm"
                        style="background:var(--card-bg-soft); color:var(--text-muted); border:1px solid var(--card-border);">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function hitungPersen() {
            const hadir = parseInt(document.querySelector('[name=jumlah_hadir]')?.value || 0);
            const terlambat = parseInt(document.querySelector('[name=jumlah_terlambat]')?.value || 0);
            const total = parseInt(document.querySelector('#totalHariKerja')?.value || 0);
            const el = document.querySelector('#persenPreview');
            if (total > 0) {
                const pct = ((hadir + terlambat) / total * 100).toFixed(1);
                el.textContent = pct + '%';
                el.style.color = pct >= 90 ? '#10b981' : pct >= 75 ? '#f59e0b' : '#ef4444';
            } else {
                el.textContent = '—';
            }
        }

        document.querySelectorAll('.kehadiran-input, #totalHariKerja').forEach(el => {
            el.addEventListener('input', hitungPersen);
        });
    </script>
@endsection
