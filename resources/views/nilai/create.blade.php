@extends('layouts.menu')
@section('title', 'Input Nilai')
@section('css')
<link rel="stylesheet" href="{{url('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
<!-- Main content -->
@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('akademik.nilai.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <span for="siswa_id">Nama Siswa</span>
                                <select name="siswa_id" id="siswa_id" class="form-control select2bs4" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <span for="mapel_id">Mata Pelajaran</span>
                                <select name="mapel_id" id="mapel_id" class="form-control select2bs4" required>
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach ($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <span for="jenis_nilai_id">Jenis Nilai</span>
                                <select name="jenis_nilai_id" id="jenis_nilai_id" class="form-control select2bs4"
                                    required>
                                    <option value="">-- Pilih Jenis Nilai --</option>
                                    @foreach ($jenisNilai as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_jenis }} ({{ $j->tipe_nilai }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <span for="nilai">Nilai</span>
                                <input type="number" step="0.01" name="nilai" id="nilai"
                                    class="form-control form-control-sm" required>
                            </div>

                            <div class="form-group">
                                <span for="keterangan">Keterangan</span>
                                <input type="text" name="keterangan" id="keterangan"
                                    class="form-control form-control-sm">
                            </div>

                            <div class="form-group">
                                <span for="tanggal_input">Tanggal Input</span>
                                <input type="date" name="tanggal_input" id="tanggal_input" class="form-control"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!--  -->
            <div class="col-md-6 col-12">
                <div class="card">
                <div class="card-header">
                <h3 class="card-title">Fixed Header Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 500px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Siswa</th>
                      <th>Mapel</th>
                      <th>Nilai</th>
                      <th>Keterangan</th>
                      <th>Reason</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    </tr>
                    <tr>
                      <td>219</td>
                      <td>Alexander Pierce</td>
                      <td>11-7-2014</td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    </tr>
                    <tr>
                      <td>657</td>
                      <td>Bob Doe</td>
                      <td>11-7-2014</td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    </tr>
                    <tr>
                      <td>175</td>
                      <td>Mike Doe</td>
                      <td>11-7-2014</td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    </tr>
                    <tr>
                      <td>134</td>
                      <td>Jim Doe</td>
                      <td>11-7-2014</td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    </tr>
                    <tr>
                      <td>494</td>
                      <td>Victoria Doe</td>
                      <td>11-7-2014</td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    </tr>
                    <tr>
                      <td>832</td>
                      <td>Michael Doe</td>
                      <td>11-7-2014</td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    </tr>
                    <tr>
                      <td>982</td>
                      <td>Rocky Doe</td>
                      <td>11-7-2014</td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->



@endsection

@section('script')
<!-- DataTables -->
<script src="{{url('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{url('assets/plugins/toastr/toastr.min.js')}}"></script>
<!-- page script -->
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function() {
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    $("#example1").DataTable();
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });
});

var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
</script>
@if(session('success'))
<script>
toastr.success("{{ session('success') }}");
</script>
@endif
@endsection