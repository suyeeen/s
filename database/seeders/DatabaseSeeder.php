<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder — entry point utama
 *
 * Urutan eksekusi:
 *   1. PertanyaanSeeder  → 25 butir soal (Permendiknas No.16/2007)
 *   2. MasterDummySeeder → semua user, guru, siswa, kuesioner,
 *                          clustering, absensi, prestasi
 *
 * Cara pakai:
 *   php artisan migrate:fresh --seed          ← full reset + seed
 *   php artisan db:seed                       ← seed ke DB yang sudah ada
 *   php artisan db:seed --class=MasterDummySeeder  ← seed dummy saja
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PertanyaanSeeder::class,
            MasterDummySeeder::class,
        ]);
    }
}
