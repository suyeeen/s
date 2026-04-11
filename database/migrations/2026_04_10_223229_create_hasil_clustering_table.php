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
        Schema::create('hasil_clustering', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');

            // Nilai rata-rata per kompetensi (hasil agregasi dari tabel jawaban)
            $table->decimal('nilai_pedagogik',  4, 2)->default(0);
            $table->decimal('nilai_profesional', 4, 2)->default(0);
            $table->decimal('nilai_sosial',      4, 2)->default(0);
            $table->decimal('nilai_kepribadian', 4, 2)->default(0);
            $table->decimal('nilai_rata_rata',   4, 2)->default(0)->comment('Rata-rata ke-4 kompetensi');

            // Hasil K-Means
            $table->enum('cluster', ['A', 'B', 'C', 'D'])->comment('A=Sangat Baik, B=Baik, C=Cukup, D=Perlu Pembinaan');
            $table->string('label_cluster', 50)->comment('Label teks cluster, misal: Sangat Baik');

            // Metadata clustering
            $table->string('tahun_ajaran', 10)->default('2024/2025');
            $table->enum('semester', ['ganjil', 'genap'])->default('ganjil');
            $table->date('tanggal')->comment('Tanggal clustering dijalankan');
            $table->timestamps();

            // Satu guru satu hasil per semester
            $table->unique(['guru_id', 'tahun_ajaran', 'semester'], 'unique_clustering_per_semester');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_clustering');
    }
};
