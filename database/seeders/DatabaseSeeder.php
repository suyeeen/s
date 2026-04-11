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
        // Admin
        User::create([
            'name'     => 'System Administrator',
            'email'    => 'admin@stqm.sch.id',
            'password' => Hash::make('stqm123'),
            'role'     => 'admin',
        ]);

        // Kepsek
        User::create([
            'name'     => 'Drs. Wahyu Widodo, M.Pd',
            'email'    => 'kepsek@stqm.sch.id',
            'password' => Hash::make('stqm123'),
            'role'     => 'kepsek',
        ]);

        // Guru 1
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

        // Guru 2
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

        // Siswa
        $user3 = User::create([
            'name'     => 'wowok sawit',
            'email'    => 'siswa01@stqm.sch.id',
            'password' => Hash::make('stqm123'),
            'role'     => 'siswa',
        ]);
        Siswa::create([
            'user_id' => $user3->id,
            'nama'    => $user3->name,
            'kelas'   => 'X IPA 1',
        ]);

        // Seeder lainnya
        $this->call([
            PertanyaanSeeder::class,
        ]);

        $this->command->info('✅ Seeder selesai. Password semua akun: stqm123');
    }
}
