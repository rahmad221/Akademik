<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembayaran extends Model
{
    use HasFactory;
    protected $table = 'detail_pembayaran';
    protected $fillable = ['transaksi_id','jenis_pembayaran_id','periode','jumlah'];

    public function jenisPembayaran() {
        return $this->belongsTo(JenisPembayaran::class, 'jenis_pembayaran_id');
    }
}
