<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Pertanyaan;
use App\Models\Kuesioner;
use App\Models\Jawaban;
use Carbon\Carbon;

/**
 * MasterDummySeeder
 *
 * Satu seeder yang menggabungkan semua kebutuhan data dummy:
 *   1. Akun sistem  — admin & kepala sekolah
 *   2. Guru         — 3 guru utama (DatabaseSeeder lama) + 15 guru dummy
 *   3. Siswa        — 22 siswa dari berbagai kelas
 *   4. Kuesioner    — penilaian peer antar-guru (untuk halaman profil)
 *   5. Clustering   — hasil K-Means yang sudah di-hardcode
 *   6. Absensi      — 3 bulan hari kerja per guru
 *   7. Prestasi     — sesuai cluster (D tidak punya prestasi)
 *
 * Cara pakai:
 *   php artisan db:seed --class=MasterDummySeeder
 *
 * Akun guru yang bisa langsung cek profil:
 *   Email: dewi.rahayu@stqm.sch.id  | Password: stqm123
 *   (Buka /guru/profil setelah login)
 */
class MasterDummySeeder extends Seeder
{
    // ── Periode aktif ─────────────────────────────────────────────────────
    private string $tahunAjaran       = '2024/2025';
    private string $semester          = 'ganjil';
    private string $tanggalClustering = '2025-01-15';

