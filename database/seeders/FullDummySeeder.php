<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Guru;
use Carbon\Carbon;

/**
 * FullDummySeeder
 * Mengisi data: guru + user, hasil_clustering, absensi, prestasi_guru
 * Cocok untuk demo/testing tanpa perlu menjalankan K-Means secara nyata.
 *
 * Jalankan: php artisan db:seed --class=FullDummySeeder
 */
class FullDummySeeder extends Seeder
{
    // ─── Konfigurasi ───────────────────────────────────────────────────────
    private string $tahunAjaran = '2024/2025';
    private string $semester    = 'ganjil';
    private string $tanggalClustering = '2025-01-15';

    /**
     * Definisi guru beserta nilai kompetensi yang sudah di-hardcode
     * (meniru hasil agregasi jawaban kuesioner → K-Means)
     *
     * Skala nilai: 1.00 – 4.00 (mirip skala Likert 4 poin)
     * Cluster: A=Sangat Baik (≥3.5), B=Baik (2.8–3.49), C=Cukup (2.0–2.79), D=Perlu Pembinaan (<2.0)
     */
    private array $guruData = [
        // ── Cluster A – Sangat Baik ─────────────────────────────────────────
        [
            'nama'           => 'Ahmad Fauzi, S.Pd',
            'nip'            => '198001012005011001',
            'mata_pelajaran' => 'Matematika',
            'email'          => 'guru10@stqm.sch.id',
            'cluster'        => 'A',
            'label_cluster'  => 'Sangat Baik',
            'pedagogik'      => 3.85,
            'profesional'    => 3.90,
            'sosial'         => 3.80,
            'kepribadian'    => 3.75,
        ],
        [
            'nama'           => 'Dewi Rahayu, M.Pd',
            'nip'            => '198202022006022002',
            'mata_pelajaran' => 'Bahasa Indonesia',
            'email'          => 'guru11@stqm.sch.id',
            'cluster'        => 'A',
            'label_cluster'  => 'Sangat Baik',
            'pedagogik'      => 3.70,
            'profesional'    => 3.80,
            'sosial'         => 3.90,
            'kepribadian'    => 3.85,
        ],
        [
            'nama'           => 'Hendra Kusuma, S.Kom',
            'nip'            => '198303032007031003',
            'mata_pelajaran' => 'TIK',
            'email'          => 'guru12@stqm.sch.id',
            'cluster'        => 'A',
            'label_cluster'  => 'Sangat Baik',
            'pedagogik'      => 3.60,
            'profesional'    => 3.95,
            'sosial'         => 3.70,
            'kepribadian'    => 3.65,
        ],
        [
            'nama'           => 'Rina Wulandari, S.Si',
            'nip'            => '198404042008042004',
            'mata_pelajaran' => 'IPA',
            'email'          => 'guru13@stqm.sch.id',
            'cluster'        => 'A',
            'label_cluster'  => 'Sangat Baik',
            'pedagogik'      => 3.75,
            'profesional'    => 3.70,
            'sosial'         => 3.65,
            'kepribadian'    => 3.80,
        ],

        // ── Cluster B – Baik ────────────────────────────────────────────────
        [
            'nama'           => 'Budi Setiawan, S.Pd',
            'nip'            => '198505052009051005',
            'mata_pelajaran' => 'IPS',
            'email'          => 'guru14@stqm.sch.id',
            'cluster'        => 'B',
            'label_cluster'  => 'Baik',
            'pedagogik'      => 3.20,
            'profesional'    => 3.10,
            'sosial'         => 3.30,
            'kepribadian'    => 3.15,
        ],
        [
            'nama'           => 'Sari Indah, M.Pd',
            'nip'            => '198606062010062006',
            'mata_pelajaran' => 'PKN',
            'email'          => 'guru15@stqm.sch.id',
            'cluster'        => 'B',
            'label_cluster'  => 'Baik',
            'pedagogik'      => 3.00,
            'profesional'    => 3.25,
            'sosial'         => 3.10,
            'kepribadian'    => 3.40,
        ],
        [
            'nama'           => 'Doni Prasetyo, S.Pd',
            'nip'            => '198707072011071007',
            'mata_pelajaran' => 'Olahraga',
            'email'          => 'guru16@stqm.sch.id',
            'cluster'        => 'B',
            'label_cluster'  => 'Baik',
            'pedagogik'      => 3.10,
            'profesional'    => 2.90,
            'sosial'         => 3.35,
            'kepribadian'    => 3.20,
        ],
        [
            'nama'           => 'Fitri Handayani, S.Pd',
            'nip'            => '198808082012082008',
            'mata_pelajaran' => 'Seni Budaya',
            'email'          => 'guru17@stqm.sch.id',
            'cluster'        => 'B',
            'label_cluster'  => 'Baik',
            'pedagogik'      => 2.95,
            'profesional'    => 3.05,
            'sosial'         => 3.00,
            'kepribadian'    => 3.10,
        ],

        // ── Cluster C – Cukup ───────────────────────────────────────────────
        [
            'nama'           => 'Eko Santoso, S.Pd',
            'nip'            => '198909092013091009',
            'mata_pelajaran' => 'Agama',
            'email'          => 'guru18@stqm.sch.id',
            'cluster'        => 'C',
            'label_cluster'  => 'Cukup',
            'pedagogik'      => 2.50,
            'profesional'    => 2.40,
            'sosial'         => 2.60,
            'kepribadian'    => 2.55,
        ],
        [
            'nama'           => 'Lina Marlina, M.Pd',
            'nip'            => '199010102014102010',
            'mata_pelajaran' => 'Bahasa Inggris',
            'email'          => 'guru19@stqm.sch.id',
            'cluster'        => 'C',
            'label_cluster'  => 'Cukup',
            'pedagogik'      => 2.35,
            'profesional'    => 2.55,
            'sosial'         => 2.45,
            'kepribadian'    => 2.40,
        ],
        [
            'nama'           => 'Wahyu Hidayat, S.Pd',
            'nip'            => '199111112015111011',
            'mata_pelajaran' => 'Fisika',
            'email'          => 'guru20@stqm.sch.id',
            'cluster'        => 'C',
            'label_cluster'  => 'Cukup',
            'pedagogik'      => 2.60,
            'profesional'    => 2.30,
            'sosial'         => 2.50,
            'kepribadian'    => 2.45,
        ],
        [
            'nama'           => 'Nurul Hasanah, S.Pd',
            'nip'            => '199212122016122012',
            'mata_pelajaran' => 'Kimia',
            'email'          => 'guru21@stqm.sch.id',
            'cluster'        => 'C',
            'label_cluster'  => 'Cukup',
            'pedagogik'      => 2.45,
            'profesional'    => 2.65,
            'sosial'         => 2.35,
            'kepribadian'    => 2.55,
        ],

        // ── Cluster D – Perlu Pembinaan ─────────────────────────────────────
        [
            'nama'           => 'Reza Firmansyah, S.Pd',
            'nip'            => '199313132017131013',
            'mata_pelajaran' => 'Biologi',
            'email'          => 'guru22@stqm.sch.id',
            'cluster'        => 'D',
            'label_cluster'  => 'Perlu Pembinaan',
            'pedagogik'      => 1.80,
            'profesional'    => 1.70,
            'sosial'         => 1.90,
            'kepribadian'    => 1.75,
        ],
        [
            'nama'           => 'Mega Putri, M.Pd',
            'nip'            => '199414142018142014',
            'mata_pelajaran' => 'Ekonomi',
            'email'          => 'guru23@stqm.sch.id',
            'cluster'        => 'D',
            'label_cluster'  => 'Perlu Pembinaan',
            'pedagogik'      => 1.65,
            'profesional'    => 1.85,
            'sosial'         => 1.70,
            'kepribadian'    => 1.80,
        ],
        [
            'nama'           => 'Arif Budiman, S.Pd',
            'nip'            => '199515152019151015',
            'mata_pelajaran' => 'Geografi',
            'email'          => 'guru24@stqm.sch.id',
            'cluster'        => 'D',
            'label_cluster'  => 'Perlu Pembinaan',
            'pedagogik'      => 1.90,
            'profesional'    => 1.60,
            'sosial'         => 1.75,
            'kepribadian'    => 1.85,
        ],
    ];

