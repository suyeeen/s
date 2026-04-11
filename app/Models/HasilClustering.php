<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilClustering extends Model
{
    //
    protected $table = 'hasil_clustering';

    protected $fillable = [
        'guru_id', 'nilai_pedagogik', 'nilai_profesional',
        'nilai_sosial', 'nilai_kepribadian', 'nilai_rata_rata',
        'cluster', 'label_cluster', 'tahun_ajaran', 'semester', 'tanggal'
    ];

    protected $casts = ['tanggal' => 'date'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // Helper label otomatis dari cluster
    public static function labelDariCluster(string $cluster): string
    {
        return match($cluster) {
            'A' => 'Sangat Baik',
            'B' => 'Baik',
            'C' => 'Cukup',
            'D' => 'Perlu Pembinaan',
            default => '-'
        };
    }
}