    // ── Data guru lengkap (gabungan DatabaseSeeder + GuruDummySeeder + FullDummySeeder) ──
    private array $guruData = [
        // ─── Guru utama (dari DatabaseSeeder lama) ───────────────────────
        [
            'nama' => 'Ahmad Hidayat, S.Pd',
            'nip' => '198005122005011003',
            'mapel' => 'Matematika',
            'email' => 'guru01@stqm.sch.id',
            'rfid' => 'RFID001',
            'cluster' => 'B',
            'label_cluster' => 'Baik',
            'pedagogik' => 3.20,
            'profesional' => 3.10,
            'sosial' => 3.30,
            'kepribadian' => 3.15,
        ],
        [
            'nama' => 'Siti Aminah, M.Pd',
            'nip' => '197503212000122001',
            'mapel' => 'Bahasa Indonesia',
            'email' => 'guru02@stqm.sch.id',
            'rfid' => 'RFID002',
            'cluster' => 'A',
            'label_cluster' => 'Sangat Baik',
            'pedagogik' => 3.70,
            'profesional' => 3.80,
            'sosial' => 3.90,
            'kepribadian' => 3.85,
        ],
        [
            'nama' => 'Budi Santoso, S.Pd',
            'nip' => '198210052010011002',
            'mapel' => 'IPA',
            'email' => 'guru03@stqm.sch.id',
            'rfid' => 'RFID003',
            'cluster' => 'B',
            'label_cluster' => 'Baik',
            'pedagogik' => 3.00,
            'profesional' => 3.25,
            'sosial' => 3.10,
            'kepribadian' => 3.40,
        ],

        // ─── Cluster A – Sangat Baik ──────────────────────────────────────
        [
            'nama' => 'Ahmad Fauzi, S.Pd',
            'nip' => '198001012005011001',
            'mapel' => 'Matematika',
            'email' => 'guru10@stqm.sch.id',
            'cluster' => 'A',
            'label_cluster' => 'Sangat Baik',
            'pedagogik' => 3.85,
            'profesional' => 3.90,
            'sosial' => 3.80,
            'kepribadian' => 3.75,
        ],
        [
            // ← Guru target untuk demo halaman profil
            'nama' => 'Dewi Rahayu, M.Pd',
            'nip' => '198202022006022002',
            'mapel' => 'Bahasa Indonesia',
            'email' => 'guru11@stqm.sch.id',
            'cluster' => 'A',
            'label_cluster' => 'Sangat Baik',
            'pedagogik' => 3.70,
            'profesional' => 3.80,
            'sosial' => 3.90,
            'kepribadian' => 3.85,
        ],
        [
            'nama' => 'Hendra Kusuma, S.Kom',
            'nip' => '198303032007031003',
            'mapel' => 'TIK',
            'email' => 'guru12@stqm.sch.id',
            'cluster' => 'A',
            'label_cluster' => 'Sangat Baik',
            'pedagogik' => 3.60,
            'profesional' => 3.95,
            'sosial' => 3.70,
            'kepribadian' => 3.65,
        ],
        [
            'nama' => 'Rina Wulandari, S.Si',
            'nip' => '198404042008042004',
            'mapel' => 'IPA',
            'email' => 'guru13@stqm.sch.id',
            'cluster' => 'A',
            'label_cluster' => 'Sangat Baik',
            'pedagogik' => 3.75,
            'profesional' => 3.70,
            'sosial' => 3.65,
            'kepribadian' => 3.80,
        ],

        // ─── Cluster B – Baik ─────────────────────────────────────────────
        [
            'nama' => 'Budi Setiawan, S.Pd',
            'nip' => '198505052009051005',
            'mapel' => 'IPS',
            'email' => 'guru14@stqm.sch.id',
            'cluster' => 'B',
            'label_cluster' => 'Baik',
            'pedagogik' => 3.20,
            'profesional' => 3.10,
            'sosial' => 3.30,
            'kepribadian' => 3.15,
        ],
        [
            'nama' => 'Sari Indah, M.Pd',
            'nip' => '198606062010062006',
            'mapel' => 'PKN',
            'email' => 'guru15@stqm.sch.id',
            'cluster' => 'B',
            'label_cluster' => 'Baik',
            'pedagogik' => 3.00,
            'profesional' => 3.25,
            'sosial' => 3.10,
            'kepribadian' => 3.40,
        ],
        [
            'nama' => 'Doni Prasetyo, S.Pd',
            'nip' => '198707072011071007',
            'mapel' => 'Olahraga',
            'email' => 'guru16@stqm.sch.id',
            'cluster' => 'B',
            'label_cluster' => 'Baik',
            'pedagogik' => 3.10,
            'profesional' => 2.90,
            'sosial' => 3.35,
            'kepribadian' => 3.20,
        ],
        [
            'nama' => 'Fitri Handayani, S.Pd',
            'nip' => '198808082012082008',
            'mapel' => 'Seni Budaya',
            'email' => 'guru17@stqm.sch.id',
            'cluster' => 'B',
            'label_cluster' => 'Baik',
            'pedagogik' => 2.95,
            'profesional' => 3.05,
            'sosial' => 3.00,
            'kepribadian' => 3.10,
        ],

        // ─── Cluster C – Cukup ────────────────────────────────────────────
        [
            'nama' => 'Eko Santoso, S.Pd',
            'nip' => '198909092013091009',
            'mapel' => 'Agama',
            'email' => 'guru18@stqm.sch.id',
            'cluster' => 'C',
            'label_cluster' => 'Cukup',
            'pedagogik' => 2.50,
            'profesional' => 2.40,
            'sosial' => 2.60,
            'kepribadian' => 2.55,
        ],
        [
            'nama' => 'Lina Marlina, M.Pd',
            'nip' => '199010102014102010',
            'mapel' => 'Bahasa Inggris',
            'email' => 'guru19@stqm.sch.id',
            'cluster' => 'C',
            'label_cluster' => 'Cukup',
            'pedagogik' => 2.35,
            'profesional' => 2.55,
            'sosial' => 2.45,
            'kepribadian' => 2.40,
        ],
        [
            'nama' => 'Wahyu Hidayat, S.Pd',
            'nip' => '199111112015111011',
            'mapel' => 'Fisika',
            'email' => 'guru20@stqm.sch.id',
            'cluster' => 'C',
            'label_cluster' => 'Cukup',
            'pedagogik' => 2.60,
            'profesional' => 2.30,
            'sosial' => 2.50,
            'kepribadian' => 2.45,
        ],
        [
            'nama' => 'Nurul Hasanah, S.Pd',
            'nip' => '199212122016122012',
            'mapel' => 'Kimia',
            'email' => 'guru21@stqm.sch.id',
            'cluster' => 'C',
            'label_cluster' => 'Cukup',
            'pedagogik' => 2.45,
            'profesional' => 2.65,
            'sosial' => 2.35,
            'kepribadian' => 2.55,
        ],

        // ─── Cluster D – Perlu Pembinaan ──────────────────────────────────
        [
            'nama' => 'Reza Firmansyah, S.Pd',
            'nip' => '199313132017131013',
            'mapel' => 'Biologi',
            'email' => 'guru22@stqm.sch.id',
            'cluster' => 'D',
            'label_cluster' => 'Perlu Pembinaan',
            'pedagogik' => 1.80,
            'profesional' => 1.70,
            'sosial' => 1.90,
            'kepribadian' => 1.75,
        ],
        [
            'nama' => 'Mega Putri, M.Pd',
            'nip' => '199414142018142014',
            'mapel' => 'Ekonomi',
            'email' => 'guru23@stqm.sch.id',
            'cluster' => 'D',
            'label_cluster' => 'Perlu Pembinaan',
            'pedagogik' => 1.65,
            'profesional' => 1.85,
            'sosial' => 1.70,
            'kepribadian' => 1.80,
        ],
        [
            'nama' => 'Arif Budiman, S.Pd',
            'nip' => '199515152019151015',
            'mapel' => 'Geografi',
            'email' => 'guru24@stqm.sch.id',
            'cluster' => 'D',
            'label_cluster' => 'Perlu Pembinaan',
            'pedagogik' => 1.90,
            'profesional' => 1.60,
            'sosial' => 1.75,
            'kepribadian' => 1.85,
        ],
    ];

