<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuesioner_id')->constrained('kuesioner')->onDelete('cascade');
            $table->foreignId('pertanyaan_id')->constrained('pertanyaan')->onDelete('cascade');
            $table->unsignedTinyInteger('nilai')->comment('Skala Likert 1–5');
            $table->timestamps();

            // Satu kuesioner tidak boleh jawab pertanyaan yang sama dua kali
            $table->unique(['kuesioner_id', 'pertanyaan_id']);

            // Constraint nilai 1–5 ditangani di level aplikasi (Validation)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};
