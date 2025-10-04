@extends('layouts.menu')
@section('title') Master Jenis Pembayaran @endsection

@section('css')
<link rel="stylesheet" href="{{url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endsection

@section('content')
<section class="content">
<div class="container-fluid">
  <div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Jenis Pembayaran</h3>
        <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalCreate">
            <i class="fa fa-plus"></i> Tambah Jenis Pembayaran
        </button>
    </div>
    <div class="card-body">
      <table id="tableJenis" class="table table-bordered table-striped table-sm">
        <thead>
          <tr>
            <th>Nama Pembayaran</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $d)
          <tr>
            <td>{{ $d->nama_pembayaran }}</td>
            <td>Rp {{ number_format($d->jumlah,0,',','.') }}</td>
            <td>{{ $d->keterangan }}</td>
            <td>
              <button class="btn btn-warning btn-xs btnEditPembayaran"
                data-id="{{ $d->id }}"
                data-nama="{{ $d->nama_pembayaran }}"
                data-jumlah="{{ $d->jumlah }}"
                data-ket="{{ $d->keterangan }}"
                data-toggle="modal" data-target="#modalEdit">
                <i class="fa fa-edit"></i>
              </button>
              <form action="{{ route('master.jenis-pembayaran.destroy',$d->id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
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
</section>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate">
  <div class="modal-dialog">
    <form action="{{ route('master.jenis-pembayaran.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Jenis Pembayaran</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Pembayaran</label>
            <input type="text" name="nama_pembayaran" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
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
      @csrf @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Jenis Pembayaran</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Pembayaran</label>
            <input type="text" id="editNama" name="nama_pembayaran" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Jumlah</label>
            <input type="number" id="editJumlah" name="jumlah" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <textarea id="editKet" name="keterangan" class="form-control"></textarea>
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
<script src="{{url('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{url('assets/plugins/toastr/toastr.min.js')}}"></script>
<script>
$(function () {
    $(function() {
    // bsCustomFileInput.init();
    $("#tableJenis").DataTable();
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });
});

  $(document).on('click','.btnEditPembayaran',function(){
      var id = $(this).data('id');
      var nama = $(this).data('nama');
      var jumlah = $(this).data('jumlah');
      var ket = $(this).data('ket');

      $('#editNama').val(nama);
      $('#editJumlah').val(jumlah);
      $('#editKet').val(ket);

      $('#formEdit').attr('action','/master/jenis-pembayaran/'+id);
  });
});
</script>
@endsection
