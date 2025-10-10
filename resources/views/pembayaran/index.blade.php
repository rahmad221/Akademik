@extends('layouts.menu')
@section('title') Pembayaran List @endsection
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
                        <h3 class="card-title">Pembayaran</h3>
                        <!-- <button type="button" class="btn btn-xs btn-primary float-right" data-toggle="modal"
                            data-target="#modal-primary">
                            <i class="fa-solid fa-upload"></i> Import
                        </button> -->
              @permission('tambah_pembayaran')
                        <a type="button" href="{{route('keuangan.pembayaran.create')}}" class="btn btn-success btn-xs float-right mr-2" >
                            <i class="fa fa-plus"></i> Buat Pembayaran
                        </a>
                        @endpermission
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center text-indigo">Nama Siswa</th>
                                    <th class="text-center text-indigo">Kelas</th>
                                    <th class="text-center text-indigo">Total</th>
                                    <th class="text-center text-indigo">Pembayaran</th>
                                    <th class="text-center text-indigo">#</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($transaksi as $trs)
                            <tr>
                                <td>{{$trs->siswa->nama_lengkap}}</td>
                                <td>{{$trs->siswa->kelas->nama_kelas}}</td>
                                <td class="text-right">{{number_format($trs->total_bayar, 2, ',', ' ')}}</td>
                                <td>Cash</td>
                                <td>
                                <button class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-primary btn-xs" onclick="printNota({{$trs->id}})"><i class="fas fa-print"></i></button>
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

function printNota(key){
    window.open('pembayaran/printBukti/' + key , '_blank');
    }
</script>
@if(session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
@endsection