    // ── Data siswa ────────────────────────────────────────────────────────
    private array $siswaData = [
        // Dari DatabaseSeeder lama
        ['nama' => 'Andi Pratama',           'email' => 'siswa01@stqm.sch.id', 'kelas' => 'X IPA 1'],
        ['nama' => 'Dewi Rahayu',            'email' => 'siswa02@stqm.sch.id', 'kelas' => 'X IPA 2'],
        // Dari SiswaSeeder
        ['nama' => 'Rizky Aditya Putra',     'email' => 'siswa03@stqm.sch.id', 'kelas' => 'X IPA 1'],
        ['nama' => 'Nabila Putri Sari',      'email' => 'siswa04@stqm.sch.id', 'kelas' => 'X IPA 1'],
        ['nama' => 'Farhan Maulana',         'email' => 'siswa05@stqm.sch.id', 'kelas' => 'X IPA 1'],
        ['nama' => 'Aulia Rahma Fitri',      'email' => 'siswa06@stqm.sch.id', 'kelas' => 'X IPA 1'],
        ['nama' => 'Dimas Arya Wicaksono',   'email' => 'siswa07@stqm.sch.id', 'kelas' => 'X IPA 1'],
        ['nama' => 'Salsabila Nur Azizah',   'email' => 'siswa08@stqm.sch.id', 'kelas' => 'X IPA 2'],
        ['nama' => 'Muhammad Fauzi',         'email' => 'siswa09@stqm.sch.id', 'kelas' => 'X IPA 2'],
        ['nama' => 'Indah Permatasari',      'email' => 'siswa10@stqm.sch.id', 'kelas' => 'X IPA 2'],
        ['nama' => 'Kevin Septian Nugraha',  'email' => 'siswa11@stqm.sch.id', 'kelas' => 'X IPA 2'],
        ['nama' => 'Putri Ayu Lestari',      'email' => 'siswa12@stqm.sch.id', 'kelas' => 'X IPA 2'],
        ['nama' => 'Bagas Dwi Prasetyo',     'email' => 'siswa13@stqm.sch.id', 'kelas' => 'XI IPS 1'],
        ['nama' => 'Mega Wulandari',         'email' => 'siswa14@stqm.sch.id', 'kelas' => 'XI IPS 1'],
        ['nama' => 'Hafidz Ramadhan',        'email' => 'siswa15@stqm.sch.id', 'kelas' => 'XI IPS 1'],
        ['nama' => 'Citra Dewi Anggraini',   'email' => 'siswa16@stqm.sch.id', 'kelas' => 'XI IPS 1'],
        ['nama' => 'Rendra Kusuma',          'email' => 'siswa17@stqm.sch.id', 'kelas' => 'XI IPS 1'],
        ['nama' => 'Nadia Maharani',         'email' => 'siswa18@stqm.sch.id', 'kelas' => 'XI IPS 2'],
        ['nama' => 'Yoga Pratama Saputra',   'email' => 'siswa19@stqm.sch.id', 'kelas' => 'XI IPS 2'],
        ['nama' => 'Fitria Handayani',       'email' => 'siswa20@stqm.sch.id', 'kelas' => 'XI IPS 2'],
        ['nama' => 'Ilham Nur Hidayat',      'email' => 'siswa21@stqm.sch.id', 'kelas' => 'XI IPS 2'],
        ['nama' => 'Zahra Aulia Putri',      'email' => 'siswa22@stqm.sch.id', 'kelas' => 'XI IPS 2'],
    ];

