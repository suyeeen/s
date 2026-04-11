<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestasiGuru extends Model
{
    //
    protected $table = 'prestasi_guru';

    protected $fillable = [
        'guru_id', 'nama_prestasi', 'tingkat', 'kategori',
        'tahun', 'file_bukti', 'status', 'divalidasi_oleh', 'divalidasi_at'
    ];

    protected $casts = ['divalidasi_at' => 'datetime'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh');
    }
}
