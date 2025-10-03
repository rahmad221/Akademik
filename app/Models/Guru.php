<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'guru';
    protected $fillable = ['user_id', 'nip', 'nama_lengkap', 'mata_pelajaran','alamat','no_hp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }

    public function jabatans()
    {
        return $this->belongsToMany(Jabatan::class, 'guru_jabatan');
    }
}
