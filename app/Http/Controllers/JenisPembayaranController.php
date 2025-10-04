<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPembayaran;

class JenisPembayaranController extends Controller
{
    public function index()
    {
        $data = JenisPembayaran::all();
        return view('master.jenis.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembayaran' => 'required|string|max:100',
            'jumlah' => 'required|numeric',
        ]);

        JenisPembayaran::create($request->all());
        return redirect()->back()->with('success','Jenis pembayaran berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pembayaran' => 'required|string|max:100',
            'jumlah' => 'required|numeric',
        ]);

        $data = JenisPembayaran::findOrFail($id);
        $data->update($request->all());
        return redirect()->back()->with('success','Jenis pembayaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        JenisPembayaran::findOrFail($id)->delete();
        return redirect()->back()->with('success','Jenis pembayaran berhasil dihapus');
    }
}
