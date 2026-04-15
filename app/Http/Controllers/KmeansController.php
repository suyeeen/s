<?php

namespace App\Http\Controllers;

use App\Services\KmeansService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KmeansController extends Controller
{
    protected KmeansService $kmeans;

    public function __construct(KmeansService $kmeans)
    {
        $this->kmeans = $kmeans;
    }

    /**
     * Jalankan clustering dari halaman admin monitoring
     */
    public function run(Request $request)
    {
        try {
            $hasil = $this->kmeans->runClustering();

            $pesan = "Clustering selesai! {$hasil['total']} guru berhasil dipetakan. ";
            $pesan .= "Cluster A: {$hasil['per_cluster']['A']}, ";
            $pesan .= "B: {$hasil['per_cluster']['B']}, ";
            $pesan .= "C: {$hasil['per_cluster']['C']}, ";
            $pesan .= "D: {$hasil['per_cluster']['D']}.";

            return back()->with('success', $pesan);
        } catch (\Exception $e) {
            Log::error('[KMEANS] Gagal:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Clustering gagal: ' . $e->getMessage());
        }
    }

    /**
     * Preview nilai guru sebelum clustering (opsional)
     */
    public function preview()
    {
        try {
            $data = $this->kmeans->previewNilai();
            return response()->json(['status' => 'ok', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
