<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambah kolom poin berdasarkan tingkat prestasi.
     * Kolom ini di-generate otomatis agar bisa langsung di-query/sum.
     */
    public function up(): void
    {
        Schema::table('prestasi_guru', function (Blueprint $table) {
            $table->unsignedTinyInteger('poin')->default(0)->after('tingkat')
                ->comment('Poin prestasi: sekolah=5, kecamatan=10, kota=20, provinsi=35, nasional=55, internasional=80');
        });

        // Isi nilai poin untuk data yang sudah ada
        DB::statement("
            UPDATE prestasi_guru SET poin = CASE tingkat
                WHEN 'sekolah'       THEN 5
                WHEN 'kecamatan'     THEN 10
                WHEN 'kota'          THEN 20
                WHEN 'provinsi'      THEN 35
                WHEN 'nasional'      THEN 55
                WHEN 'internasional' THEN 80
                ELSE 0
            END
        ");
    }

    public function down(): void
    {
        Schema::table('prestasi_guru', function (Blueprint $table) {
            $table->dropColumn('poin');
        });
    }
};