    // ═════════════════════════════════════════════════════════════════════
    // MAIN
    // ═════════════════════════════════════════════════════════════════════
    public function run(): void
    {
        // Set cache periode supaya GuruController membacanya dengan benar
        Cache::put('stqm_tahun_ajaran', $this->tahunAjaran);
        Cache::put('stqm_semester', $this->semester);
        Cache::put('stqm_maks_penilaian', 3);

        $this->line('');
        $this->line('╔══════════════════════════════════════════════╗');
        $this->line('║       MasterDummySeeder — mulai...           ║');
        $this->line('╚══════════════════════════════════════════════╝');

        DB::transaction(function () {
            $this->seedAkunSistem();
            $guruMap = $this->seedGuru();
            $this->seedSiswa();
            $this->seedKuesionerProfil($guruMap);
            $this->seedHasilClustering($guruMap);
            $this->seedAbsensi($guruMap);
            $this->seedPrestasiGuru($guruMap);
        });

        $this->printSummary();
    }

    // ═════════════════════════════════════════════════════════════════════
    // 1. AKUN SISTEM (Admin + Kepala Sekolah)
    // ═════════════════════════════════════════════════════════════════════
    private function seedAkunSistem(): void
    {
        $this->line('');
        $this->line('👤 [1/7] Akun sistem...');

        $akun = [
            ['name' => 'System Administrator',      'email' => 'admin@stqm.sch.id',  'role' => 'admin'],
            ['name' => 'Drs. Wahyu Widodo, M.Pd',   'email' => 'kepsek@stqm.sch.id', 'role' => 'kepsek'],
        ];

        foreach ($akun as $a) {
            User::firstOrCreate(
                ['email' => $a['email']],
                ['name' => $a['name'], 'password' => Hash::make('stqm123'), 'role' => $a['role']]
            );
            $this->line("   ✅ {$a['role']}: {$a['email']}");
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    // 2. GURU
    // ═════════════════════════════════════════════════════════════════════
    private function seedGuru(): array
    {
        $this->line('');
        $this->line('🧑‍🏫 [2/7] Guru (' . count($this->guruData) . ' orang)...');

        // $guruMap[index] = Guru model
        $guruMap = [];

        foreach ($this->guruData as $i => $g) {
            // Cari berdasarkan NIP (unique) agar tidak bentrok
            $guru = Guru::where('nip', $g['nip'])->first();

            if (!$guru) {
                $user = User::firstOrCreate(
                    ['email' => $g['email']],
                    [
                        'name'     => $g['nama'],
                        'password' => Hash::make('stqm123'),
                        'role'     => 'guru',
                    ]
                );

                $guru = Guru::create([
                    'user_id'        => $user->id,
                    'nama'           => $g['nama'],
                    'nip'            => $g['nip'],
                    'mata_pelajaran' => $g['mapel'],
                    'rfid_uid'       => $g['rfid'] ?? null,
                ]);

                $this->line("   ✅ {$g['nama']} [{$g['cluster']}]");
            } else {
                $this->line("   ⚠️  Skip {$g['nama']} — NIP sudah ada (id={$guru->id})");
            }

            $guruMap[$i] = $guru;
        }

        return $guruMap;
    }

    // ═════════════════════════════════════════════════════════════════════
    // 3. SISWA
    // ═════════════════════════════════════════════════════════════════════
    private function seedSiswa(): void
    {
        $this->line('');
        $this->line('🎓 [3/7] Siswa (' . count($this->siswaData) . ' orang)...');

        foreach ($this->siswaData as $s) {
            if (User::where('email', $s['email'])->exists()) {
                $this->line("   ⚠️  Skip {$s['email']} — sudah ada");
                continue;
            }

            $user = User::create([
                'name'     => $s['nama'],
                'email'    => $s['email'],
                'password' => Hash::make('stqm123'),
                'role'     => 'siswa',
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nama'    => $s['nama'],
                'kelas'   => $s['kelas'],
            ]);
        }

        $this->line('   ✅ Semua siswa selesai');
    }

    // ═════════════════════════════════════════════════════════════════════
    // 4. KUESIONER PEER (untuk halaman /guru/profil)
    //    Target: guru index 4 (Dewi Rahayu, guru11@stqm.sch.id)
    //    Penilai: 6 guru lainnya
    // ═════════════════════════════════════════════════════════════════════
    private function seedKuesionerProfil(array $guruMap): void
    {
        $this->line('');
        $this->line('📝 [4/7] Kuesioner peer (profil guru)...');

        // Guru target = index 4 (Dewi Rahayu)
        $guruTarget = $guruMap[4] ?? null;
        if (!$guruTarget) {
            $this->line('   ⚠️  Guru target tidak ditemukan, skip.');
            return;
        }

        // Ambil semua pertanyaan (harus sudah di-seed oleh PertanyaanSeeder)
        $pertanyaan = Pertanyaan::orderBy('urutan')->get();
        if ($pertanyaan->isEmpty()) {
            $this->line('   ⚠️  Tabel pertanyaan kosong — jalankan PertanyaanSeeder dulu.');
            return;
        }

        // Indeks guru yang jadi penilai (selain guru target sendiri)
        $indeksPenilai = [0, 2, 3, 5, 6, 7, 8];

        // Skor per penilai: [pedagogik, kepribadian, sosial, profesional]
        $skorDummy = [
            [4.8, 4.5, 4.6, 4.7],
            [4.2, 4.0, 4.3, 4.5],
            [3.8, 4.2, 3.9, 4.1],
            [4.5, 4.8, 4.4, 4.6],
            [3.5, 3.8, 4.0, 3.7],
            [4.0, 4.3, 4.2, 4.4],
            [4.6, 4.7, 4.5, 4.8],
        ];

        $kesanPesanDummy = [
            'Bu Dewi adalah guru yang sangat inspiratif. Cara beliau menjelaskan materi selalu membuat siswa mudah paham dan tertarik belajar Bahasa Indonesia.',
            'Sangat profesional dan selalu siap membantu rekan guru. Kolaborasi dengan beliau selalu produktif dan menyenangkan.',
            'Bu Dewi memiliki dedikasi tinggi terhadap profesinya. Beliau selalu hadir tepat waktu dan mempersiapkan materi dengan matang.',
            'Guru yang sabar dan penuh empati. Murid-murid sangat menyukai cara mengajar beliau yang kreatif dan interaktif.',
            'Sangat menguasai bidangnya dan terus belajar mengikuti perkembangan. Semoga terus memotivasi kami semua.',
            'Komunikasi beliau sangat terbuka dan mau mendengar masukan. Senang berkolaborasi dalam program sekolah.',
            'Bu Dewi adalah panutan bagi guru-guru lain. Sikap profesional dan kepeduliannya terhadap sesama sangat terlihat.',
        ];

        // Map kategori dari nama kolom ke label
        $kategoriMap = [
            'pedagogik'   => 'pedagogik',
            'kepribadian' => 'kepribadian',
            'sosial'      => 'sosial',
            'profesional' => 'profesional',
        ];

        $tanggalBase = now()->subDays(14);

        foreach ($indeksPenilai as $urutan => $idxGuru) {
            $penilai = $guruMap[$idxGuru] ?? null;
            if (!$penilai) continue;

            // Skip jika sudah ada
            $sudahAda = Kuesioner::where('guru_id', $guruTarget->id)
                ->where('penilai_guru_id', $penilai->id)
                ->where('tahun_ajaran', $this->tahunAjaran)
                ->where('semester', $this->semester)
                ->exists();

            if ($sudahAda) {
                $this->line("   ⚠️  Skip kuesioner dari {$penilai->nama} — sudah ada");
                continue;
            }

            $tanggal  = $tanggalBase->copy()->addDays($urutan * 2)->toDateString();
            $skorPenilai = $skorDummy[$urutan] ?? [4.0, 4.0, 4.0, 4.0];

            $kuesioner = Kuesioner::create([
                'guru_id'         => $guruTarget->id,
                'penilai_guru_id' => $penilai->id,
                'tipe'            => 'guru',
                'tanggal'         => $tanggal,
                'tahun_ajaran'    => $this->tahunAjaran,
                'semester'        => $this->semester,
                'kesan_pesan'     => $kesanPesanDummy[$urutan] ?? null,
            ]);

            // Jawaban per pertanyaan
            foreach ($pertanyaan as $pertIdx => $p) {
                $avgKat = match ($p->kategori) {
                    'pedagogik'   => $skorPenilai[0],
                    'kepribadian' => $skorPenilai[1],
                    'sosial'      => $skorPenilai[2],
                    'profesional' => $skorPenilai[3],
                    default       => 3.5,
                };

                // Variasi kecil antar butir dalam kategori yang sama
                $variasi = (($pertIdx % 3) - 1) * 0.3;
                $nilai   = (int) round(max(1, min(5, $avgKat + $variasi)));

                Jawaban::create([
                    'kuesioner_id'  => $kuesioner->id,
                    'pertanyaan_id' => $p->id,
                    'nilai'         => $nilai,
                ]);
            }

            $this->line("   ✅ Kuesioner: {$penilai->nama} → {$guruTarget->nama} [{$tanggal}]");
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    // 5. HASIL CLUSTERING
    // ═════════════════════════════════════════════════════════════════════
    private function seedHasilClustering(array $guruMap): void
    {
        $this->line('');
        $this->line('📊 [5/7] Hasil clustering...');

        foreach ($this->guruData as $i => $g) {
            $guru = $guruMap[$i] ?? null;
            if (!$guru) continue;

            $exists = DB::table('hasil_clustering')
                ->where('guru_id', $guru->id)
                ->where('tahun_ajaran', $this->tahunAjaran)
                ->where('semester', $this->semester)
                ->exists();

            if ($exists) {
                $this->line("   ⚠️  Skip clustering {$g['nama']} — sudah ada");
                continue;
            }

            $rataRata = round(($g['pedagogik'] + $g['profesional'] + $g['sosial'] + $g['kepribadian']) / 4, 2);

            DB::table('hasil_clustering')->insert([
                'guru_id'          => $guru->id,
                'nilai_pedagogik'  => $g['pedagogik'],
                'nilai_profesional' => $g['profesional'],
                'nilai_sosial'     => $g['sosial'],
                'nilai_kepribadian' => $g['kepribadian'],
                'nilai_rata_rata'  => $rataRata,
                'cluster'          => $g['cluster'],
                'label_cluster'    => $g['label_cluster'],
                'tahun_ajaran'     => $this->tahunAjaran,
                'semester'         => $this->semester,
                'tanggal'          => $this->tanggalClustering,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            $this->line("   ✅ {$g['nama']} → Cluster {$g['cluster']} (rata: {$rataRata})");
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    // 6. ABSENSI (3 bulan hari kerja)
    // ═════════════════════════════════════════════════════════════════════
    private function seedAbsensi(array $guruMap): void
    {
        $this->line('');
        $this->line('📅 [6/7] Absensi (3 bulan hari kerja)...');

        // Tingkat kehadiran per cluster
        $kehadiranRate = ['A' => 0.95, 'B' => 0.85, 'C' => 0.75, 'D' => 0.60];

        // Generate hari kerja 3 bulan terakhir
        $hariKerja = [];
        $current   = Carbon::now()->subMonths(3)->startOfMonth();
        $akhir     = Carbon::now()->endOfMonth();
        while ($current->lte($akhir)) {
            if (!$current->isWeekend()) {
                $hariKerja[] = $current->format('Y-m-d');
            }
            $current->addDay();
        }

        $total = 0;

        foreach ($this->guruData as $i => $g) {
            $guru = $guruMap[$i] ?? null;
            if (!$guru) continue;

            $rate = $kehadiranRate[$g['cluster']] ?? 0.80;

            foreach ($hariKerja as $tanggal) {
                $exists = DB::table('absensi')
                    ->where('guru_id', $guru->id)
                    ->where('tanggal', $tanggal)
                    ->exists();
                if ($exists) continue;

                $rand = mt_rand(0, 100) / 100;

                if ($rand <= $rate) {
                    $terlambat = mt_rand(1, 10) <= 2;
                    DB::table('absensi')->insert([
                        'guru_id'    => $guru->id,
                        'tanggal'    => $tanggal,
                        'jam_masuk'  => $terlambat
                            ? sprintf('%02d:%02d:00', mt_rand(7, 8), mt_rand(15, 59))
                            : sprintf('07:%02d:00', mt_rand(0, 14)),
                        'jam_keluar' => sprintf('%02d:%02d:00', mt_rand(15, 16), mt_rand(0, 59)),
                        'status'     => $terlambat ? 'terlambat' : 'hadir',
                        'keterangan' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $statusPool = $g['cluster'] === 'D'
                        ? ['alpha', 'alpha', 'izin', 'sakit']
                        : ['izin', 'sakit', 'izin'];
                    $status = $statusPool[array_rand($statusPool)];
                    DB::table('absensi')->insert([
                        'guru_id'    => $guru->id,
                        'tanggal'    => $tanggal,
                        'jam_masuk'  => null,
                        'jam_keluar' => null,
                        'status'     => $status,
                        'keterangan' => match ($status) {
                            'izin'  => 'Keperluan keluarga',
                            'sakit' => 'Keterangan dokter',
                            default => null,
                        },
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $total++;
            }
        }

        $this->line("   ✅ Total record absensi: {$total}");
    }

    // ═════════════════════════════════════════════════════════════════════
    // 7. PRESTASI GURU
    // ═════════════════════════════════════════════════════════════════════
    private function seedPrestasiGuru(array $guruMap): void
    {
        $this->line('');
        $this->line('🏆 [7/7] Prestasi guru...');

        // Nilai enum kategori sesuai migration terbaru (update_kategori_enum_in_prestasi_guru_table):
        // 'Sertifikat Pendidik', 'Pelatihan & Workshop', 'Karya Ilmiah', 'Guru Berprestasi',
        // 'Inovasi Pembelajaran', 'Pengabdian Masyarakat', 'Organisasi Profesi', 'Lainnya'
        $template = [
            'A' => [
                ['nama' => 'Guru Berprestasi Tingkat Kota',      'tingkat' => 'kota',     'kategori' => 'Guru Berprestasi',    'tahun' => 2024],
                ['nama' => 'Sertifikasi Pendidik Profesional',    'tingkat' => 'nasional', 'kategori' => 'Sertifikat Pendidik', 'tahun' => 2023],
                ['nama' => 'Pelatihan Kurikulum Merdeka',         'tingkat' => 'provinsi', 'kategori' => 'Pelatihan & Workshop', 'tahun' => 2024],
            ],
            'B' => [
                ['nama' => 'Pelatihan Metode Pembelajaran Aktif', 'tingkat' => 'kota',     'kategori' => 'Pelatihan & Workshop', 'tahun' => 2024],
                ['nama' => 'Sertifikat Workshop PTK',             'tingkat' => 'sekolah',  'kategori' => 'Sertifikat Pendidik', 'tahun' => 2023],
            ],
            'C' => [
                ['nama' => 'Peserta Webinar Pembelajaran Digital', 'tingkat' => 'sekolah', 'kategori' => 'Pelatihan & Workshop', 'tahun' => 2024],
            ],
            'D' => [], // Disengaja kosong untuk kontras data
        ];

        $total = 0;

        foreach ($this->guruData as $i => $g) {
            $guru = $guruMap[$i] ?? null;
            if (!$guru || empty($template[$g['cluster']])) continue;

            foreach ($template[$g['cluster']] as $p) {
                DB::table('prestasi_guru')->insert([
                    'guru_id'         => $guru->id,
                    'nama_prestasi'   => $p['nama'],
                    'tingkat'         => $p['tingkat'],
                    'kategori'        => $p['kategori'],
                    'tahun'           => $p['tahun'],
                    'file_bukti'      => null,
                    'status'          => 'tervalidasi',
                    'divalidasi_oleh' => null,
                    'divalidasi_at'   => now(),
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
                $total++;
            }

            $jumlah = count($template[$g['cluster']]);
            $this->line("   ✅ {$g['nama']} [{$g['cluster']}] — {$jumlah} prestasi");
        }

        $this->line("   ✅ Total record prestasi: {$total}");
    }

    // ═════════════════════════════════════════════════════════════════════
    // HELPER & SUMMARY
    // ═════════════════════════════════════════════════════════════════════
    private function line(string $text): void
    {
        $this->command->line($text);
    }

    private function printSummary(): void
    {
        $this->line('');
        $this->line('╔══════════════════════════════════════════════════╗');
        $this->line('║  ✅  MasterDummySeeder selesai!                   ║');
        $this->line('╠══════════════════════════════════════════════════╣');
        $this->line('║  Akun sistem:                                     ║');
        $this->line('║    admin@stqm.sch.id        → admin               ║');
        $this->line('║    kepsek@stqm.sch.id       → kepala sekolah      ║');
        $this->line('║                                                   ║');
        $this->line('║  Demo halaman profil:                             ║');
        $this->line('║    guru11@stqm.sch.id       → Dewi Rahayu, M.Pd  ║');
        $this->line('║    Buka: /guru/profil                             ║');
        $this->line('║                                                   ║');
        $this->line('║  Password semua akun: stqm123                     ║');
        $this->line('║                                                   ║');
        $this->line('║  Guru: 18 orang  |  Siswa: 22 orang              ║');
        $this->line('║  Cluster A: 5 guru  |  B: 7 guru                 ║');
        $this->line('║  Cluster C: 4 guru  |  D: 3 guru                 ║');
        $this->line('╚══════════════════════════════════════════════════╝');
    }
}
