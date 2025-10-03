@extends('layouts.menu')
@section('title') Guru @endsection
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
                        <h3 class="card-title">Data Guru</h3>
                        @permission('tambah_guru')
                        <a type="button" href="{{route('master.guru.create')}}" class="btn btn-success btn-xs float-right mr-2" >
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                        @endpermission
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center text-indigo">NIP</th>
                                    <th class="text-center text-indigo">Nama Lengkap</th>
                                    <th class="text-center text-indigo">No HP</th>
                                    <th class="text-center text-indigo">Jabatan</th>
                                    <th class="text-center text-indigo">#</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($gurus as $guru)
                                <tr>
                                    <td>{{$guru->nip}}</td>
                                    <td>{{$guru->nama_lengkap}}</td>
                                    <td>{{$guru->no_hp}}</td>
                                    <td>@foreach($guru->jabatans as $jab)
                                    <span class="badge bg-info">{{ $jab->nama_jabatan }}</span>
                                @endforeach</td>
                                    <td>
                                        <a type="button" href="{{ route('master.guru.show',$guru->id) }}" class="btn btn-block bg-gradient-info btn-xs">Detail</a>
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