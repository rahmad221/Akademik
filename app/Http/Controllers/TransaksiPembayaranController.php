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

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $transaksi = TransaksiPembayaran::create([
                'siswa_id' => $request->siswa_id,
                'tanggal_bayar' => $request->tanggal_bayar,
                'total' => array_sum($request->jumlah)
            ]);

            foreach($request->jenis_pembayaran_id as $i => $jenis_id){
                DetailPembayaran::create([
                    'transaksi_id' => $transaksi->id,
                    'jenis_pembayaran_id' => $jenis_id,
                    'periode' => $request->periode[$i] ?? null,
                    'jumlah' => $request->jumlah[$i]
                ]);
            }

            DB::commit();
            return back()->with('success', 'Transaksi berhasil disimpan.');
        } catch(\Exception $e){
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    // 📉 Hitung tunggakan siswa
    public function getTunggakan($siswa_id)
    {
        // ambil semua jenis pembayaran
        $jenisPembayaran = JenisPembayaran::all();

        $tunggakan = [];
        foreach ($jenisPembayaran as $jp) {
            // total pembayaran yang sudah dilakukan siswa untuk jenis ini
            $sudahBayar = DetailPembayaran::whereHas('transaksi', function($q) use ($siswa_id) {
                $q->where('siswa_id', $siswa_id);
            })->where('jenis_pembayaran_id', $jp->id)->sum('jumlah');

            $totalTagihan = $jp->jumlah_default;

            if ($sudahBayar < $totalTagihan) {
                $tunggakan[] = [
                    'jenis_pembayaran' => $jp->nama_pembayaran,
                    'total_tagihan' => $totalTagihan,
                    'sudah_bayar' => $sudahBayar,
                    'sisa' => $totalTagihan - $sudahBayar
                ];
            }
        }

        return response()->json($tunggakan);
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
        $data = DetailPembayaran::with('transaksi', 'jenisPembayaran')
            ->whereHas('transaksi', fn($q) => $q->where('siswa_id', $siswa_id))
            ->orderByDesc('id')
            ->get();

        if ($data->isEmpty()) {
            return '<tr><td colspan="4" class="text-center text-muted">Belum ada pembayaran.</td></tr>';
        }

        $html = '';
        foreach ($data as $d) {
            $html .= '<tr>
                <td>'.date('d/m/Y', strtotime($d->transaksi->tanggal_bayar)).'</td>
                <td>'.$d->jenisPembayaran->nama_pembayaran.'</td>
                <td>'.($d->periode ?? '-').'</td>
                <td>Rp '.number_format($d->jumlah,0,',','.').'</td>
            </tr>';
        }

        return $html;
    }

}
