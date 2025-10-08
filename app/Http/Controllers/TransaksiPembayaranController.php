<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\JenisPembayaran;
use App\Models\TransaksiPembayaran;
use App\Models\DetailPembayaran;

class TransaksiPembayaranController extends Controller
{
    public function index()
    {
        $transaksi=TransaksiPembayaran::with('siswa.kelas')->get();
        return view('pembayaran.index',compact('transaksi'));
    }

    public function create()
    {
        $jenis = JenisPembayaran::all();
        return view('pembayaran.create', compact('jenis'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $transaksi = TransaksiPembayaran::create([
                'siswa_id' => $request->siswa_id,
                'tanggal_bayar' => $request->tanggal_bayar,
                'total_bayar' => array_sum($request->jumlah)
            ]);

            foreach ($request->jenis_pembayaran_id as $i => $jenis_id) {
                DetailPembayaran::create([
                    'transaksi_id' => $transaksi->id,
                    'jenis_pembayaran_id' => $jenis_id,
                    'periode' => $request->periode[$i] ?? null,
                    'jumlah' => $request->jumlah[$i]
                ]);
            }

            DB::commit();
            return back()->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // 🔎 Pencarian siswa
    public function searchSiswa(Request $request)
    {
        $q = $request->get('q');
        $siswa = Siswa::where('nama_lengkap', 'like', "%$q%")
            ->orWhere('nis', 'like', "%$q%")
            ->limit(10)
            ->get();

        return response()->json($siswa->map(fn($s) => [
            'id' => $s->id,
            'text' => $s->nis . ' - ' . $s->nama_lengkap
        ]));
    }

    // 📜 History Pembayaran
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
                <td>' . date('d/m/Y', strtotime($d->transaksi->tanggal_bayar)) . '</td>
                <td>' . $d->jenisPembayaran->nama_pembayaran . '</td>
                <td>' . ($d->periode ?? '-') . '</td>
                <td>Rp ' . number_format($d->jumlah, 0, ',', '.') . '</td>
            </tr>';
        }

        return $html;
    }

    // 📉 Hitung Tunggakan Siswa
    public function getTunggakan($siswa_id)
    {
        $jenisPembayaran = JenisPembayaran::all();
        $tunggakan = [];
    
        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
    
        foreach ($jenisPembayaran as $jp) {
            $sudahBayar = DetailPembayaran::whereHas('transaksi', function($q) use ($siswa_id) {
                    $q->where('siswa_id', $siswa_id);
                })
                ->where('jenis_pembayaran_id', $jp->id)
                ->sum('jumlah');
    
            if ($jp->tipe_pembayaran === 'bulanan') {
                $totalTagihan = count($bulanList) * $jp->jumlah;
    
                $periodeTerbayar = DetailPembayaran::whereHas('transaksi', function($q) use ($siswa_id) {
                        $q->where('siswa_id', $siswa_id);
                    })
                    ->where('jenis_pembayaran_id', $jp->id)
                    ->pluck('periode')
                    ->filter()
                    ->toArray();
    
                $belumBayar = array_diff($bulanList, $periodeTerbayar);
    
                $tunggakan[] = [
                    'jenis_pembayaran' => $jp->nama_pembayaran,
                    'total_tagihan' => $totalTagihan,
                    'sudah_bayar' => $sudahBayar,
                    'sisa' => max($totalTagihan - $sudahBayar, 0),
                    'belum_bayar_bulan' => array_values($belumBayar)
                ];
            } else {
                $totalTagihan = $jp->jumlah;
    
                $tunggakan[] = [
                    'jenis_pembayaran' => $jp->nama_pembayaran,
                    'total_tagihan' => $totalTagihan,
                    'sudah_bayar' => $sudahBayar,
                    'sisa' => max($totalTagihan - $sudahBayar, 0),
                    'belum_bayar_bulan' => []
                ];
            }
        }
    
        return response()->json($tunggakan);
    }
    

}
