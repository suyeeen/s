<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Pertanyaan;
use App\Models\Kuesioner;
use App\Models\Jawaban;
use App\Models\Absensi;

class GuruController extends Controller
{
    public function kuesioner()
    {
        $guru       = Guru::where('id', '!=', auth()->user()->guru->id)->get();
        $pertanyaan = Pertanyaan::whereIn('untuk_penilai', ['guru', 'keduanya'])
            ->orderBy('urutan')->get()->groupBy('kategori');

        $penilai     = auth()->user()->guru;
        $tahunAjaran = \Illuminate\Support\Facades\Cache::get('stqm_tahun_ajaran', '2024/2025');
        $semester    = \Illuminate\Support\Facades\Cache::get('stqm_semester', 'ganjil');
        $maksimal    = (int) \Illuminate\Support\Facades\Cache::get('stqm_maks_penilaian', 1);

        // Guru yang sudah mencapai batas penilaian — kembalikan flat array of guru_id
        // agar view bisa pakai in_array() dengan benar
        $sudahDinilai = Kuesioner::where('penilai_guru_id', $penilai->id)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->where('tipe', 'guru')
            ->selectRaw('guru_id, COUNT(*) as jumlah')
            ->groupBy('guru_id')
            ->havingRaw('COUNT(*) >= ?', [$maksimal])
            ->pluck('guru_id')
            ->toArray();

        return view('guru.kuesioner', compact('guru', 'pertanyaan', 'sudahDinilai', 'maksimal'));
    }

    public function submitKuesioner(Request $request)
    {
        // Mendukung multi-guru (guru_ids[]) maupun single guru (guru_id)
        $guruIds = $request->input('guru_ids', []);
        if (empty($guruIds) && $request->filled('guru_id')) {
            $guruIds = [$request->input('guru_id')];
        }

        $request->merge(['guru_ids_resolved' => $guruIds]);

        $request->validate([
            'guru_ids_resolved'   => 'required|array|min:1',
            'guru_ids_resolved.*' => 'required|exists:guru,id',
            'jawaban'             => 'required|array',
        ]);

        // Cek batas waktu kuesioner
        $buka  = \Illuminate\Support\Facades\Cache::get('stqm_buka_kuesioner', '');
        $tutup = \Illuminate\Support\Facades\Cache::get('stqm_tutup_kuesioner', '');
        $now   = now()->toDateString();

        if ($buka && $now < $buka) {
            return back()->with('error', 'Kuesioner belum dibuka. Jadwal dibuka: ' . $buka);
        }
        if ($tutup && $now > $tutup) {
            return back()->with('error', 'Batas waktu pengisian kuesioner sudah berakhir (' . $tutup . ').');
        }

        $penilai     = auth()->user()->guru;
        $tahunAjaran = \Illuminate\Support\Facades\Cache::get('stqm_tahun_ajaran', '2024/2025');
        $semester    = \Illuminate\Support\Facades\Cache::get('stqm_semester', 'ganjil');
        $maksimal    = (int) \Illuminate\Support\Facades\Cache::get('stqm_maks_penilaian', 1);

        $berhasil = 0;
        $errors   = [];

        foreach ($guruIds as $guruId) {
            $jumlahIsi = Kuesioner::where('penilai_guru_id', $penilai->id)
                ->where('guru_id', $guruId)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('semester', $semester)
                ->where('tipe', 'guru')
                ->count();

            if ($jumlahIsi >= $maksimal) {
                $guruModel = Guru::find($guruId);
                $errors[] = 'Guru ' . ($guruModel->nama ?? $guruId) . ' sudah pernah dinilai (batas ' . $maksimal . 'x per periode).';
                continue;
            }

            $jawabanGuru = $request->input('jawaban.' . $guruId, []);
            $kesanPesan  = $request->input('kesan_pesan.' . $guruId, null);

            if (empty($jawabanGuru)) {
                continue;
            }

            $kuesioner = Kuesioner::create([
                'guru_id'         => $guruId,
                'penilai_guru_id' => $penilai->id,
                'tipe'            => 'guru',
                'tanggal'         => now()->toDateString(),
                'tahun_ajaran'    => $tahunAjaran,
                'semester'        => $semester,
                'kesan_pesan'     => $kesanPesan ?: null,
            ]);

            foreach ($jawabanGuru as $pertanyaanId => $nilai) {
                $nilai = (int) $nilai;
                if ($nilai >= 0 && $nilai <= 2) {
                    Jawaban::create([
                        'kuesioner_id'  => $kuesioner->id,
                        'pertanyaan_id' => $pertanyaanId,
                        'nilai'         => $nilai,
                    ]);
                }
            }

            $berhasil++;
        }

        if ($berhasil === 0 && !empty($errors)) {
            return back()->with('error', implode(' ', $errors));
        }

        $msg = 'Penilaian berhasil disimpan untuk ' . $berhasil . ' rekan guru!';
        if (!empty($errors)) {
            $msg .= ' Catatan: ' . implode(' ', $errors);
        }

        return redirect()->route('guru.kuesioner')->with('success', $msg);
    }

