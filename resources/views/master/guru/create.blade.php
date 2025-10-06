@extends('layouts.menu')
@section('title') Tambah Guru @endsection
@section('css')
<!-- select 2 -->
<link rel="stylesheet" href="{{url('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Guru Baru</h3>
                    </div>

                    <form method="POST" action="{{ route('master.guru.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nip">NIP</label>
                                        <input type="text" class="form-control form-control-sm" id="nip" name="nip"
                                            placeholder="Masukkan NIP" value="{{ old('nip') }}">
                                        @error('nip') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input type="text" class="form-control form-control-sm" id="nama_lengkap" name="nama_lengkap"
                                            placeholder="Masukkan Nama Lengkap" value="{{ old('nama_lengkap') }}">
                                        @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email (otomatis akun User)</label>
                                        <input type="email" class="form-control form-control-sm" id="email" name="email"
                                            placeholder="Masukkan Email" value="{{ old('email') }}">
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="no_hp">No. HP/WA</label>
                                        <input type="text" class="form-control form-control-sm" id="no_hp" name="no_hp"
                                            placeholder="08xxxx" value="{{ old('no_hp') }}">
                                        @error('no_hp') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                {{-- Kolom Kanan --}}
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" rows="3" class="form-control form-control-sm"
                                            placeholder="Alamat Guru">{{ old('alamat') }}</textarea>
                                        @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="jabatan">Jabatan</label>
                                        <select name="jabatan[]" id="jabatan" class="form-control form-control-sm select2bs4" multiple="multiple" style="width: 100%;">
                                            @foreach($jabatans as $jabatan)
                                                <option value="{{ $jabatan->id }}"
                                                    {{ collect(old('jabatan'))->contains($jabatan->id) ? 'selected' : '' }}>
                                                    {{ $jabatan->nama_jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Pilih lebih dari satu jika guru punya beberapa jabatan</small>
                                        @error('jabatan') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info btn-sm">Simpan</button>
                            <a href="{{ route('master.guru.index') }}" class="btn btn-default btn-sm float-right">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('script')
<script src="{{url('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $(function() {
        // Inisialisasi Select2 untuk multiple jabatan
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>
@endsection
