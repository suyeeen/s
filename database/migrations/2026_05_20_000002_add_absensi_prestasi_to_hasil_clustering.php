<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_clustering', function (Blueprint $table) {
            $table->decimal('persen_absensi', 5, 2)->default(0)
                ->after('nilai_rata_rata')
                ->comment('Persentase kehadiran guru (0-100)');
            $table->unsignedSmallInteger('poin_prestasi')->default(0)
                ->after('persen_absensi')
                ->comment('Total poin prestasi tervalidasi');
            $table->decimal('nilai_akhir', 5, 2)->default(0)
                ->after('poin_prestasi')
                ->comment('Nilai akhir gabungan kuesioner+absensi+prestasi (0-100)');
        });
    }

    public function down(): void
    {
        Schema::table('hasil_clustering', function (Blueprint $table) {
            $table->dropColumn(['persen_absensi', 'poin_prestasi', 'nilai_akhir']);
        });
    }
};
