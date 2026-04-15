<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;

class GuruDummySeeder extends Seeder
{
    public function run(): void
    {
        $guruList = [
            // ── Calon Cluster A (nilai tinggi) ────────────────────────────────
            ['nama' => 'Ahmad Fauzi, S.Pd',       'nip' => '198001012005011001', 'mapel' => 'Matematika',      'email' => 'guru10@stqm.sch.id'],
            ['nama' => 'Dewi Rahayu, M.Pd',        'nip' => '198202022006022002', 'mapel' => 'Bahasa Indonesia', 'email' => 'guru11@stqm.sch.id'],
            ['nama' => 'Hendra Kusuma, S.Kom',     'nip' => '198303032007031003', 'mapel' => 'TIK',             'email' => 'guru12@stqm.sch.id'],
            ['nama' => 'Rina Wulandari, S.Si',     'nip' => '198404042008042004', 'mapel' => 'IPA',             'email' => 'guru13@stqm.sch.id'],

            // ── Calon Cluster B (nilai menengah atas) ─────────────────────────
            ['nama' => 'Budi Setiawan, S.Pd',      'nip' => '198505052009051005', 'mapel' => 'IPS',             'email' => 'guru14@stqm.sch.id'],
            ['nama' => 'Sari Indah, M.Pd',         'nip' => '198606062010062006', 'mapel' => 'PKN',             'email' => 'guru15@stqm.sch.id'],
            ['nama' => 'Doni Prasetyo, S.Pd',      'nip' => '198707072011071007', 'mapel' => 'Olahraga',        'email' => 'guru16@stqm.sch.id'],
            ['nama' => 'Fitri Handayani, S.Pd',    'nip' => '198808082012082008', 'mapel' => 'Seni Budaya',     'email' => 'guru17@stqm.sch.id'],

            // ── Calon Cluster C (nilai menengah bawah) ────────────────────────
            ['nama' => 'Eko Santoso, S.Pd',        'nip' => '198909092013091009', 'mapel' => 'Agama',           'email' => 'guru18@stqm.sch.id'],
            ['nama' => 'Lina Marlina, M.Pd',       'nip' => '199010102014102010', 'mapel' => 'Bahasa Inggris',  'email' => 'guru19@stqm.sch.id'],
            ['nama' => 'Wahyu Hidayat, S.Pd',      'nip' => '199111112015111011', 'mapel' => 'Fisika',          'email' => 'guru20@stqm.sch.id'],
            ['nama' => 'Nurul Hasanah, S.Pd',      'nip' => '199212122016122012', 'mapel' => 'Kimia',           'email' => 'guru21@stqm.sch.id'],

            // ── Calon Cluster D (nilai rendah) ────────────────────────────────
            ['nama' => 'Reza Firmansyah, S.Pd',    'nip' => '199313132017131013', 'mapel' => 'Biologi',         'email' => 'guru22@stqm.sch.id'],
            ['nama' => 'Mega Putri, M.Pd',         'nip' => '199414142018142014', 'mapel' => 'Ekonomi',         'email' => 'guru23@stqm.sch.id'],
            ['nama' => 'Arif Budiman, S.Pd',       'nip' => '199515152019151015', 'mapel' => 'Geografi',        'email' => 'guru24@stqm.sch.id'],
        ];

        foreach ($guruList as $g) {
            // Cek apakah email sudah ada
            if (User::where('email', $g['email'])->exists()) {
                $this->command->warn("⚠️  Skip {$g['email']} — sudah ada.");
                continue;
            }

            $user = User::create([
                'name'     => $g['nama'],
                'email'    => $g['email'],
                'password' => Hash::make('stqm123'),
                'role'     => 'guru',
            ]);

            Guru::create([
                'user_id'        => $user->id,
                'nama'           => $g['nama'],
                'nip'            => $g['nip'],
                'mata_pelajaran' => $g['mapel'],
            ]);

            $this->command->info("✅ Guru {$g['nama']} ({$g['mapel']}) dibuat.");
        }

        $this->command->newLine();
        $this->command->info('═══════════════════════════════════════════');
        $this->command->info('  Total guru dummy: ' . count($guruList) . ' orang');
        $this->command->info('  Password semua: stqm123');
        $this->command->info('═══════════════════════════════════════════');
        $this->command->newLine();
        $this->command->info('📋 Langkah selanjutnya:');
        $this->command->info('  1. Login sebagai admin');
        $this->command->info('  2. Tambahkan siswa lewat Manajemen Pengguna');
        $this->command->info('  3. Login sebagai siswa dan isi kuesioner');
        $this->command->info('  4. Jalankan K-Means dari halaman Monitoring');
    }
}
