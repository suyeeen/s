<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Ubah enum dulu — gabungkan semua nilai lama + baru
        DB::statement("
        ALTER TABLE prestasi_guru
        MODIFY COLUMN kategori ENUM(
            'Sertifikasi',
            'Pelatihan',
            'Penghargaan',
            'Publikasi',
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

        // Step 2: Migrasi data lama ke nilai baru
        DB::statement("UPDATE prestasi_guru SET kategori = 'Sertifikat Pendidik'  WHERE kategori = 'Sertifikasi'");
        DB::statement("UPDATE prestasi_guru SET kategori = 'Pelatihan & Workshop' WHERE kategori = 'Pelatihan'");
        DB::statement("UPDATE prestasi_guru SET kategori = 'Guru Berprestasi'     WHERE kategori = 'Penghargaan'");
        DB::statement("UPDATE prestasi_guru SET kategori = 'Karya Ilmiah'         WHERE kategori = 'Publikasi'");

        // Step 3: Hapus nilai lama dari enum
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