    public function profil()
    {
        $guru = auth()->user()->guru;

        $kuesioner = \App\Models\Kuesioner::where('guru_id', $guru->id)
            ->where('tipe', 'guru')
            ->with('jawaban.pertanyaan')
            ->get();

        $totalPenilai   = $kuesioner->count();
        $skorKategori   = ['pedagogik' => 0, 'kepribadian' => 0, 'sosial' => 0, 'profesional' => 0];
        $hitungKategori = ['pedagogik' => 0, 'kepribadian' => 0, 'sosial' => 0, 'profesional' => 0];

        foreach ($kuesioner as $k) {
            foreach ($k->jawaban as $j) {
                if ($j->pertanyaan && isset($skorKategori[$j->pertanyaan->kategori])) {
                    $skorKategori[$j->pertanyaan->kategori]   += $j->nilai;
                    $hitungKategori[$j->pertanyaan->kategori]++;
                }
            }
        }

        foreach ($skorKategori as $kat => $total) {
            $skorKategori[$kat] = $hitungKategori[$kat] > 0
                ? round($total / $hitungKategori[$kat], 2)
                : 0;
        }

        $nilaiAda = array_filter($skorKategori, fn($v) => $v > 0);
        $skorRata = count($nilaiAda) > 0
            ? round(array_sum($nilaiAda) / count($nilaiAda), 2)
            : 0;

        $kesanPesan = \App\Models\Kuesioner::where('guru_id', $guru->id)
            ->whereIn('tipe', ['guru', 'siswa'])
            ->whereNotNull('kesan_pesan')
            ->where('kesan_pesan', '!=', '')
            ->select('kesan_pesan', 'tanggal', 'tahun_ajaran', 'semester', 'tipe')
            ->orderByDesc('tanggal')
            ->get();

        return view('guru.profil', compact('guru', 'skorKategori', 'skorRata', 'totalPenilai', 'kesanPesan'));
    }

    public function absensi()
    {
        $guru       = auth()->user()->guru;
        $riwayat    = Absensi::where('guru_id', $guru->id)->orderByDesc('tanggal')->paginate(20);
        $sudahAbsen = Absensi::where('guru_id', $guru->id)->whereDate('tanggal', today())->exists();

        $statistik = [
            'hadir' => Absensi::where('guru_id', $guru->id)->bulanIni()->where('status', 'hadir')->count(),
            'izin'  => Absensi::where('guru_id', $guru->id)->bulanIni()->where('status', 'izin')->count(),
            'sakit' => Absensi::where('guru_id', $guru->id)->bulanIni()->where('status', 'sakit')->count(),
            'alpha' => Absensi::where('guru_id', $guru->id)->bulanIni()->where('status', 'alpha')->count(),
        ];

        return view('guru.absensi', compact('riwayat', 'sudahAbsen', 'statistik'));
    }

    public function scanRfid(Request $request)
    {
        $guru  = auth()->user()->guru;
        $sudah = Absensi::where('guru_id', $guru->id)->whereDate('tanggal', today())->exists();

        if ($sudah) {
            return back()->with('error', 'Sudah melakukan absensi hari ini.');
        }

        Absensi::create([
            'guru_id'   => $guru->id,
            'tanggal'   => today(),
            'jam_masuk' => now()->format('H:i:s'),
            'status'    => now()->format('H:i') > '07:00' ? 'terlambat' : 'hadir',
            'rfid_uid'  => $guru->rfid_uid,
        ]);

        return back()->with('success', 'Absensi berhasil dicatat pukul ' . now()->format('H:i'));
    }
}
