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
        $pertanyaan = Pertanyaan::orderBy('urutan')->get()->groupBy('kategori');

        return view('guru.kuesioner', compact('guru', 'pertanyaan'));
    }

    public function submitKuesioner(Request $request)
    {
        $request->validate([
            'guru_id'   => 'required|exists:guru,id',
            'jawaban'   => 'required|array',
            'jawaban.*' => 'required|integer|min:1|max:5',
        ]);

        $penilai = auth()->user()->guru;

        $sudahIsi = Kuesioner::where('guru_id', $request->guru_id)
            ->where('penilai_guru_id', $penilai->id)
            ->where('tahun_ajaran', config('app.tahun_ajaran', '2024/2025'))
            ->where('semester', config('app.semester', 'ganjil'))
            ->exists();

        if ($sudahIsi) {
            return back()->with('error', 'Kamu sudah menilai guru ini pada periode ini.');
        }

        $kuesioner = Kuesioner::create([
            'guru_id'         => $request->guru_id,
            'penilai_guru_id' => $penilai->id,
            'tipe'            => 'guru',
            'tanggal'         => now()->toDateString(),
            'tahun_ajaran'    => config('app.tahun_ajaran', '2024/2025'),
            'semester'        => config('app.semester', 'ganjil'),
        ]);

        foreach ($request->jawaban as $pertanyaan_id => $nilai) {
            Jawaban::create([
                'kuesioner_id'  => $kuesioner->id,
                'pertanyaan_id' => $pertanyaan_id,
                'nilai'         => $nilai,
            ]);
        }

        return redirect()->route('guru.kuesioner')->with('success', 'Penilaian berhasil disimpan!');
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
