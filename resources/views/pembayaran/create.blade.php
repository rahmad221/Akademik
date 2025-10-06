@extends('layouts.menu')
@section('title') Transaksi Pembayaran @endsection
@section('css')
<link rel="stylesheet" href="{{url('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Form Pembayaran -->
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Input Pembayaran Siswa</h3>
                    </div>
                    <div class="card-body">

                        <form id="formPembayaran" action="{{ route('keuangan.pembayaran.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                            <span>Cari Siswa</span>
                            <select id="siswa_id"name="siswa_id" class="form-control select2" style="width:100%">
                                <option value="">-- Pilih Siswa --</option>
                            </select>   
                        </div>
                            <div class="form-group">
                                <span>Tanggal Bayar</span>
                                <input type="date" name="tanggal_bayar" class="form-control" required>
                            </div>

                            <div id="pembayaran-wrapper">
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
                                        <input type="text" name="periode[]" class="form-control"
                                            placeholder="Periode (opsional)">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah"
                                            required>
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
            <div class="col-md-6 col-12">
    <!-- History Pembayaran -->
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">History Pembayaran</h3>
        </div>
        <div class="card-body card-body-history">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody id="history-table-body">
                    <tr><td colspan="4" class="text-center text-muted">Pilih siswa untuk melihat history.</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tunggakan -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tunggakan</h3>
        </div>
        <div class="card-body card-body-tunggakan">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>Jenis</th>
                        <th>Total</th>
                        <th>Sudah</th>
                        <th>Sisa</th>
                    </tr>
                </thead>
                <tbody id="tunggakan-table-body">
                    <tr><td colspan="4" class="text-center text-muted">Pilih siswa untuk melihat tunggakan.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


        </div>
    </div>
</section>
@endsection

@section('script')
<script src="{{url('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let today = new Date().toISOString().slice(0, 10);
    document.querySelector('input[name="tanggal_bayar"]').value = today;
});
$(document).ready(function() {
    // Inisialisasi select2
    $('#siswa_id').select2({
        theme: 'bootstrap4',
        ajax: {
            url: "{{ route('keuangan.pembayaran.searchSiswa') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { q: params.term };
            },
            processResults: function(data) {
                return { results: data };
            },
            cache: true
        },
        placeholder: '-- Cari NIS / Nama Siswa --'
    });

    $('#siswa_id').on('change', function(){
    let siswa_id = $(this).val();
    if(!siswa_id) return;

    // Load history
    $.get("{{ url('/keuangan/pembayaran/history') }}/" + siswa_id, function(res){
        $('#history-table-body').html(res);
    });

    // Load tunggakan
    $.get("{{ url('/keuangan/pembayaran/tunggakan') }}/" + siswa_id, function(data){
    let html = '';
    if(data.length === 0){
        html = '<tr><td colspan="4" class="text-center text-muted">Tidak ada tunggakan.</td></tr>';
    } else {
        data.forEach(t => {
            let bulan = t.belum_bayar_bulan.length ? `<br><small><i>${t.belum_bayar_bulan.join(', ')}</i></small>` : '';
            html += `<tr>
                <td>${t.jenis_pembayaran}${bulan}</td>
                <td>Rp ${t.total_tagihan.toLocaleString()}</td>
                <td>Rp ${t.sudah_bayar.toLocaleString()}</td>
                <td><b>Rp ${t.sisa.toLocaleString()}</b></td>
            </tr>`;
        });
    }
    $('#tunggakan-table-body').html(html);
});
});


    // Tambah baris pembayaran
    $("#btnAdd").click(function() {
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

    // Hapus baris
    $(document).on('click', '.btnRemove', function() {
        $(this).closest('.pembayaran-item').remove();
    });
});
</script>
@if(session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
@endsection
