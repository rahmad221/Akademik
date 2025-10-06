<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $fillable = [
        'siswa_id',
        'jenis_nilai_id',
        'mapel_id',
        'nilai',
        'keterangan',
        'tanggal_input',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jenisNilai()
    {
        return $this->belongsTo(JenisNilai::class);
    }
}
