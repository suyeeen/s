<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrestasiGuru;

class PrestasiController extends Controller
{
    public function index()
    {
        $guru     = auth()->user()->guru;
        $prestasi = PrestasiGuru::where('guru_id', $guru->id)->orderByDesc('tahun')->get();

        $statistik = [
            'tervalidasi' => $prestasi->where('status', 'tervalidasi')->count(),
            'menunggu'    => $prestasi->where('status', 'menunggu')->count(),
            'poin'        => $prestasi->where('status', 'tervalidasi')->count() * 15,
        ];

        return view('guru.prestasi', compact('prestasi', 'statistik'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'tingkat'       => 'required|in:sekolah,kecamatan,kota,provinsi,nasional,internasional',
            'kategori'      => 'required|in:Sertifikasi,Pelatihan,Penghargaan,Publikasi,Lainnya',
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
        $this->authorize('delete', $prestasi); // optional policy
        $prestasi->delete();
        return back()->with('success', 'Prestasi berhasil dihapus.');
    }
}
