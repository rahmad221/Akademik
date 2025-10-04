<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Guru;


class KelasController extends Controller
{
   
    public function index()
    {
        $kelas = Kelas::with('waliKelas')->get();
        $guru = Guru::all();
        return view('master.kelas.index', compact('kelas','guru'));
    }


    public function create()
    {
        // 
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'wali_kelas_id' => 'required|exists:guru,id'
        ]);

        Kelas::create($request->all());
        return redirect()->route('master.kelas.index')->with('success','Data kelas berhasil ditambahkan');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'wali_kelas_id' => 'required|exists:guru,id'
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('master.kelas.index')->with('success','Data kelas berhasil diupdate');
    }


    public function destroy($id)
    {
        Kelas::findOrFail($id)->delete();
        return redirect()->route('master.kelas.index')->with('success','Data kelas berhasil dihapus');
    }
}
