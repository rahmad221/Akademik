<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gurus = Guru::with('jabatans')->get();
        return view('master.guru.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jabatans = Jabatan::all();
        return view('master.guru.create', compact('jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:guru,nip',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mata_pelajaran' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'jabatan' => 'required|array', // bisa multiple
        ]);

        // 1. Buat akun user
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make('password123'), // default password
        ]);

        // Assign role guru
        $user->hasRole('guru');

        // 2. Buat guru
        $guru = Guru::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'nama_lengkap' => $request->nama_lengkap,
            'mata_pelajaran' => $request->mata_pelajaran,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        // 3. Simpan jabatan (many to many)
        $guru->jabatans()->sync($request->jabatan);

        return redirect()->route('master.guru.index')->with('success', 'Guru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guru = Guru::with('jabatans')->findOrFail($id);
        return view('master.guru.show', compact('guru'));
        // return $guru;
    }

    public function edit($id)
    {
        $guru = Guru::with('jabatans')->findOrFail($id);
        $jabatans = Jabatan::all();
        return view('master.guru.edit', compact('guru', 'jabatans'));
    }
    /**
     * Update guru
     */
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $guru->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nip'          => $request->nip,
            'alamat'       => $request->alamat,
            'no_hp'        => $request->no_hp,
        ]);

        // Sinkronisasi jabatan
        $guru->jabatans()->sync($request->jabatan);

        return redirect()->route('master.guru.index')->with('success', 'Data guru berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
