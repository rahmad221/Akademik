@extends('layouts.menu')

@section('title', 'Siswa Baru')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Siswa Baru</h3>
                    </div>

                    <form method="POST" action="{{ route('master.siswa.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">

                                <!-- Kolom Foto -->
                                <div class="col-md-3">
                                    <div class="card card-primary card-outline pb-1">
                                        <div class="card-body box-profile text-center">
                                            
                                            <!-- Preview Gambar -->
                                            <img class="profile-user-img img-fluid"
                                                 id="profile-img-preview"
                                                 src="{{ url('assets/img_siswa/camera.png') }}"
                                                 alt="Foto Siswa"
                                                 style="width: 100%; height: auto; object-fit: cover;">

                                            <div class="form-group mt-2">
                                            <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="foto" name="foto"
                                                        onchange="previewImage(event)">
                                                    <label class="custom-file-label" for="customFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom Data Siswa -->
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="nis">NIS</label>
                                            <input type="text" id="nis" name="nis" class="form-control form-control-sm"
                                                   placeholder="241108035431" value="{{ old('nis') }}">

                                            <label for="nama_lengkap" class="mt-2">Nama Lengkap</label>
                                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control form-control-sm"
                                                   placeholder="Kevin Alfarisi" value="{{ old('nama_lengkap') }}">

                                            <label for="jenis_kelamin" class="mt-2">Jenis Kelamin</label>
                                            <select class="form-control form-control-sm" name="jenis_kelamin" id="jenis_kelamin">
                                                <option value="">Pilih</option>
                                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>

                                            <label for="tahun_pembelajaran" class="mt-2">Tahun Pembelajaran</label>
                                            <select class="form-control form-control-sm" name="tahun_pembelajaran" id="tahun_pembelajaran">
                                                @php
                                                    $currentYear = date('Y');
                                                    $startYear = $currentYear - 5;
                                                @endphp
                                                @for ($year = $currentYear; $year >= $startYear; $year--)
                                                    @php $nextYear = $year + 1; @endphp
                                                    <option value="{{ $year }}/{{ $nextYear }}"
                                                        {{ old('tahun_pembelajaran') == "$year/$nextYear" ? 'selected' : '' }}>
                                                        {{ $year }}/{{ $nextYear }}
                                                    </option>
                                                @endfor
                                            </select>

                                            <label for="alamat" class="mt-2">Alamat</label>
                                            <textarea name="alamat" id="alamat" rows="3"
                                                      class="form-control form-control-sm"
                                                      placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                                        </div>

                                        <div class="col-6 form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" id="tempat_lahir" name="tempat_lahir"
                                                   class="form-control form-control-sm"
                                                   placeholder="Jakarta" value="{{ old('tempat_lahir') }}">

                                            <label for="tanggal_lahir" class="mt-2">Tanggal Lahir</label>
                                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('tanggal_lahir') }}">

                                            <label for="email" class="mt-2">Email</label>
                                            <input type="email" id="email" name="email"
                                                   class="form-control form-control-sm"
                                                   placeholder="jondoe@gmail.com" value="{{ old('email') }}">

                                            <label for="no_hp" class="mt-2">No HP/WA</label>
                                            <input type="text" id="no_hp" name="no_hp"
                                                   class="form-control form-control-sm"
                                                   placeholder="0821" value="{{ old('no_hp') }}">

                                            <label for="kelas_id" class="mt-2">Kelas</label>
                                            <select class="form-control form-control-sm" name="kelas_id" id="kelas_id">
                                                <option value="">Pilih Kelas</option>
                                                @foreach($kelas as $kls)
                                                    <option value="{{ $kls->id }}" {{ old('kelas_id') == $kls->id ? 'selected' : '' }}>
                                                        {{ $kls->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info btn-sm">Simpan</button>
                            <button type="reset" class="btn btn-default float-right btn-sm">Batal</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="{{ url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });

    function previewImage(event) {
        const reader = new FileReader();
        const preview = document.getElementById('profile-img-preview');

        reader.onload = function() {
            preview.src = reader.result;
        }

        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection
