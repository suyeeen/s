<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prestasi_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');
            $table->string('nama_prestasi');
            $table->enum('tingkat', ['sekolah', 'kecamatan', 'kota', 'provinsi', 'nasional', 'internasional'])
                ->default('sekolah');
            $table->enum('kategori', [
                'Sertifikat Pendidik',
                'Pelatihan/Workshop',
                'Karya Ilmiah',
                'Guru Berprestasi',
                'Inovasi Pembelajaran',
                'Pengabdian Masyarakat',
                'Organisasi Profesi',
                'Lainnya',
            ])->default('Lainnya');
            $table->year('tahun');
            $table->string('file_bukti')->nullable()->comment('Path file di storage/app/public/prestasi');
            $table->enum('status', ['menunggu', 'tervalidasi', 'ditolak'])->default('menunggu');
            $table->foreignId('divalidasi_oleh')->nullable()->constrained('users')->onDelete('set null')
                ->comment('ID user (admin/kepsek) yang memvalidasi');
            $table->timestamp('divalidasi_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi_guru');
    }
};
