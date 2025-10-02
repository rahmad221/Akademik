@extends('layouts.menu')
@section('title','Detail Siswa')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Detail Siswa</h3>
                <a href="{{ route('master.siswa.edit',$siswa->id) }}" class="btn btn-sm btn-warning float-right">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="{{ $siswa->foto ? asset('storage/img_siswa/'.$siswa->foto) : asset('assets/img_siswa/camera.png') }}"
                             alt="Foto Siswa" class="img-fluid rounded" style="max-width:200px;">
                    </div>
                    <div class="col-md-9">
                        <table class="table table-sm table-striped">
                            <tr><th>NIS</th><td>{{ $siswa->nis }}</td></tr>
                            <tr><th>Nama</th><td>{{ $siswa->nama_lengkap }}</td></tr>
                            <tr><th>Email</th><td>{{ $siswa->user->email }}</td></tr>
                            <tr><th>Kelas</th><td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td></tr>
                            <tr><th>Tahun</th><td>{{ $siswa->tahun_pembelajaran }}</td></tr>
                            <tr><th>Jenis Kelamin</th><td>{{ $siswa->jenis_kelamin }}</td></tr>
                            <tr><th>No HP</th><td>{{ $siswa->no_hp }}</td></tr>
                            <tr><th>Alamat</th><td>{{ $siswa->alamat }}</td></tr>
                            <tr><th>Tgl Lahir</th><td>{{ $siswa->tanggal_lahir }}</td></tr>
                            <tr><th>Tempat Lahir</th><td>{{ $siswa->tempat_lahir }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
