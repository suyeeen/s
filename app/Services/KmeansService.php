<?php

namespace App\Services;

use App\Models\Guru;
use App\Models\Jawaban;
use App\Models\Kuesioner;
use App\Models\HasilClustering;
use App\Models\Pertanyaan;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KmeansService
{
    protected string $pythonPath;
    protected string $scriptPath;
    protected string $tahunAjaran;
    protected string $semester;

    public function __construct()
    {
        // Sesuaikan path python di server kamu
        $this->pythonPath  = PHP_OS_FAMILY === 'Windows' ? 'python' : 'python3';
        $this->scriptPath  = base_path('python/kmeans.py');
        $this->tahunAjaran = config('app.tahun_ajaran', '2024/2025');
        $this->semester    = config('app.semester', 'ganjil');
    }

    /**
     * Jalankan full pipeline: hitung nilai → clustering → simpan
     */
    public function runClustering(): array
    {
        // ── Step 1: Ambil semua guru yang punya jawaban kuesioner ─────────────
        $guruData = $this->hitungNilaiGuru();

        if (empty($guruData)) {
            throw new \Exception('Belum ada data jawaban kuesioner yang bisa diproses.');
        }

        Log::info('[KMEANS] Data guru yang akan dicluster:', ['jumlah' => count($guruData)]);

        // ── Step 2: Kirim ke Python untuk clustering ──────────────────────────
        $hasilClustering = $this->jalankanPython('clustering', $guruData);

        Log::info('[KMEANS] Hasil clustering diterima:', ['jumlah' => count($hasilClustering)]);

        // ── Step 3: Simpan hasil ke database ─────────────────────────────────
        $this->simpanHasil($hasilClustering);

        return [
            'total'    => count($hasilClustering),
            'detail'   => $hasilClustering,
            'per_cluster' => $this->ringkasanCluster($hasilClustering),
        ];
    }

    /**
     * Hitung rata-rata nilai per kompetensi untuk setiap guru
     * dari tabel jawaban + kuesioner + pertanyaan
     */
    protected function hitungNilaiGuru(): array
    {
        $hasil = DB::select("
            SELECT
                g.id AS guru_id,
                g.nama,
                AVG(CASE WHEN p.kategori = 'pedagogik'   THEN j.nilai END) AS pedagogik,
                AVG(CASE WHEN p.kategori = 'profesional' THEN j.nilai END) AS profesional,
                AVG(CASE WHEN p.kategori = 'sosial'      THEN j.nilai END) AS sosial,
                AVG(CASE WHEN p.kategori = 'kepribadian' THEN j.nilai END) AS kepribadian
            FROM guru g
            JOIN kuesioner k  ON g.id = k.guru_id
            JOIN jawaban j    ON k.id = j.kuesioner_id
            JOIN pertanyaan p ON j.pertanyaan_id = p.id
            GROUP BY g.id, g.nama
            HAVING
                pedagogik   IS NOT NULL AND
                profesional IS NOT NULL AND
                sosial      IS NOT NULL AND
                kepribadian IS NOT NULL
        ");

        return array_map(function ($row) {
            return [
                'guru_id'    => $row->guru_id,
                'nama'       => $row->nama,
                'pedagogik'  => round((float) $row->pedagogik,  2),
                'profesional' => round((float) $row->profesional, 2),
                'sosial'     => round((float) $row->sosial,      2),
                'kepribadian' => round((float) $row->kepribadian, 2),
            ];
        }, $hasil);
    }

    /**
     * Kirim data ke Python script dan terima hasilnya
     */
    protected function jalankanPython(string $mode, array $data): array
    {
        $input = json_encode([
            'mode' => $mode,
            'data' => $data,
        ]);

        $process = new Process([$this->pythonPath, $this->scriptPath]);
        $process->setInput($input);
        $process->setTimeout(120); // 2 menit timeout
        $process->run();

        if (!$process->isSuccessful()) {
            $error = $process->getErrorOutput() ?: $process->getOutput();
            Log::error('[KMEANS] Python error:', ['error' => $error]);
            throw new \Exception('Python script gagal: ' . $error);
        }

        $output = json_decode($process->getOutput(), true);

        if (!$output || $output['status'] !== 'ok') {
            $msg = $output['message'] ?? 'Output Python tidak valid';
            Log::error('[KMEANS] Output error:', ['output' => $output]);
            throw new \Exception($msg);
        }

        return $output['data'];
    }

    /**
     * Simpan hasil clustering ke tabel hasil_clustering
     */
    protected function simpanHasil(array $hasilClustering): void
    {
        foreach ($hasilClustering as $hasil) {
            HasilClustering::updateOrCreate(
                [
                    'guru_id'      => $hasil['guru_id'],
                    'tahun_ajaran' => $this->tahunAjaran,
                    'semester'     => $this->semester,
                ],
                [
                    'nilai_pedagogik'   => $hasil['nilai_pedagogik'],
                    'nilai_profesional' => $hasil['nilai_profesional'],
                    'nilai_sosial'      => $hasil['nilai_sosial'],
                    'nilai_kepribadian' => $hasil['nilai_kepribadian'],
                    'nilai_rata_rata'   => $hasil['nilai_rata_rata'],
                    'cluster'           => $hasil['cluster'],
                    'label_cluster'     => $hasil['label_cluster'],
                    'tanggal'           => now()->toDateString(),
                ]
            );
        }
    }

    /**
     * Ringkasan jumlah guru per cluster
     */
    protected function ringkasanCluster(array $hasil): array
    {
        $ringkasan = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0];
        foreach ($hasil as $item) {
            $ringkasan[$item['cluster']]++;
        }
        return $ringkasan;
    }

    /**
     * Preview nilai guru tanpa clustering (untuk debug)
     */
    public function previewNilai(): array
    {
        return $this->hitungNilaiGuru();
    }
}
