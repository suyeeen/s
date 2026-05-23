<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Drop foreign key guru_id dulu (pakai nama constraint MySQL)
        // agar unique index absensi_guru_id_tanggal_unique bisa di-drop
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
        });

        // Step 2: Sekarang aman drop unique index
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropUnique('absensi_guru_id_tanggal_unique');
        });

        // Step 3: Tambah kolom baru + buat ulang foreign key guru_id + tambah unique baru
        Schema::table('absensi', function (Blueprint $table) {
            $table->unsignedTinyInteger('bulan')->nullable()->after('tanggal')
                ->comment('Bulan rekap (1-12)');
            $table->unsignedSmallInteger('tahun')->nullable()->after('bulan')
                ->comment('Tahun rekap');

            $table->unsignedSmallInteger('jumlah_hadir')->default(0)->after('tahun');
            $table->unsignedSmallInteger('jumlah_izin')->default(0)->after('jumlah_hadir');
            $table->unsignedSmallInteger('jumlah_sakit')->default(0)->after('jumlah_izin');
            $table->unsignedSmallInteger('jumlah_alpha')->default(0)->after('jumlah_sakit');
            $table->unsignedSmallInteger('jumlah_terlambat')->default(0)->after('jumlah_alpha');
            $table->unsignedSmallInteger('total_hari_kerja')->default(0)->after('jumlah_terlambat');

            $table->boolean('diinput_admin')->default(false)->after('total_hari_kerja');
            $table->unsignedBigInteger('admin_id')->nullable()->after('diinput_admin');

            // Buat ulang foreign key guru_id
            $table->foreign('guru_id')->references('id')->on('guru')->cascadeOnDelete();
            // Tambah foreign key admin_id
            $table->foreign('admin_id')->references('id')->on('users')->nullOnDelete();

            // Unique baru: satu rekap per guru per bulan per tahun
            $table->unique(['guru_id', 'bulan', 'tahun'], 'unique_absensi_per_bulan');
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropForeign(['admin_id']);
            $table->dropUnique('unique_absensi_per_bulan');
            $table->dropColumn([
                'bulan',
                'tahun',
                'jumlah_hadir',
                'jumlah_izin',
                'jumlah_sakit',
                'jumlah_alpha',
                'jumlah_terlambat',
                'total_hari_kerja',
                'diinput_admin',
                'admin_id',
            ]);
            // Buat ulang kondisi semula
            $table->foreign('guru_id')->references('id')->on('guru')->cascadeOnDelete();
            $table->unique(['guru_id', 'tanggal']);
        });
    }
};
