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
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->text('teks_pertanyaan');
            $table->enum('kategori', ['pedagogik', 'profesional', 'sosial', 'kepribadian']);
            $table->decimal('bobot', 4, 2)->default(1.00)->comment('Bobot soal untuk perhitungan skor akhir');
            $table->unsignedTinyInteger('urutan')->default(0)->comment('Urutan tampil dalam kuesioner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
