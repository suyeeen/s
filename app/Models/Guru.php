<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    //
    protected $table = 'guru';

    protected $fillable = ['user_id', 'nama', 'nip', 'mata_pelajaran', 'rfid_uid'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kuesioner()
    {
        return $this->hasMany(Kuesioner::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function prestasi()
    {
        return $this->hasMany(PrestasiGuru::class);
    }

    public function hasilClustering()
    {
        return $this->hasMany(HasilClustering::class);
    }

    public function clusterTerakhir()
    {
        return $this->hasOne(HasilClustering::class)->latestOfMany();
    }
}
