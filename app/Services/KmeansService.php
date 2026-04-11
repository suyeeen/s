<?php

namespace App\Services;

use App\Models\Guru;
use App\Models\Jawaban;
use App\Models\HasilClustering;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\DB;

class KmeansService
{
    public function runClustering(): array
    {
        // Ambil rata-rata nilai per kompetensi dari jawaban kuesioner
        $data = Guru::select('guru.id as guru_id')
            ->join('kuesioner', 'guru.id', '=', 'kuesioner.guru_id')
            ->join('jawaban', 'kuesioner.id', '=', 'jawaban.kuesioner_id')
            ->join('pertanyaan', 'jawaban.pertanyaan_id', '=', 'pertanyaan.id')
            ->selectRaw('
                guru.id as guru_id,
                AVG(CASE WHEN pertanyaan.kategori = "pedagogik"   THEN jawaban.nilai END) as pedagogik,
                AVG(CASE WHEN pertanyaan.kategori = "profesional" THEN jawaban.nilai END) as profesional,
                AVG(CASE WHEN pertanyaan.kategori = "sosial"      THEN jawaban.nilai END) as sosial,
                AVG(CASE WHEN pertanyaan.kategori = "kepribadian" THEN jawaban.nilai END) as kepribadian
            ')
            ->groupBy('guru.id')
            ->get()
            ->toArray();

        if (empty($data)) {
            throw new \Exception('Belum ada data jawaban kuesioner.');
        }

        // Kirim ke Python
        $process = new Process(['python3', base_path('python/kmeans.py')]);
        $process->setInput(json_encode($data));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \Exception($process->getErrorOutput());
        }

        $hasil = json_decode($process->getOutput(), true);

        // Simpan hasil ke database
        foreach ($hasil as $row) {
            HasilClustering::updateOrCreate(
                [
                    'guru_id'      => $row['guru_id'],
                    'tahun_ajaran' => config('app.tahun_ajaran', '2024/2025'),
                    'semester'     => config('app.semester', 'ganjil'),
                ],
                [
                    'nilai_pedagogik'  => $row['pedagogik'],
                    'nilai_profesional'=> $row['profesional'],
                    'nilai_sosial'     => $row['sosial'],
                    'nilai_kepribadian'=> $row['kepribadian'],
                    'nilai_rata_rata'  => round(($row['pedagogik'] + $row['profesional'] + $row['sosial'] + $row['kepribadian']) / 4, 2),
                    'cluster'          => $row['cluster'],
                    'label_cluster'    => HasilClustering::labelDariCluster($row['cluster']),
                    'tanggal'          => now()->toDateString(),
                ]
            );
        }

        return ['total' => count($hasil)];
    }
}
