@extends('layouts.menu')
@section('title') Transaksi Pembayaran  @endsection

@section('content')
<section class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-8 col-12">
<div class="card">
        <div class="card-header">
            <h3 class="card-title">Input Pembayaran Siswa: </h3>
        </div>
        <div class="card-body">
        <div class="form-group">
    <label>Cari Siswa</label>
    <select id="siswa_id" class="form-control select2" style="width:100%">
        <option value="">-- Pilih Siswa --</option>
    </select>
</div>

            <form action="#" method="POST">
                @csrf
                <div class="form-group">
                    <label>Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" class="form-control" required>
                </div>

                <div id="pembayaran-wrapper">
                    <div class="row pembayaran-item mb-2">
                        <div class="col-md-4">
                            <select name="jenis_pembayaran_id[]" class="form-control" required>
                                <option value="">-- Pilih Pembayaran --</option>
                        
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="periode[]" class="form-control" placeholder="Periode (opsional)">
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btnRemove">Hapus</button>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-info" id="btnAdd">Tambah Pembayaran</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>

</div>

    <!-- History Pembayaran -->
    <div class="card col-md-4">
        <div class="card-header"><h3 class="card-title">History Pembayaran</h3></div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Pembayaran</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
   
</div>

</div>
</section>
@endsection

@section('script')
<script>
$(document).ready(function(){

    // Select2 search siswa
    $('#siswa_id').select2({
        ajax: {
            url: "{{ route('keuangan.pembayaran.searchSiswa') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return { results: data };
            },
            cache: true
        },
        placeholder: '-- Cari NIS / Nama Siswa --'
    });

    // ketika pilih siswa → load history
    $('#siswa_id').on('change', function(){
        let siswa_id = $(this).val();
        if(!siswa_id) return;

        $.get("{{ url('/pembayaran/history') }}/" + siswa_id, function(res){
            $('.card-body-history').html(res);
        });

        // set action form ke siswa yg dipilih
        $('form').attr('action', "{{ url('transaksi') }}/" + siswa_id);
    });

    // button tambah pembayaran
    $("#btnAdd").click(function(){
        let html = `
        <div class="row pembayaran-item mb-2">
            <div class="col-md-4">
                <select name="jenis_pembayaran_id[]" class="form-control" required>
                    <option value="">-- Pilih Pembayaran --</option>
                    @foreach($jenis as $j)
                        <option value="{{ $j->id }}">{{ $j->nama_pembayaran }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="periode[]" class="form-control" placeholder="Periode (opsional)">
            </div>
            <div class="col-md-3">
                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btnRemove">Hapus</button>
            </div>
        </div>`;
        $("#pembayaran-wrapper").append(html);
    });

    $(document).on('click','.btnRemove',function(){
        $(this).closest('.pembayaran-item').remove();
    });
});
</script>
@endsection

