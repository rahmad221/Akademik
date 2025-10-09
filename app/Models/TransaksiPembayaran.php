<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPembayaran extends Model
{
    use HasFactory;
    protected $table = 'transaksi_pembayaran';
    protected $fillable = ['siswa_id','tanggal_bayar','total_bayar'];

    public function siswa() {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function detail() {
        return $this->hasMany(DetailPembayaran::class, 'transaksi_id');
    }
    
}
