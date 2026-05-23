<?php

namespace App\Services;

use App\Models\Guru;
use App\Models\Jawaban;
use App\Models\Kuesioner;
use App\Models\HasilClustering;
use App\Models\Pertanyaan;
use App\Models\Absensi;
use App\Models\PrestasiGuru;
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
        $guruData = $this->hitungNilaiGuru();

        if (empty($guruData)) {
            throw new \Exception('Belum ada data jawaban kuesioner yang bisa diproses.');
        }

        Log::info('[KMEANS] Data guru yang akan dicluster:', ['jumlah' => count($guruData)]);

        $hasilClustering = $this->jalankanPython('clustering', $guruData);

        Log::info('[KMEANS] Hasil clustering diterima:', ['jumlah' => count($hasilClustering)]);

        $this->simpanHasil($hasilClustering, $guruData);

        return [
            'total'       => count($hasilClustering),
            'detail'      => $hasilClustering,
            'per_cluster' => $this->ringkasanCluster($hasilClustering),
        ];
    }

    /**
     * Hitung nilai per kompetensi + absensi + poin prestasi untuk setiap guru.
     * Menggabungkan 6 dimensi:
     *   1. pedagogik     (0-5, dari kuesioner)
     *   2. profesional   (0-5, dari kuesioner)
     *   3. sosial        (0-5, dari kuesioner)
     *   4. kepribadian   (0-5, dari kuesioner)
     *   5. persen_absensi (0-100, dari rekap admin → dinormalisasi ke 0-5)
     *   6. poin_prestasi  (0-∞, dari tabel prestasi_guru → dinormalisasi ke 0-5)
     */
    protected function hitungNilaiGuru(): array
    {
        // 1. Ambil nilai kuesioner
        $rows = DB::select("
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

        // 2. Hitung poin prestasi max (untuk normalisasi)
        $bobotTingkat = [
            'sekolah'       => 5,
            'kecamatan'     => 10,
            'kota'          => 20,
            'provinsi'      => 35,
            'nasional'      => 55,
            'internasional' => 80,
        ];
        $maxPoin = 80; // internasional = 80 → jadikan skala referensi

        return array_map(function ($row) use ($bobotTingkat, $maxPoin) {
            // Ambil persentase absensi
            $persenAbsensi = Absensi::rataPersenHadir($row->guru_id);

            // Ambil poin prestasi tervalidasi
            $prestasi = PrestasiGuru::where('guru_id', $row->guru_id)
                ->where('status', 'tervalidasi')
                ->get();
            $poinPrestasi = $prestasi->sum(fn($p) => $bobotTingkat[$p->tingkat] ?? 0);

            // Normalisasi absensi ke skala 0-5
            // 100% hadir → 5.0, 80% → 4.0, dst.
            $absensiNorm = round($persenAbsensi / 100 * 5, 4);

            // Normalisasi poin prestasi ke 0-5
            // Misalkan poin > 80 di-cap di 80 dulu lalu di-scale
            $poinCapped  = min($poinPrestasi, $maxPoin);
            $prestasiNorm = round($poinCapped / $maxPoin * 5, 4);

            return [
                'guru_id'          => $row->guru_id,
                'nama'             => $row->nama,
                'pedagogik'        => round((float) $row->pedagogik,  4),
                'profesional'      => round((float) $row->profesional, 4),
                'sosial'           => round((float) $row->sosial,      4),
                'kepribadian'      => round((float) $row->kepribadian, 4),
                'absensi_norm'     => $absensiNorm,
                'prestasi_norm'    => $prestasiNorm,
                // raw untuk disimpan ke DB
                'persen_absensi'   => $persenAbsensi,
                'poin_prestasi'    => $poinPrestasi,
            ];
        }, $rows);
    }

    /**
     * Kirim data ke Python script dan terima hasilnya
     */
    protected function jalankanPython(string $mode, array $data): array
    {
        // Kirim hanya kolom yang dibutuhkan Python (6 fitur numerik)
        $dataUntukPython = array_map(fn($d) => [
            'guru_id'       => $d['guru_id'],
            'nama'          => $d['nama'],
            'pedagogik'     => $d['pedagogik'],
            'profesional'   => $d['profesional'],
            'sosial'        => $d['sosial'],
            'kepribadian'   => $d['kepribadian'],
            'absensi_norm'  => $d['absensi_norm'],
            'prestasi_norm' => $d['prestasi_norm'],
        ], $data);

        $input = json_encode([
            'mode' => $mode,
            'data' => $dataUntukPython,
        ]);

        $process = new Process([$this->pythonPath, $this->scriptPath]);
        $process->setInput($input);
        $process->setTimeout(120);
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
     * Merge data raw (persen_absensi, poin_prestasi) dari guruData ke hasil Python
     */
    protected function simpanHasil(array $hasilClustering, array $guruData): void
    {
        // Buat map guru_id → raw data
        $rawMap = collect($guruData)->keyBy('guru_id');

        foreach ($hasilClustering as $hasil) {
            $raw = $rawMap[$hasil['guru_id']] ?? null;

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
                    'persen_absensi'    => $raw ? $raw['persen_absensi'] : 0,
                    'poin_prestasi'     => $raw ? $raw['poin_prestasi'] : 0,
                    'nilai_akhir'       => $hasil['nilai_akhir'],
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
