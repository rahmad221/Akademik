<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Role;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SiswaController extends Controller
{
    function index()
    {
        $siswa = Siswa::with('user')->get();
        return view('master.siswa.index',compact('siswa'));
    }

    function create()
    {
        $kelas = Kelas::all();
        return view('master.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tahun_pembelajaran' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048', // 2MB
        ]);

        DB::beginTransaction();
        try {
            // 1) buat user (password default dibuat random, bisa direset oleh siswa)
            $defaultPassword = '123456'; // ganti sesuai kebijakan produksi
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($defaultPassword),
            ]);

            // 2) attach role 'siswa' (pastikan role 'siswa' ada di tabel roles)
            $role = Role::where('name', 'siswa')->first();
            if (!$role) {
                // optional: buat role kalau belum ada
                $role = Role::create(['name' => 'siswa']);
            }
            // gunakan sync untuk memastikan hanya 1 role (atau syncWithoutDetaching jika multi-role)
            $user->roles()->sync([$role->id]);

            // 3) upload foto jika ada
            $fotoFilename = null;
            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('img_siswa', 'public'); // public/storage/img_siswa/...
                $fotoFilename = basename($path);
            }

            // 4) simpan data siswa
            $siswa = Siswa::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'nama_lengkap' => $request->nama_lengkap,
                'tanggal_lahir' => $request->tanggal_lahir ?? null,
                'tempat_lahir' => $request->tempat_lahir ?? null,
                'kelas_id' => $request->kelas_id ?? null,
                'tahun_pembelajaran' => $request->tahun_pembelajaran ?? null,
                'jenis_kelamin' => $request->jenis_kelamin ?? null,
                'no_hp' => $request->no_hp ?? null,
                'alamat' => $request->alamat ?? null,
                'foto' => $fotoFilename,
            ]);

            DB::commit();

            // jika mau redirect biasa:
            return redirect()->route('master.siswa.index')->with('success', 'Siswa dan akun user berhasil dibuat.');

            // atau jika API/AJAX, kembalikan JSON:
            // return response()->json(['success' => true, 'data' => $siswa]);

        } catch (Throwable $e) {
            DB::rollBack();

            // hapus file jika sempat terupload
            if (!empty($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            // log error jika perlu
            // \Log::error($e);

            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $siswa = Siswa::with(['user', 'kelas', 'nilai.mapel', 'nilai.jenisNilai', 'pembayaran.detail.jenisPembayaran'])->findOrFail($id);
        return view('master.siswa.show', compact('siswa'));
        // return $siswa->pembayaran->detail->jenisPembayaran;
    }

    public function edit($id)
    {
        $siswa = Siswa::with('user', 'kelas')->findOrFail($id);
        $kelas = Kelas::all();
        return view('master.siswa.edit', compact('siswa','kelas'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $siswa->id,
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'kelas_id' => 'nullable|exists:kelas,id',
            'tahun_pembelajaran' => 'required|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // update user
            $siswa->user->update([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
            ]);

            // handle foto baru
            $fotoFilename = $siswa->foto;
            if ($request->hasFile('foto')) {
                if ($fotoFilename && Storage::disk('public')->exists("img_siswa/$fotoFilename")) {
                    Storage::disk('public')->delete("img_siswa/$fotoFilename");
                }
                $path = $request->file('foto')->store('img_siswa', 'public');
                $fotoFilename = basename($path);
            }

            // update siswa
            $siswa->update([
                'nis' => $request->nis,
                'nama_lengkap' => $request->nama_lengkap,
                'kelas_id' => $request->kelas_id,
                'tahun_pembelajaran' => $request->tahun_pembelajaran,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'foto' => $fotoFilename,
            ]);

            DB::commit();

            return redirect()->route('master.siswa.show',$siswa->id)
                ->with('success','Data siswa berhasil diperbarui.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

}
