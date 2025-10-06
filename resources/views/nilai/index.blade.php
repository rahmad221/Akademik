@extends('layouts.menu')
@section('title', 'Daftar Nilai')
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
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Nilai</h3>
                        <!-- <button type="button" class="btn btn-xs btn-primary float-right" data-toggle="modal"
                            data-target="#modal-primary">
                            <i class="fa-solid fa-upload"></i> Import
                        </button> -->
              @permission('tambah_siswa')
                        <a type="button" href="{{route('akademik.nilai.create')}}" class="btn btn-success btn-xs float-right mr-2" >
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                        @endpermission
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center text-indigo">Mata Pelajaran</th>
                                    <th class="text-center text-indigo">Jenis Nilai</th>
                                    <th class="text-center text-indigo">Kelas</th>
                                    <th class="text-center text-indigo">Guru</th>
                                    <th class="text-center text-indigo">Tanggal Input</th>
                                    <th class="text-center text-indigo">#</th>
                                </tr>
                            </thead>
                            <tbody>
                            
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