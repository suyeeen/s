<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Akun default untuk development ────────────────────────────────────
        $users = [
            ['name' => 'System Administrator', 'email' => 'admin@stqm.sch.id',   'role' => 'admin'],
            ['name' => 'Drs. Wahyu Widodo, M.Pd', 'email' => 'kepsek@stqm.sch.id', 'role' => 'kepsek'],
            ['name' => 'Ahmad Hidayat, S.Pd',  'email' => 'guru01@stqm.sch.id',  'role' => 'guru'],
            ['name' => 'Siti Aminah, M.Pd',    'email' => 'guru02@stqm.sch.id',  'role' => 'guru'],
            ['name' => 'Budi Santoso',          'email' => 'siswa01@stqm.sch.id', 'role' => 'siswa'],
        ];

        foreach ($users as $u) {
            User::create([
                'name'     => $u['name'],
                'email'    => $u['email'],
                'password' => Hash::make('stqm123'),
                'role'     => $u['role'],
            ]);
        }

        // ── Seeder lainnya ────────────────────────────────────────────────────
        $this->call([
            PertanyaanSeeder::class,
        ]);

        $this->command->info('✅ DatabaseSeeder selesai. Password default semua akun: stqm123');
    }
}