    // ─── Main run() ────────────────────────────────────────────────────────
    public function run(): void
    {
        $this->command->info('🚀 Memulai FullDummySeeder...');
        $this->command->newLine();

        DB::transaction(function () {
            $guruIds = $this->seedGuru();
            $this->seedHasilClustering($guruIds);
            $this->seedAbsensi($guruIds);
            $this->seedPrestasiGuru($guruIds);
        });

        $this->printSummary();
    }

    // ─── 1. Guru + User ────────────────────────────────────────────────────
    private function seedGuru(): array
    {
        $this->command->info('👤 [1/4] Membuat data Guru & User...');
        $guruIds = [];

        foreach ($this->guruData as $index => $g) {
            if (User::where('email', $g['email'])->exists()) {
                $guru = Guru::whereHas('user', fn($q) => $q->where('email', $g['email']))->first();
                if ($guru) {
                    $guruIds[$index] = $guru->id;
                    $this->command->warn("   ⚠️  Skip {$g['email']} — sudah ada (id={$guru->id})");
                    continue;
                }
            }

            $user = User::create([
                'name'     => $g['nama'],
                'email'    => $g['email'],
                'password' => Hash::make('stqm123'),
                'role'     => 'guru',
            ]);

            $guru = Guru::create([
                'user_id'        => $user->id,
                'nama'           => $g['nama'],
                'nip'            => $g['nip'],
                'mata_pelajaran' => $g['mata_pelajaran'],
            ]);

            $guruIds[$index] = $guru->id;
            $this->command->info("   ✅ {$g['nama']} [{$g['cluster']}] (id={$guru->id})");
        }

        return $guruIds;
    }

