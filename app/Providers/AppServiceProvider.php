<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Inject settings dari cache ke config app
        // Sehingga config('app.tahun_ajaran') di semua controller otomatis terbaca
        try {
            config([
                'app.tahun_ajaran' => Cache::get('stqm_tahun_ajaran', '2024/2025'),
                'app.semester'     => Cache::get('stqm_semester', 'ganjil'),
                'app.rfid_aktif'   => Cache::get('stqm_rfid_aktif', false),
            ]);
        } catch (\Exception $e) {
            config([
                'app.tahun_ajaran' => '2024/2025',
                'app.semester'     => 'ganjil',
                'app.rfid_aktif'   => false,
            ]);
        }
    }
}