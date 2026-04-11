<?php

namespace App\Http\Controllers;

use App\Models\PrestasiGuru;
use Illuminate\Http\Request;

class AdminPrestasiController extends Controller
{
    /**
     * Tampilkan semua prestasi yang menunggu verifikasi.
     */
    public function index()
    {
        $prestasi_menunggu = PrestasiGuru::with('guru')
            ->where('status', 'menunggu')
            ->latest()
            ->paginate(10, ['*'], 'menunggu_page');

        $prestasi_tervalidasi = PrestasiGuru::with('guru')
            ->where('status', 'tervalidasi')
            ->latest()
            ->paginate(10, ['*'], 'tervalidasi_page');

        $prestasi_ditolak = PrestasiGuru::with('guru')
            ->where('status', 'ditolak')
            ->latest()
            ->paginate(10, ['*'], 'ditolak_page');

        return view('admin.prestasi', compact(
            'prestasi_menunggu',
            'prestasi_tervalidasi',
            'prestasi_ditolak'
        ));
    }

    /**
     * Verifikasi (setujui) prestasi guru.
     */
    public function verifikasi($id)
    {
        $prestasi = PrestasiGuru::findOrFail($id);

        if ($prestasi->status !== 'menunggu') {
            return back()->with('error', 'Prestasi ini sudah diproses sebelumnya.');
        }

        $prestasi->update([
            'status'          => 'tervalidasi',
            'divalidasi_oleh' => auth()->id(),
            'divalidasi_at'   => now(),
        ]);

        return back()->with('success', "Prestasi \"{$prestasi->nama_prestasi}\" berhasil diverifikasi.");
    }

    /**
     * Tolak prestasi guru dengan alasan.
     */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'nullable|string|max:500',
        ]);

        $prestasi = PrestasiGuru::findOrFail($id);

        if ($prestasi->status !== 'menunggu') {
            return back()->with('error', 'Prestasi ini sudah diproses sebelumnya.');
        }

        $prestasi->update([
            'status'          => 'ditolak',
            'divalidasi_oleh' => auth()->id(),
            'divalidasi_at'   => now(),
        ]);

        return back()->with('success', "Prestasi \"{$prestasi->nama_prestasi}\" telah ditolak.");
    }

    /**
     * Reset prestasi yang ditolak kembali ke menunggu.
     */
    public function reset($id)
    {
        $prestasi = PrestasiGuru::findOrFail($id);

        $prestasi->update([
            'status'          => 'menunggu',
            'divalidasi_oleh' => null,
            'divalidasi_at'   => null,
        ]);

        return back()->with('success', "Prestasi \"{$prestasi->nama_prestasi}\" dikembalikan ke antrian.");
    }
}