    // ─── 2. Hasil Clustering ───────────────────────────────────────────────
    private function seedHasilClustering(array $guruIds): void
    {
        $this->command->newLine();
        $this->command->info('📊 [2/4] Mengisi hasil_clustering...');

        foreach ($this->guruData as $index => $g) {
            if (!isset($guruIds[$index])) continue;

            $guruId = $guruIds[$index];

            // Cek duplikat (constraint unique)
            $exists = DB::table('hasil_clustering')
                ->where('guru_id', $guruId)
                ->where('tahun_ajaran', $this->tahunAjaran)
                ->where('semester', $this->semester)
                ->exists();

            if ($exists) {
                $this->command->warn("   ⚠️  Skip clustering guru_id={$guruId} — sudah ada");
                continue;
            }

            $nilaiRataRata = round(
                ($g['pedagogik'] + $g['profesional'] + $g['sosial'] + $g['kepribadian']) / 4,
                2
            );

            DB::table('hasil_clustering')->insert([
                'guru_id'         => $guruId,
                'nilai_pedagogik' => $g['pedagogik'],
                'nilai_profesional'=> $g['profesional'],
                'nilai_sosial'    => $g['sosial'],
                'nilai_kepribadian'=> $g['kepribadian'],
                'nilai_rata_rata' => $nilaiRataRata,
                'cluster'         => $g['cluster'],
                'label_cluster'   => $g['label_cluster'],
                'tahun_ajaran'    => $this->tahunAjaran,
                'semester'        => $this->semester,
                'tanggal'         => $this->tanggalClustering,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            $this->command->info(
                "   ✅ {$g['nama']} → Cluster {$g['cluster']} ({$g['label_cluster']}) | rata-rata: {$nilaiRataRata}"
            );
        }
    }

    // ─── 3. Absensi (3 bulan terakhir, hari kerja) ─────────────────────────
    private function seedAbsensi(array $guruIds): void
    {
        $this->command->newLine();
        $this->command->info('📅 [3/4] Mengisi absensi (3 bulan terakhir)...');

        // Tingkat kehadiran per cluster: A=95%, B=85%, C=75%, D=60%
        $kehadiranRate = ['A' => 0.95, 'B' => 0.85, 'C' => 0.75, 'D' => 0.60];

        // Generate tanggal hari kerja 3 bulan terakhir
        $tanggalMulai = Carbon::now()->subMonths(3)->startOfMonth();
        $tanggalAkhir = Carbon::now()->endOfMonth();
        $hariKerja    = [];

        $current = $tanggalMulai->copy();
        while ($current->lte($tanggalAkhir)) {
            if (!$current->isWeekend()) {
                $hariKerja[] = $current->format('Y-m-d');
            }
            $current->addDay();
        }

        $totalAbsensi = 0;

        foreach ($this->guruData as $index => $g) {
            if (!isset($guruIds[$index])) continue;

            $guruId = $guruIds[$index];
            $rate   = $kehadiranRate[$g['cluster']];

            foreach ($hariKerja as $tanggal) {
                // Cek duplikat
                $exists = DB::table('absensi')
                    ->where('guru_id', $guruId)
                    ->where('tanggal', $tanggal)
                    ->exists();
                if ($exists) continue;

                $rand = mt_rand(0, 100) / 100;

                if ($rand <= $rate) {
                    // Hadir (ada kemungkinan terlambat)
                    $terlambat = mt_rand(1, 10) <= 2; // 20% chance terlambat
                    $jamMasuk  = $terlambat
                        ? sprintf('%02d:%02d:00', mt_rand(7, 8), mt_rand(15, 59))
                        : sprintf('%02d:%02d:00', 7, mt_rand(0, 14));
                    $jamKeluar = sprintf('%02d:%02d:00', mt_rand(15, 16), mt_rand(0, 59));

                    DB::table('absensi')->insert([
                        'guru_id'     => $guruId,
                        'tanggal'     => $tanggal,
                        'jam_masuk'   => $jamMasuk,
                        'jam_keluar'  => $jamKeluar,
                        'status'      => $terlambat ? 'terlambat' : 'hadir',
                        'keterangan'  => null,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                } else {
                    // Tidak hadir: distribusi izin/sakit/alpha berdasarkan cluster
                    $statusOptions = $g['cluster'] === 'D'
                        ? ['alpha', 'alpha', 'izin', 'sakit']  // D lebih sering alpha
                        : ['izin', 'sakit', 'izin'];

                    $status = $statusOptions[array_rand($statusOptions)];

                    DB::table('absensi')->insert([
                        'guru_id'    => $guruId,
                        'tanggal'    => $tanggal,
                        'jam_masuk'  => null,
                        'jam_keluar' => null,
                        'status'     => $status,
                        'keterangan' => $status === 'izin' ? 'Keperluan keluarga' :
                                       ($status === 'sakit' ? 'Keterangan dokter' : null),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $totalAbsensi++;
            }
        }

        $this->command->info("   ✅ Total record absensi: {$totalAbsensi}");
    }

    // ─── 4. Prestasi Guru ──────────────────────────────────────────────────
    private function seedPrestasiGuru(array $guruIds): void
    {
        $this->command->newLine();
        $this->command->info('🏆 [4/4] Mengisi prestasi_guru...');

        // Template prestasi per cluster
        $templatePrestasi = [
            'A' => [
                ['nama' => 'Guru Berprestasi Tingkat Kota',      'tingkat' => 'kota',     'kategori' => 'Penghargaan', 'tahun' => 2024, 'status' => 'tervalidasi'],
                ['nama' => 'Sertifikasi Pendidik Profesional',    'tingkat' => 'nasional', 'kategori' => 'Sertifikasi', 'tahun' => 2023, 'status' => 'tervalidasi'],
                ['nama' => 'Pelatihan Kurikulum Merdeka',         'tingkat' => 'provinsi', 'kategori' => 'Pelatihan',   'tahun' => 2024, 'status' => 'tervalidasi'],
            ],
            'B' => [
                ['nama' => 'Pelatihan Metode Pembelajaran Aktif', 'tingkat' => 'kota',     'kategori' => 'Pelatihan',   'tahun' => 2024, 'status' => 'tervalidasi'],
                ['nama' => 'Sertifikat Workshop PTK',             'tingkat' => 'sekolah',  'kategori' => 'Sertifikasi', 'tahun' => 2023, 'status' => 'tervalidasi'],
            ],
            'C' => [
                ['nama' => 'Peserta Webinar Pembelajaran Digital', 'tingkat' => 'sekolah', 'kategori' => 'Pelatihan',   'tahun' => 2024, 'status' => 'tervalidasi'],
            ],
            'D' => [
                // Cluster D tidak punya prestasi (disengaja untuk kontras data)
            ],
        ];

        $totalPrestasi = 0;

        foreach ($this->guruData as $index => $g) {
            if (!isset($guruIds[$index])) continue;
            if (empty($templatePrestasi[$g['cluster']])) continue;

            $guruId = $guruIds[$index];

            foreach ($templatePrestasi[$g['cluster']] as $p) {
                DB::table('prestasi_guru')->insert([
                    'guru_id'        => $guruId,
                    'nama_prestasi'  => $p['nama'],
                    'tingkat'        => $p['tingkat'],
                    'kategori'       => $p['kategori'],
                    'tahun'          => $p['tahun'],
                    'file_bukti'     => null,
                    'status'         => $p['status'],
                    'divalidasi_oleh'=> null,
                    'divalidasi_at'  => $p['status'] === 'tervalidasi' ? now() : null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
                $totalPrestasi++;
            }

            $this->command->info("   ✅ {$g['nama']} [{$g['cluster']}] — " . count($templatePrestasi[$g['cluster']]) . " prestasi");
        }

        $this->command->info("   ✅ Total record prestasi: {$totalPrestasi}");
    }

    // ─── Summary ───────────────────────────────────────────────────────────
    private function printSummary(): void
    {
        $this->command->newLine();
        $this->command->info('══════════════════════════════════════════════════');
        $this->command->info('  ✅  FullDummySeeder selesai!');
        $this->command->info('══════════════════════════════════════════════════');
        $this->command->info('  Guru: ' . count($this->guruData) . ' orang');
        $this->command->info('  Password semua: stqm123');
        $this->command->info('  Clustering: 4 cluster (A/B/C/D) sudah terisi');
        $this->command->info('  Absensi: ~3 bulan hari kerja per guru');
        $this->command->info('  Prestasi: sesuai cluster (D = tidak ada prestasi)');
        $this->command->newLine();
        $this->command->info('  Distribusi cluster:');
        $this->command->info('    A (Sangat Baik)     : 4 guru');
        $this->command->info('    B (Baik)            : 4 guru');
        $this->command->info('    C (Cukup)           : 4 guru');
        $this->command->info('    D (Perlu Pembinaan) : 3 guru');
        $this->command->info('══════════════════════════════════════════════════');
    }
}
