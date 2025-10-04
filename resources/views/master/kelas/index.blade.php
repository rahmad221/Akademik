@extends('layouts.menu')
@section('title') Data Kelas @endsection
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endsection
<!-- Main content -->
@section('content')
<section class="content">
<div class="container-fluid">
    <div class="row">
    <div class="col-md-6 col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Kelas</h3>
            @permission('tambah_kelas')
              <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalCreate">
                <i class="fa fa-plus"></i> Tambah Kelas
            </button>
                        @endpermission
        </div>
        <div class="card-body">
            <table id="example2" class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th class="text-center text-indigo">Nama Kelas</th>
                        <th class="text-center text-indigo">Wali Kelas</th>
                        <th class="text-center text-indigo">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelas as $k)
                    <tr>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->waliKelas->nama_lengkap ?? '-' }}</td>
                        <td>
                        <button 
    class="btn bg-gradient-warning btn-xs btnEditKelas" 
    data-id="{{ $k->id }}" 
    data-nama="{{ $k->nama_kelas }}" 
    data-wali="{{ $k->wali_kelas_id }}" 
    data-toggle="modal" 
    data-target="#modalEdit">
    <i class="fa fa-edit"></i>
</button>
                            <form action="{{ route('master.kelas.destroy',$k->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xs" onclick="return confirm('Yakin hapus?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>

</div>


</section>
<!-- /.content -->
<!-- Modal Create -->
<div class="modal fade" id="modalCreate">
    <div class="modal-dialog">
        <form action="{{ route('master.kelas.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Kelas</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Wali Kelas</label>
                        <select name="wali_kelas_id" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach($guru as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Kelas</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" name="nama_kelas" id="editNamaKelas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Wali Kelas</label>
                        <select name="wali_kelas_id" id="editWaliKelas" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach($guru as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
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

$(document).on('click', '.btnEditKelas', function () {
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    var wali = $(this).data('wali');

    // isi form edit
    $('#editNamaKelas').val(nama);
    $('#editWaliKelas').val(wali);

    // ubah action form sesuai id
    $('#formEdit').attr('action', '/master/kelas/' + id);
});

</script>
@if(session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
@endsection