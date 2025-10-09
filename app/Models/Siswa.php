<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $fillable = ['user_id', 'nis', 'nama_lengkap', 'tanggal_lahir', 'kelas_id','tahun_pembelajaran','no_hp','jenis_kelamin','foto','alamat','tempat_lahir'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(TransaksiPembayaran::class, 'siswa_id');
    }
}
