<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    //
    protected $table = 'pertanyaan';

    protected $fillable = ['teks_pertanyaan', 'kategori', 'bobot', 'urutan'];

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }

    // Scope filter per kategori
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori)->orderBy('urutan');
    }
}
