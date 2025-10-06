<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'kategori',
        'kkm',
        'guru_id',
    ];

    // Relasi ke Guru (opsional)
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // Relasi ke Nilai
    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}
