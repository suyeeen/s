<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Expand enum kategori agar mendukung kategori khusus guru teman sejawat (MP1)
        DB::statement("
            ALTER TABLE pertanyaan
            MODIFY COLUMN kategori
            ENUM('pedagogik','profesional','sosial','kepribadian','perilaku_harian','hubungan_sejawat','profesional_guru')
            NOT NULL
        ");
    }

    public function down(): void
    {
        // Kembalikan ke enum semula (hati-hati: data dengan nilai baru akan hilang)
        DB::statement("
            ALTER TABLE pertanyaan
            MODIFY COLUMN kategori
            ENUM('pedagogik','profesional','sosial','kepribadian')
            NOT NULL
        ");
    }
};
