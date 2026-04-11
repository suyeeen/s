<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    //
    protected $table = 'absensi';

    protected $fillable = [
        'guru_id', 'tanggal', 'jam_masuk',
        'jam_keluar', 'status', 'keterangan', 'rfid_uid'
    ];

    protected $casts = ['tanggal' => 'date'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // Scope filter bulan
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                     ->whereYear('tanggal', now()->year);
    }
}
