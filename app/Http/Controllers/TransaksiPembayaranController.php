<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\JenisPembayaran;
use App\Models\TransaksiPembayaran;
use App\Models\DetailPembayaran;

class TransaksiPembayaranController extends Controller
{
    public function index()
    {
        return view('pembayaran.index');
    }

    function create()
    {
        $jenis = JenisPembayaran::all();
        return view('pembayaran.create',compact('jenis')); 
    }

    public function searchSiswa(Request $request)
    {
        $q = $request->get('q');
        $siswa = Siswa::where('nama_lengkap', 'like', "%$q%")
                    ->orWhere('nis', 'like', "%$q%")
                    ->limit(10)->get();

        $data = [];
        foreach($siswa as $s){
            $data[] = [
                'id' => $s->id,
                'text' => $s->nis . ' - ' . $s->nama_lengkap
            ];
        }
        return response()->json($data);
    }

    public function getHistory($siswa_id)
    {
        $history = TransaksiPembayaran::with('detail.jenisPembayaran')
                    ->where('siswa_id',$siswa_id)->get();

        return view('pembayaran.transaksi.history', compact('history'))->render();
    }

}
