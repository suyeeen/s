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
        // Pastikan siswa punya profil
        $siswa = auth()->user()->siswa;

        if (!$siswa) {
            // Buat profil otomatis jika belum ada
            $siswa = Siswa::create([
                'user_id' => auth()->id(),
                'nama'    => auth()->user()->name,
                'kelas'   => '-',
            ]);
        }

        $guru       = Guru::all();
        $pertanyaan = Pertanyaan::orderBy('kategori')->orderBy('urutan')->get()->groupBy('kategori');

        // Ambil daftar guru yang sudah dinilai periode ini
        $sudahDinilai = Kuesioner::where('siswa_id', $siswa->id)
            ->where('tahun_ajaran', config('app.tahun_ajaran', '2024/2025'))
            ->where('semester', config('app.semester', 'ganjil'))
            ->pluck('guru_id')
            ->toArray();

        return view('siswa.kuesioner', compact('guru', 'pertanyaan', 'sudahDinilai'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'guru_id'   => 'required|exists:guru,id',
            'jawaban'   => 'required|array',
            'jawaban.*' => 'required|integer|min:1|max:5',
        ]);

        // Cek batas waktu
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

        $jumlahIsi = \App\Models\Kuesioner::where('siswa_id', $siswa->id)
            ->where('guru_id', $request->guru_id)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->count();

        if ($jumlahIsi >= $maksimal) {
            return back()->with('error', 'Kamu sudah mengisi evaluasi untuk guru ini sebanyak ' . $jumlahIsi . 'x. Batas maksimal ' . $maksimal . 'x per periode.');
        }

        $kuesioner = \App\Models\Kuesioner::create([
            'guru_id'      => $request->guru_id,
            'siswa_id'     => $siswa->id,
            'tipe'         => 'siswa',
            'tanggal'      => now()->toDateString(),
            'tahun_ajaran' => $tahunAjaran,
            'semester'     => $semester,
        ]);

        foreach ($request->jawaban as $pertanyaan_id => $nilai) {
            \App\Models\Jawaban::create([
                'kuesioner_id'  => $kuesioner->id,
                'pertanyaan_id' => $pertanyaan_id,
                'nilai'         => $nilai,
            ]);
        }

        return redirect()->route('siswa.kuesioner')->with('success', 'Evaluasi berhasil dikirim!');
    }
}
