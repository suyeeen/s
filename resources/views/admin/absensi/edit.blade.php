@extends('layouts.app')

@section('title', 'Edit Rekap Absensi')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.absensi.index') }}" class="text-sm font-semibold flex items-center gap-1"
                style="color:var(--text-muted);">
                ← Kembali ke Daftar Rekap
            </a>
        </div>

        <div class="rounded-2xl p-6" style="background:var(--card-bg); border:1px solid var(--card-border);">
            <h1 class="text-xl font-black mb-2" style="color:var(--text-main); font-family:'Outfit',sans-serif;">
                Edit Rekap Absensi
            </h1>
            <p class="text-sm mb-6" style="color:var(--text-muted);">
                {{ $absensi->guru->nama ?? '—' }} —
                {{ $namaBulan[$absensi->bulan] ?? $absensi->bulan }} {{ $absensi->tahun }}
            </p>

            @if($errors->any())
                <div class="mb-4 px-4 py-3 rounded-xl text-sm"
                    style="background:rgba(239,68,68,0.12); color:#ef4444; border:1px solid rgba(239,68,68,0.2);">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.absensi.update', $absensi->id) }}" class="space-y-5">
                @csrf @method('PUT')

                {{-- Total hari kerja --}}
                <div>
                    <label class="block text-sm font-bold mb-1" style="color:var(--text-main);">Total Hari Kerja <span
                            style="color:#ef4444;">*</span></label>
                    <input type="number" name="total_hari_kerja"
                        value="{{ old('total_hari_kerja', $absensi->total_hari_kerja) }}" min="1" max="31" required
                        id="totalHariKerja" class="w-full rounded-xl px-3 py-2 text-sm"
                        style="background:var(--card-bg-soft); border:1px solid var(--card-border); color:var(--text-main);">
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
                                <input type="number" name="{{ $f['name'] }}"
                                    value="{{ old($f['name'], $absensi->{$f['name']}) }}" min="0" required
                                    class="w-full rounded-xl px-3 py-2 text-sm font-bold kehadiran-input"
                                    style="background:var(--card-bg); border:1px solid {{ $f['color'] }}44; color:{{ $f['color'] }};">
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 p-3 rounded-xl text-center"
                        style="background:var(--card-bg); border:1px solid var(--card-border);">
                        <p class="text-xs mb-1" style="color:var(--text-muted);">Persentase Kehadiran</p>
                        <p class="text-2xl font-black" id="persenPreview"
                            style="color:#10b981; font-family:'Outfit',sans-serif;">
                            {{ $absensi->total_hari_kerja > 0 ? number_format($absensi->persen_hadir, 1) . '%' : '—' }}
                        </p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1" style="color:var(--text-main);">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full rounded-xl px-3 py-2 text-sm resize-none"
                        style="background:var(--card-bg-soft); border:1px solid var(--card-border); color:var(--text-main);">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2 rounded-xl font-bold text-sm text-white"
                        style="background:var(--accent);">
                        Simpan Perubahan
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
        document.querySelectorAll('.kehadiran-input, #totalHariKerja').forEach(el => el.addEventListener('input', hitungPersen));
    </script>
@endsection
