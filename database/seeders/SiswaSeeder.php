<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ── X IPA 1 ──────────────────────────────
            ['nama' => 'Rizky Aditya Putra',      'email' => 'siswa03@stqm.sch.id', 'kelas' => 'X IPA 1'],
            ['nama' => 'Nabila Putri Sari',        'email' => 'siswa04@stqm.sch.id', 'kelas' => 'X IPA 1'],
            ['nama' => 'Farhan Maulana',           'email' => 'siswa05@stqm.sch.id', 'kelas' => 'X IPA 1'],
            ['nama' => 'Aulia Rahma Fitri',        'email' => 'siswa06@stqm.sch.id', 'kelas' => 'X IPA 1'],
            ['nama' => 'Dimas Arya Wicaksono',     'email' => 'siswa07@stqm.sch.id', 'kelas' => 'X IPA 1'],

            // ── X IPA 2 ──────────────────────────────
            ['nama' => 'Salsabila Nur Azizah',    'email' => 'siswa08@stqm.sch.id', 'kelas' => 'X IPA 2'],
            ['nama' => 'Muhammad Fauzi',           'email' => 'siswa09@stqm.sch.id', 'kelas' => 'X IPA 2'],
            ['nama' => 'Indah Permatasari',        'email' => 'siswa10@stqm.sch.id', 'kelas' => 'X IPA 2'],
            ['nama' => 'Kevin Septian Nugraha',    'email' => 'siswa11@stqm.sch.id', 'kelas' => 'X IPA 2'],
            ['nama' => 'Putri Ayu Lestari',        'email' => 'siswa12@stqm.sch.id', 'kelas' => 'X IPA 2'],

            // ── XI IPS 1 ─────────────────────────────
            ['nama' => 'Bagas Dwi Prasetyo',       'email' => 'siswa13@stqm.sch.id', 'kelas' => 'XI IPS 1'],
            ['nama' => 'Mega Wulandari',           'email' => 'siswa14@stqm.sch.id', 'kelas' => 'XI IPS 1'],
            ['nama' => 'Hafidz Ramadhan',          'email' => 'siswa15@stqm.sch.id', 'kelas' => 'XI IPS 1'],
            ['nama' => 'Citra Dewi Anggraini',     'email' => 'siswa16@stqm.sch.id', 'kelas' => 'XI IPS 1'],
            ['nama' => 'Rendra Kusuma',            'email' => 'siswa17@stqm.sch.id', 'kelas' => 'XI IPS 1'],

            // ── XI IPS 2 ─────────────────────────────
            ['nama' => 'Nadia Maharani',           'email' => 'siswa18@stqm.sch.id', 'kelas' => 'XI IPS 2'],
            ['nama' => 'Yoga Pratama Saputra',     'email' => 'siswa19@stqm.sch.id', 'kelas' => 'XI IPS 2'],
            ['nama' => 'Fitria Handayani',         'email' => 'siswa20@stqm.sch.id', 'kelas' => 'XI IPS 2'],
            ['nama' => 'Ilham Nur Hidayat',        'email' => 'siswa21@stqm.sch.id', 'kelas' => 'XI IPS 2'],
            ['nama' => 'Zahra Aulia Putri',        'email' => 'siswa22@stqm.sch.id', 'kelas' => 'XI IPS 2'],
        ];

        foreach ($data as $s) {
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

        $this->command->info('✅ 20 siswa dummy berhasil di-seed.');
    }
}
