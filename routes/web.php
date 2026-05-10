<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KepalaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\KmeansController;
use App\Http\Controllers\AdminPrestasiController;

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'siswa'  => redirect()->route('siswa.kuesioner'),
            'guru'   => redirect()->route('guru.kuesioner'),
            'kepsek' => redirect()->route('kepala.dashboard'),
            'admin'  => redirect()->route('admin.users.index'),
            default  => redirect()->route('login'),
        };
    }
    return view('welcome');
});

require __DIR__ . '/auth.php';

// ── SISWA ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/kuesioner',         [SiswaController::class, 'index'])->name('kuesioner');
    Route::post('/kuesioner/submit', [SiswaController::class, 'submit'])->name('kuesioner.submit');
});

// ── GURU ──────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/kuesioner',         [GuruController::class, 'kuesioner'])->name('kuesioner');
    Route::post('/kuesioner/submit', [GuruController::class, 'submitKuesioner'])->name('kuesioner.submit');
    Route::get('/profil',            [GuruController::class, 'profil'])->name('profil');
    Route::get('/absensi',           [GuruController::class, 'absensi'])->name('absensi');
    Route::post('/absensi/scan',     [GuruController::class, 'scanRfid'])->name('absensi.scan');
    Route::resource('/prestasi', PrestasiController::class)->only(['index', 'store', 'destroy']);
});

// ── KEPALA SEKOLAH ────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:kepsek'])->prefix('kepala')->name('kepala.')->group(function () {
    Route::get('/dashboard',       [KepalaController::class, 'dashboard'])->name('dashboard');
    Route::get('/evaluasi',        [KepalaController::class, 'evaluasi'])->name('evaluasi');
    Route::get('/guru/{guru}',     [KepalaController::class, 'detailGuru'])->name('guru.detail');
    Route::get('/evaluasi/export', [KepalaController::class, 'export'])->name('evaluasi.export');
});

// ── ADMIN ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/users/import',  [AdminController::class, 'importSiswa'])->name('users.import');
    Route::get('/users/template', [AdminController::class, 'downloadTemplate'])->name('users.template');
    Route::post('/users/bulk-destroy', [AdminController::class, 'bulkDestroy'])->name('users.bulk-destroy');
    Route::resource('/users', AdminController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('/prestasi', [AdminPrestasiController::class, 'index'])->name('prestasi.index');
    Route::patch('/prestasi/{id}/verifikasi', [AdminPrestasiController::class, 'verifikasi'])->name('prestasi.verifikasi');
    Route::patch('/prestasi/{id}/tolak',      [AdminPrestasiController::class, 'tolak'])->name('prestasi.tolak');
    Route::patch('/prestasi/{id}/reset',      [AdminPrestasiController::class, 'reset'])->name('prestasi.reset');
    Route::get('/monitoring',      [AdminController::class, 'monitoring'])->name('monitoring');
    Route::get('/settings',        [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings',       [AdminController::class, 'saveSettings'])->name('settings.save');
    Route::post('/run-clustering', [KmeansController::class, 'run'])->name('clustering.run');
    Route::get('/preview-nilai',   [KmeansController::class, 'preview'])->name('clustering.preview');
});
