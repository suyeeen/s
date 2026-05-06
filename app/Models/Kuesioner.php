<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    protected $table = 'kuesioner';

    protected $fillable = [
        'guru_id',
        'siswa_id',
        'penilai_guru_id',
        'tipe',
        'tanggal',
        'tahun_ajaran',
        'semester',
        'kesan_pesan'
    ];

    protected $casts = ['tanggal' => 'date'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function penilaiGuru()
    {
        return $this->belongsTo(Guru::class, 'penilai_guru_id');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
}
