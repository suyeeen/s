<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kuesioner', function (Blueprint $table) {
            $table->text('kesan_pesan')->nullable()->after('semester')
                ->comment('Kesan dan pesan siswa untuk guru');
        });
    }

    public function down(): void
    {
        Schema::table('kuesioner', function (Blueprint $table) {
            $table->dropColumn('kesan_pesan');
        });
    }
};
