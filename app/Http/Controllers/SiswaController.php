<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Pertanyaan;
use App\Models\Kuesioner;
use App\Models\Jawaban;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;

        if (!$siswa) {
            $siswa = Siswa::create([
                'user_id' => auth()->id(),
                'nama'    => auth()->user()->name,
                'kelas'   => '-',
            ]);
        }

        $guru       = Guru::all();
        $pertanyaan = Pertanyaan::whereIn('untuk_penilai', ['siswa', 'keduanya'])
            ->orderBy('kategori')->orderBy('urutan')->get()->groupBy('kategori');

        $tahunAjaran = \Illuminate\Support\Facades\Cache::get('stqm_tahun_ajaran', '2024/2025');
        $semester    = \Illuminate\Support\Facades\Cache::get('stqm_semester', 'ganjil');

        $sudahDinilai = Kuesioner::where('siswa_id', $siswa->id)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->pluck('guru_id')
            ->toArray();

        return view('siswa.kuesioner', compact('guru', 'pertanyaan', 'sudahDinilai'));
    }

    public function submit(Request $request)
    {
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

        $buka  = \Illuminate\Support\Facades\Cache::get('stqm_buka_kuesioner', '');
        $tutup = \Illuminate\Support\Facades\Cache::get('stqm_tutup_kuesioner', '');
        $now   = now()->toDateString();

        if ($buka && $now < $buka) {
            return back()->with('error', 'Kuesioner belum dibuka. Jadwal dibuka: ' . $buka);
        }
        if ($tutup && $now > $tutup) {
            return back()->with('error', 'Batas waktu pengisian kuesioner sudah berakhir (' . $tutup . ').');
        }

        $siswa       = auth()->user()->siswa;
        $tahunAjaran = \Illuminate\Support\Facades\Cache::get('stqm_tahun_ajaran', '2024/2025');
        $semester    = \Illuminate\Support\Facades\Cache::get('stqm_semester', 'ganjil');
        $maksimal    = (int) \Illuminate\Support\Facades\Cache::get('stqm_maks_penilaian', 1);

        $berhasil = 0;
        $errors   = [];

        foreach ($guruIds as $guruId) {
            $jumlahIsi = Kuesioner::where('siswa_id', $siswa->id)
                ->where('guru_id', $guruId)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('semester', $semester)
                ->count();

            if ($jumlahIsi >= $maksimal) {
                $guru = Guru::find($guruId);
                $errors[] = 'Guru ' . ($guru->nama ?? $guruId) . ' sudah pernah dinilai (batas ' . $maksimal . 'x per periode).';
                continue;
            }

            $jawabanGuru = $request->input('jawaban.' . $guruId, []);
            $kesanPesan  = $request->input('kesan_pesan.' . $guruId, null);

            if (empty($jawabanGuru)) {
                continue;
            }

            $kuesioner = Kuesioner::create([
                'guru_id'      => $guruId,
                'siswa_id'     => $siswa->id,
                'tipe'         => 'siswa',
                'tanggal'      => now()->toDateString(),
                'tahun_ajaran' => $tahunAjaran,
                'semester'     => $semester,
                'kesan_pesan'  => $kesanPesan ?: null,
            ]);

            foreach ($jawabanGuru as $pertanyaanId => $nilai) {
                $nilai = (int) $nilai;
                if ($nilai >= 1 && $nilai <= 5) {
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

        $msg = 'Evaluasi berhasil dikirim untuk ' . $berhasil . ' guru!';
        if (!empty($errors)) {
            $msg .= ' Catatan: ' . implode(' ', $errors);
        }

        return redirect()->route('siswa.kuesioner')->with('success', $msg);
    }
}
