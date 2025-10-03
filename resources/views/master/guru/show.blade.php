@extends('layouts.menu')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Detail Guru</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $guru->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>NIP</th>
                    <td>{{ $guru->nip }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $guru->alamat }}</td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>{{ $guru->no_hp }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>
                        @foreach($guru->jabatans as $jab)
                            <span class="badge badge-info">{{ $jab->nama_jabatan }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Email (User)</th>
                    <td>{{ $guru->user->email }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('master.guru.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @permission('edit_guru')
            <a href="{{ route('master.guru.edit', $guru->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            @endpermission
        </div>
    </div>
</div>
@endsection
