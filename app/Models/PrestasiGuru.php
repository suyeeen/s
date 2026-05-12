<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestasiGuru extends Model
{
    protected $table = 'prestasi_guru';

    protected $fillable = [
        'guru_id',
        'nama_prestasi',
        'tingkat',
        'poin',
        'kategori',
        'tahun',
        'file_bukti',
        'status',
        'divalidasi_oleh',
        'divalidasi_at',
    ];

    protected $casts = [
        'divalidasi_at' => 'datetime',
    ];

    /**
     * Bobot poin per tingkat prestasi.
     */
    public static function bobotTingkat(): array
    {
        return [
            'sekolah'       => 5,
            'kecamatan'     => 10,
            'kota'          => 20,
            'provinsi'      => 35,
            'nasional'      => 55,
            'internasional' => 80,
        ];
    }

    /**
     * Set otomatis poin saat tingkat diisi.
     */
    public function setTingkatAttribute(string $value): void
    {
        $this->attributes['tingkat'] = $value;
        $this->attributes['poin']    = self::bobotTingkat()[$value] ?? 0;
    }

    // Relasi ke tabel guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    // Relasi ke user yang memvalidasi
    public function validator()
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh');
    }
}
