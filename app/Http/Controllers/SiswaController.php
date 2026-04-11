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
    public function index()  // ← ganti dari 'kuesioner' ke 'index'
    {
        $guru       = Guru::all();
        $pertanyaan = Pertanyaan::orderBy('kategori')->orderBy('urutan')->get()->groupBy('kategori');

        return view('siswa.kuesioner', compact('guru', 'pertanyaan'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'guru_id'   => 'required|exists:guru,id',
            'jawaban'   => 'required|array',
            'jawaban.*' => 'required|integer|min:1|max:5',
        ]);

        $siswa = auth()->user()->siswa;

        $sudahIsi = Kuesioner::where('guru_id', $request->guru_id)
            ->where('siswa_id', $siswa->id)
            ->where('tahun_ajaran', config('app.tahun_ajaran', '2024/2025'))
            ->where('semester', config('app.semester', 'ganjil'))
            ->exists();

        if ($sudahIsi) {
            return back()->with('error', 'Kamu sudah mengisi kuesioner untuk guru ini.');
        }

        $kuesioner = Kuesioner::create([
            'guru_id'      => $request->guru_id,
            'siswa_id'     => $siswa->id,
            'tipe'         => 'siswa',
            'tanggal'      => now()->toDateString(),
            'tahun_ajaran' => config('app.tahun_ajaran', '2024/2025'),
            'semester'     => config('app.semester', 'ganjil'),
        ]);

        foreach ($request->jawaban as $pertanyaan_id => $nilai) {
            Jawaban::create([
                'kuesioner_id'  => $kuesioner->id,
                'pertanyaan_id' => $pertanyaan_id,
                'nilai'         => $nilai,
            ]);
        }

        return redirect()->route('siswa.kuesioner')->with('success', 'Kuesioner berhasil dikirim!');
    }
}
