@extends('layouts.menu')
@section('title') Siswa @endsection
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endsection
<!-- Main content -->
@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Siswa</h3>
                        <!-- <button type="button" class="btn btn-xs btn-primary float-right" data-toggle="modal"
                            data-target="#modal-primary">
                            <i class="fa-solid fa-upload"></i> Import
                        </button> -->
              @permission('tambah_siswa')
                        <a type="button" href="{{route('master.siswa.create')}}" class="btn btn-success btn-xs float-right mr-2" >
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                        @endpermission
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center text-indigo">NIS</th>
                                    <th class="text-center text-indigo">Nama</th>
                                    <th class="text-center text-indigo">Jenis Kelamin</th>
                                    <th class="text-center text-indigo">Kelas</th>
                                    <th class="text-center text-indigo">Tahun Masuk</th>
                                    <th class="text-center text-indigo">#</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($siswa as $sws)
                                <tr>
                                    <td>{{$sws->nis}}</td>
                                    <td>{{$sws->nama_lengkap}}</td>
                                    <td>
                                        @if($sws->jenis_kelamin=='L')
                                        Laki-laki
                                        @else
                                        Perempuan
                                        @endif
                                    </td>
                                    <td>{{$sws->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{$sws->tahun_pembelajaran}}</td>
                                    <td>
                                        <a type="button" href="{{ route('master.siswa.show',$sws->id) }}" class="btn btn-block bg-gradient-info btn-xs">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->


<!-- modal upload -->
<div class="modal fade" id="modal-primary" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-info btn-sm">Upload</button>
                    <button type="button" class="btn btn-default float-right btn-sm" data-dismiss="modal">Batal</button>
                </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- DataTables -->
<script src="{{url('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{url('assets/plugins/toastr/toastr.min.js')}}"></script>
<!-- page script -->
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function() {
    bsCustomFileInput.init();
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