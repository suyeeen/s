<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuesioner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade')
                  ->comment('Guru yang dinilai');
            $table->foreignId('siswa_id')->nullable()->constrained('siswa')->onDelete('set null')
                  ->comment('Diisi jika penilai adalah siswa');
            $table->foreignId('penilai_guru_id')->nullable()->constrained('guru')->onDelete('set null')
                  ->comment('Diisi jika penilai adalah guru lain (self-assessment atau peer)');
            $table->enum('tipe', ['siswa', 'guru'])->comment('siswa = dinilai siswa, guru = self-assessment');
            $table->date('tanggal');
            $table->string('tahun_ajaran', 10)->default('2024/2025');
            $table->enum('semester', ['ganjil', 'genap'])->default('ganjil');
            $table->timestamps();

            // Satu penilai hanya bisa mengisi kuesioner satu kali per guru per semester
            $table->unique(['guru_id', 'siswa_id', 'tahun_ajaran', 'semester'], 'unique_kuesioner_siswa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuesioner');
    }
};
