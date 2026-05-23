<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'guru_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan',
        'rfid_uid',
        // Kolom baru untuk rekap admin
        'bulan',
        'tahun',
        'jumlah_hadir',
        'jumlah_izin',
        'jumlah_sakit',
        'jumlah_alpha',
        'jumlah_terlambat',
        'total_hari_kerja',
        'diinput_admin',
        'admin_id',
    ];

    protected $casts = [
        'tanggal'       => 'date',
        'diinput_admin' => 'boolean',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Scope: rekap yang diinput admin
    public function scopeRekapAdmin($query)
    {
        return $query->where('diinput_admin', true);
    }

    // Scope filter bulan ini (untuk absensi RFID lama)
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year);
    }

    /**
     * Hitung persentase kehadiran dari rekap admin.
     * Kehadiran = hadir + terlambat (tetap dihitung hadir meskipun terlambat)
     */
    public function getPersenHadirAttribute(): float
    {
        if ($this->total_hari_kerja <= 0) return 0.0;
        $hadirEfektif = $this->jumlah_hadir + $this->jumlah_terlambat;
        return round($hadirEfektif / $this->total_hari_kerja * 100, 2);
    }

    /**
     * Hitung rata-rata persentase kehadiran guru dari semua rekap admin.
     */
    public static function rataPersenHadir(int $guruId): float
    {
        $rekap = static::where('guru_id', $guruId)
            ->where('diinput_admin', true)
            ->where('total_hari_kerja', '>', 0)
            ->get();

        if ($rekap->isEmpty()) return 0.0;

        $total = $rekap->sum(fn($r) => $r->jumlah_hadir + $r->jumlah_terlambat);
        $hari  = $rekap->sum('total_hari_kerja');

        return $hari > 0 ? round($total / $hari * 100, 2) : 0.0;
    }

    public static function rekapTerakhir(int $guruId): ?self
    {
        return static::where('guru_id', $guruId)
            ->where('diinput_admin', true)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();
    }
}
