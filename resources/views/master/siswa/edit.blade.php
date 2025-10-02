@extends('layouts.menu')
@section('title','Edit Siswa')

@section('content')
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('master.siswa.update',$siswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">Edit Siswa</h3></div>
                <div class="card-body">
                    <div class="row">
                        <!-- Foto -->
                        <div class="col-md-3">
                            <img id="preview" 
                                src="{{ $siswa->foto ? asset('storage/img_siswa/'.$siswa->foto) : asset('assets/img_siswa/camera.png') }}" 
                                class="img-fluid mb-2">
                            <input type="file" name="foto" class="form-control form-control-sm" onchange="previewImage(event)">
                        </div>
                        <!-- Data -->
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>NIS</label>
                                    <input type="text" name="nis" value="{{ old('nis',$siswa->nis) }}" class="form-control form-control-sm">
                                    
                                    <label>Nama</label>
                                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap',$siswa->nama_lengkap) }}" class="form-control form-control-sm">
                                    
                                    <label>Email</label>
                                    <input type="text" name="email" value="{{ old('email',$siswa->user->email) }}" class="form-control form-control-sm">
                                    
                                    <label>Kelas</label>
                                    <select name="kelas_id" class="form-control form-control-sm">
                                        <option value="">- Pilih -</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" {{ $siswa->kelas_id==$k->id?'selected':'' }}>{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Tahun</label>
                                    <input type="text" name="tahun_pembelajaran" value="{{ old('tahun_pembelajaran',$siswa->tahun_pembelajaran) }}" class="form-control form-control-sm">
                                    
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control form-control-sm">
                                        <option value="L" {{ $siswa->jenis_kelamin=='L'?'selected':'' }}>Laki-laki</option>
                                        <option value="P" {{ $siswa->jenis_kelamin=='P'?'selected':'' }}>Perempuan</option>
                                    </select>
                                    
                                    <label>No HP</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp',$siswa->no_hp) }}" class="form-control form-control-sm">
                                    
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control form-control-sm">{{ old('alamat',$siswa->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info btn-sm">Update</button>
                    <a href="{{ route('master.siswa.show',$siswa->id) }}" class="btn btn-default btn-sm">Batal</a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('script')
<script>
function previewImage(e){
    let reader = new FileReader();
    reader.onload = function(e){ document.getElementById('preview').src = e.target.result; }
    reader.readAsDataURL(e.target.files[0]);
}
</script>
@endsection
