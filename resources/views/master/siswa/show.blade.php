@extends('layouts.menu')
@section('title','Detail Siswa')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h4 class="card-title">Detail Siswa</h4>
                @permission('edit_siswa')
                <a href="{{ route('master.siswa.edit',$siswa->id) }}" class="btn btn-xs btn-warning float-right">Edit</a>
                @endpermission
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

                {{-- TAB MENU --}}
                <ul class="nav nav-tabs mt-4" id="siswaTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="nilai-tab" data-toggle="tab" href="#nilai" role="tab">History Nilai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="bayar-tab" data-toggle="tab" href="#bayar" role="tab">History Pembayaran</a>
                    </li>
                </ul>

                {{-- TAB CONTENT --}}
                <div class="tab-content mt-3" id="siswaTabContent">

                    {{-- HISTORY NILAI --}}
                    <div class="tab-pane fade show active" id="nilai" role="tabpanel">
                        <table class="table table-bordered table-striped table-sm">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Jenis Nilai</th>
                                    <th>Nilai</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Input</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa->nilai as $key => $n)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $n->mapel->nama_mapel ?? '-' }}</td>
                                        <td>{{ $n->jenisNilai->nama_jenis ?? '-' }}</td>
                                        <td>{{ $n->nilai ?? '-' }}</td>
                                        <td>{{ $n->keterangan ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($n->tanggal_input)->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center">Belum ada data nilai</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- HISTORY PEMBAYARAN --}}
                    <div class="tab-pane fade" id="bayar" role="tabpanel">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($siswa->pembayaran as $key => $b)
<tr>
    <td>{{ $key + 1 }}</td>
    <td>
        <ul class="mb-0">
            @foreach($b->detail as $d)
                <li>{{ $d->jenisPembayaran->nama_pembayaran ?? '-' }}</li>
            @endforeach
        </ul>
    </td>
    <td>{{ \Carbon\Carbon::parse($b->tanggal_bayar)->format('d/m/Y') }}</td>
    <td>
        <ul class="mb-0">
            @foreach($b->detail as $d)
                <li>Rp {{ number_format($d->jumlah, 0, ',', '.') }}</li>
            @endforeach
        </ul>
    </td>
    <td>
        <ul class="mb-0">
            @foreach($b->detail as $d)
                <li>{{ $d->periode ?? '-' }}</li>
            @endforeach
        </ul>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">Belum ada data pembayaran</td>
</tr>
@endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
