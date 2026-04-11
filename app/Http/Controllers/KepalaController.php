<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\HasilClustering;
use Maatwebsite\Excel\Facades\Excel;

class KepalaController extends Controller
{
    public function dashboard()
    {
        $guru  = Guru::with('clusterTerakhir')->get();
        $total = $guru->count();

        $distribusiCluster = HasilClustering::selectRaw('cluster, count(*) as total')
            ->groupBy('cluster')
            ->pluck('total', 'cluster');

        $rataKompetensi = HasilClustering::selectRaw('
            AVG(nilai_pedagogik)  as pedagogik,
            AVG(nilai_profesional) as profesional,
            AVG(nilai_sosial)     as sosial,
            AVG(nilai_kepribadian) as kepribadian
        ')->first();

        $topGuru = Guru::with('clusterTerakhir')
            ->join('hasil_clustering', 'guru.id', '=', 'hasil_clustering.guru_id')
            ->orderByDesc('hasil_clustering.nilai_rata_rata')
            ->select('guru.*')
            ->take(5)
            ->get();

        return view('kepala.dashboard', compact(
            'guru',
            'total',
            'distribusiCluster',
            'rataKompetensi',
            'topGuru'
        ));
    }

    public function evaluasi()
    {
        $cluster = request('cluster', 'ALL');
        $sort    = request('sort', 'nilai_rata_rata');
        $dir     = request('dir', 'desc');
        $search  = request('search', '');

        $guru = Guru::with(['clusterTerakhir', 'absensi', 'prestasi'])
            ->leftJoin('hasil_clustering', function ($join) {
                $join->on('guru.id', '=', 'hasil_clustering.guru_id')
                    ->where('hasil_clustering.tahun_ajaran', config('app.tahun_ajaran', '2024/2025'))
                    ->where('hasil_clustering.semester', config('app.semester', 'ganjil'));
            })
            ->when($search, fn($q) => $q->where('guru.nama', 'like', "%$search%")
                ->orWhere('guru.nip', 'like', "%$search%"))
            ->when($cluster !== 'ALL', fn($q) => $q->where('hasil_clustering.cluster', $cluster))
            ->orderBy("hasil_clustering.$sort", $dir)
            ->select('guru.*')
            ->paginate(15)
            ->withQueryString();

        return view('kepala.evaluasi', compact('guru', 'cluster', 'sort', 'dir', 'search'));
    }

    public function detailGuru(Guru $guru)
    {
        $guru->load(['clusterTerakhir', 'prestasi', 'absensi' => fn($q) => $q->orderByDesc('tanggal')->take(10)]);

        $totalHadir = $guru->absensi->where('status', 'hadir')->count();
        $totalAbsen = $guru->absensi->count();
        $persenHadir = $totalAbsen > 0 ? round($totalHadir / $totalAbsen * 100) : 0;

        return view('kepala.detail-guru', compact('guru', 'persenHadir'));
    }

    public function export()
    {
        // Implementasi dengan maatwebsite/excel
        // return Excel::download(new GuruEvaluasiExport, 'evaluasi-guru.xlsx');
    }
}
