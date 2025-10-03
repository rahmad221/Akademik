@extends('layouts.menu')
@section('title') Edit Guru @endsection
@section('css')
<!-- select 2 -->
<link rel="stylesheet" href="{{url('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-warning">
            <h3 class="card-title">Edit Guru</h3>
        </div>
        <form action="{{ route('master.guru.update', $guru->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <span for="nama_lengkap">Nama Lengkap</span>
                    <input type="text" name="nama_lengkap" class="form-control form-control-sm" 
                           value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" required>

                    <span for="nip">NIP</span>
                    <input type="text" name="nip" class="form-control form-control-sm" 
                           value="{{ old('nip', $guru->nip) }}">

                    <span for="alamat">Alamat</span>
                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $guru->alamat) }}</textarea>

                    <span for="no_hp">No HP</span>
                    <input type="text" name="no_hp" class="form-control form-control-sm" 
                           value="{{ old('no_hp', $guru->no_hp) }}">

                    <span for="jabatan">Jabatan</span>
                    <select name="jabatan[]" class="form-control form-control-sm select2bs4" multiple>
                    @foreach($jabatans as $j)
        <option value="{{ $j->id }}" 
            {{ $guru->jabatans->contains($j->id) ? 'selected' : '' }}>
            {{ $j->nama_jabatan }}
        </option>
    @endforeach
                    </select>
                    <small class="text-muted">Bisa pilih lebih dari satu</small>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('master.guru.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
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