<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update data lama agar tidak conflict dengan enum baru
        DB::statement("UPDATE prestasi_guru SET kategori = 'Sertifikat Pendidik'    WHERE kategori = 'Sertifikasi'");
        DB::statement("UPDATE prestasi_guru SET kategori = 'Pelatihan & Workshop'   WHERE kategori = 'Pelatihan'");
        DB::statement("UPDATE prestasi_guru SET kategori = 'Guru Berprestasi'       WHERE kategori = 'Penghargaan'");
        DB::statement("UPDATE prestasi_guru SET kategori = 'Karya Ilmiah'           WHERE kategori = 'Publikasi'");

        // Update enum kolom kategori
        DB::statement("
            ALTER TABLE prestasi_guru
            MODIFY COLUMN kategori ENUM(
                'Sertifikat Pendidik',
                'Pelatihan & Workshop',
                'Karya Ilmiah',
                'Guru Berprestasi',
                'Inovasi Pembelajaran',
                'Pengabdian Masyarakat',
                'Organisasi Profesi',
                'Lainnya'
            ) NOT NULL DEFAULT 'Lainnya'
        ");
    }

    public function down(): void
    {
        // Kembalikan ke enum lama
        DB::statement("UPDATE prestasi_guru SET kategori = 'Lainnya' WHERE kategori NOT IN ('Sertifikasi','Pelatihan','Penghargaan','Publikasi','Lainnya')");

        DB::statement("
            ALTER TABLE prestasi_guru
            MODIFY COLUMN kategori ENUM(
                'Sertifikasi',
                'Pelatihan',
                'Penghargaan',
                'Publikasi',
                'Lainnya'
            ) NOT NULL DEFAULT 'Lainnya'
        ");
    }
};
