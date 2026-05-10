<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SiswaImport implements
    ToCollection,
    WithHeadingRow,
    WithChunkReading
{
    public int   $berhasil  = 0;
    public int   $duplikat  = 0;
    public int   $gagal     = 0;
    public array $logGagal  = [];

    public function chunkSize(): int
    {
        return 100;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $nomorBaris = $index + 2;

            $nama     = trim($row['nama']     ?? '');
            $email    = trim($row['email']    ?? '');
            $kelas    = trim($row['kelas']    ?? '');
            $password = trim($row['password'] ?? '');

            $errors = [];
            if (empty($nama))  $errors[] = 'nama kosong';
            if (empty($email)) {
                $errors[] = 'email kosong';
            } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'format email tidak valid';
            }
            if (empty($kelas))        $errors[] = 'kelas kosong';
            if (strlen($password) < 6) $errors[] = 'password minimal 6 karakter';

            if (! empty($errors)) {
                $this->gagal++;
                $this->logGagal[] = [
                    'baris'  => $nomorBaris,
                    'nama'   => $nama ?: '(kosong)',
                    'email'  => $email ?: '(kosong)',
                    'alasan' => implode(', ', $errors),
                ];
                continue;
            }

            if (User::where('email', $email)->exists()) {
                $this->duplikat++;
                $this->logGagal[] = [
                    'baris'  => $nomorBaris,
                    'nama'   => $nama,
                    'email'  => $email,
                    'alasan' => 'email sudah terdaftar (duplikat)',
                ];
                continue;
            }

            \DB::transaction(function () use ($nama, $email, $kelas, $password) {
                $user = User::create([
                    'name'     => $nama,
                    'email'    => $email,
                    'password' => Hash::make($password),
                    'role'     => 'siswa',
                ]);
                Siswa::create([
                    'user_id' => $user->id,
                    'nama'    => $nama,
                    'kelas'   => $kelas,
                ]);
            });

            $this->berhasil++;
        }
    }
}
