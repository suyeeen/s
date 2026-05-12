<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrestasiGuru;

class PrestasiController extends Controller
{
    /**
     * Bobot poin prestasi berdasarkan tingkat akademik.
     * Semakin tinggi tingkat, semakin besar poin yang diperoleh.
     */
    public static function bobotTingkat(): array
    {
        return [
            'sekolah'       => 5,
            'kecamatan'     => 10,
            'kota'          => 20,
            'provinsi'      => 35,
            'nasional'      => 55,
            'internasional' => 80,
        ];
    }

    /**
     * Hitung total poin dari koleksi prestasi yang sudah tervalidasi,
     * dengan bobot berbeda per tingkat.
     */
    public static function hitungPoin($prestasi): int
    {
        $bobot = self::bobotTingkat();

        return $prestasi
            ->where('status', 'tervalidasi')
            ->sum(fn($p) => $bobot[$p->tingkat] ?? 0);
    }

    public function index()
    {
        $guru     = auth()->user()->guru;
        $prestasi = PrestasiGuru::where('guru_id', $guru->id)->orderByDesc('tahun')->get();

        $statistik = [
            'tervalidasi' => $prestasi->where('status', 'tervalidasi')->count(),
            'menunggu'    => $prestasi->where('status', 'menunggu')->count(),
            'poin'        => self::hitungPoin($prestasi),
        ];

        $bobotTingkat = self::bobotTingkat();

        return view('guru.prestasi', compact('prestasi', 'statistik', 'bobotTingkat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tingkat'       => 'required|in:sekolah,kecamatan,kota,provinsi,nasional,internasional',
            'kategori'      => 'required|in:Sertifikat Pendidik,Pelatihan & Workshop,Karya Ilmiah,Guru Berprestasi,Inovasi Pembelajaran,Pengabdian Masyarakat,Organisasi Profesi,Lainnya',
            'tahun'         => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'file_bukti'    => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $path = $request->file('file_bukti')->store('prestasi', 'public');

        PrestasiGuru::create([
            'guru_id'       => auth()->user()->guru->id,
            'nama_prestasi' => $request->nama_prestasi,
            'tingkat'       => $request->tingkat,
            'kategori'      => $request->kategori,
            'tahun'         => $request->tahun,
            'file_bukti'    => $path,
            'status'        => 'menunggu',
        ]);

        return redirect()->route('guru.prestasi.index')->with('success', 'Prestasi berhasil diunggah!');
    }

    public function destroy(PrestasiGuru $prestasi)
    {
        if ($prestasi->guru_id !== auth()->user()->guru->id) {
            abort(403, 'Anda tidak berhak menghapus prestasi ini.');
        }

        if ($prestasi->file_bukti && \Illuminate\Support\Facades\Storage::disk('public')->exists($prestasi->file_bukti)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($prestasi->file_bukti);
        }

        $prestasi->delete();
        return back()->with('success', 'Prestasi berhasil dihapus.');
    }
}
