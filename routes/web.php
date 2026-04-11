<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KepalaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\KmeansController;

// ── Default redirect setelah login ───────────────────────────────────────
Route::get('/', function () {
    if (!auth()->check()) return redirect()->route('login');
    return match (auth()->user()->role) {
        'siswa'  => redirect()->route('siswa.kuesioner'),
        'guru'   => redirect()->route('guru.kuesioner'),       // ✅ diperbaiki
        'kepsek' => redirect()->route('kepala.dashboard'),
        'admin'  => redirect()->route('admin.users.index'),    // ✅ diperbaiki
        default  => redirect()->route('login'),
    };
});

// ── Auth routes (dari Breeze) ─────────────────────────────────────────────
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
    Route::resource('/users', AdminController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('/monitoring',    [AdminController::class, 'monitoring'])->name('monitoring');
    Route::get('/settings',      [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings',     [AdminController::class, 'saveSettings'])->name('settings.save');
    Route::post('/run-clustering', [KmeansController::class, 'run'])->name('clustering.run');
});
