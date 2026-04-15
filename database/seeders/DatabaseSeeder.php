<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ────────────────────────────────────────────────
        User::create([
            'name'     => 'System Administrator',
            'email'    => 'admin@stqm.sch.id',
            'password' => Hash::make('stqm123'),
            'role'     => 'admin',
        ]);

        // ── Kepala Sekolah ────────────────────────────────────────
        User::create([
            'name'     => 'Drs. Wahyu Widodo, M.Pd',
            'email'    => 'kepsek@stqm.sch.id',
            'password' => Hash::make('stqm123'),
            'role'     => 'kepsek',
        ]);

        // ── Guru 1 ────────────────────────────────────────────────
        $user1 = User::create([
            'name'     => 'Ahmad Hidayat, S.Pd',
            'email'    => 'guru01@stqm.sch.id',
            'password' => Hash::make('stqm123'),
            'role'     => 'guru',
        ]);
        Guru::create([
            'user_id'        => $user1->id,
            'nama'           => $user1->name,
            'nip'            => '198005122005011003',
            'mata_pelajaran' => 'Matematika',
            'rfid_uid'       => 'RFID001',
        ]);

        // ── Guru 2 ────────────────────────────────────────────────
        $user2 = User::create([
            'name'     => 'Siti Aminah, M.Pd',
            'email'    => 'guru02@stqm.sch.id',
            'password' => Hash::make('stqm123'),
            'role'     => 'guru',
        ]);
        Guru::create([
            'user_id'        => $user2->id,
            'nama'           => $user2->name,
            'nip'            => '197503212000122001',
            'mata_pelajaran' => 'Bahasa Indonesia',
            'rfid_uid'       => 'RFID002',
        ]);

        // ── Guru 3 ────────────────────────────────────────────────
        $user3 = User::create([
            'name'     => 'Budi Santoso, S.Pd',
            'email'    => 'guru03@stqm.sch.id',
            'password' => Hash::make('stqm123'),
            'role'     => 'guru',
        ]);
        Guru::create([
            'user_id'        => $user3->id,
            'nama'           => $user3->name,
            'nip'            => '198210052010011002',
            'mata_pelajaran' => 'IPA',
            'rfid_uid'       => 'RFID003',
        ]);

        // ── Siswa 1 ────────────────────────────────────────────────
        $siswa1 = User::create([
            'name'     => 'Andi Pratama',
            'email'    => 'siswa01@stqm.sch.id',
            'password' => Hash::make('stqm123'),
            'role'     => 'siswa',
        ]);
        Siswa::create([
            'user_id' => $siswa1->id,
            'nama'    => $siswa1->name,
            'kelas'   => 'X IPA 1',
        ]);

        // ── Siswa 2 ────────────────────────────────────────────────
        $siswa2 = User::create([
            'name'     => 'Dewi Rahayu',
            'email'    => 'siswa02@stqm.sch.id',
            'password' => Hash::make('stqm123'),
            'role'     => 'siswa',
        ]);
        Siswa::create([
            'user_id' => $siswa2->id,
            'nama'    => $siswa2->name,
            'kelas'   => 'X IPA 2',
        ]);

        // ── Seeder lainnya ────────────────────────────────────────
        $this->call([
            PertanyaanSeeder::class,
            SiswaSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('✅ Seeder selesai!');
        $this->command->info('──────────────────────────────────');
        $this->command->info('📧 admin@stqm.sch.id       → admin');
        $this->command->info('📧 kepsek@stqm.sch.id      → kepsek');
        $this->command->info('📧 guru01@stqm.sch.id      → guru');
        $this->command->info('📧 guru02@stqm.sch.id      → guru');
        $this->command->info('📧 guru03@stqm.sch.id      → guru');
        $this->command->info('📧 siswa01@stqm.sch.id     → siswa');
        $this->command->info('📧 siswa02@stqm.sch.id     → siswa');
        $this->command->info('🔑 Password semua akun: stqm123');
        $this->command->info('──────────────────────────────────');
    }
}
