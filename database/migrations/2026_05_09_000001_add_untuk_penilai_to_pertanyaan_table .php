<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->enum('untuk_penilai', ['siswa', 'guru', 'keduanya'])
                ->default('siswa')
                ->after('kategori')
                ->comment('siswa=dinilai siswa, guru=dinilai teman sejawat, keduanya=keduanya');
        });

        // Set semua data lama sebagai untuk siswa (default)
        DB::table('pertanyaan')->update(['untuk_penilai' => 'siswa']);
    }

    public function down(): void
    {
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->dropColumn('untuk_penilai');
        });
    }
};
