<?php

namespace App\Http\Controllers;

use App\Services\KmeansService;

class KmeansController extends Controller
{
    public function run(KmeansService $kmeans)
    {
        try {
            $hasil = $kmeans->runClustering();
            return back()->with('success', "Clustering selesai. {$hasil['total']} guru berhasil dipetakan.");
        } catch (\Exception $e) {
            return back()->with('error', 'Clustering gagal: ' . $e->getMessage());
        }
    }
}
