<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ubah kolom kategori dari ENUM menjadi VARCHAR(150)
     * agar nilai "Lainnya" bisa disimpan sebagai teks bebas.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE prestasi_guru
            MODIFY COLUMN kategori VARCHAR(150) NOT NULL DEFAULT 'Lainnya'
        ");
    }

    public function down(): void
    {
        // Nilai di luar daftar enum akan diset ke 'Lainnya' sebelum rollback
        DB::statement("
            UPDATE prestasi_guru
            SET kategori = 'Lainnya'
            WHERE kategori NOT IN (
                'Sertifikat Pendidik',
                'Pelatihan & Workshop',
                'Karya Ilmiah',
                'Guru Berprestasi',
                'Inovasi Pembelajaran',
                'Pengabdian Masyarakat',
                'Organisasi Profesi',
                'Lainnya'
            )
        ");

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
};
