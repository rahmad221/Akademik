<html>
<head>
    <title>BUKTI PEMBAYARAN SISWA</title>
    <style>
        body {
            font-family: Calibri, Arial, sans-serif;
            font-size: 8pt;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            padding: 4px;
        }

        .kop-sekolah {
            text-align: center;
            line-height: 1.2;
        }

        .kop-sekolah h2 {
            margin: 0;
            font-size: 14pt;
        }

        .kop-sekolah p {
            margin: 0;
            font-size: 9pt;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 8px 0;
        }

        .info td {
            font-size: 8pt;
            vertical-align: top;
        }

        .tabel-bayar {
            margin-top: 5px;
            border: 1px solid black;
        }

        .tabel-bayar th, .tabel-bayar td {
            border: 1px solid black;
            padding: 3px;
            font-size: 8pt;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .footer {
            margin-top: 15px;
            font-size: 9pt;
        }

        @media print {
            @page {
                size: A5 landscape;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>

    <table border="0">
        <tr>
            <td width="15%" align="center">
                <img src="{{ public_path('assets/logo.png') }}" width="60">
            </td>
            <td class="kop-sekolah">
                <h2>SMK PENDA 2 KARANGANYAR</h2>
                <p>Jl. Lawu, Harjosari, Popongan, Karanganyar, Jawa Tengah</p>
                <p>Telp. 0271 - 494 787 | Web: www.cyberdeveloper.my.id | Email: penda2kra@yahoo.co.id</p>
            </td>
        </tr>
    </table>

    <div class="judul">BUKTI PEMBAYARAN SISWA</div>

    <table class="info" border="0">
        <tr>
            <td width="20%">NO TRANS</td><td width="2%">:</td><td width="28%">KL10160001</td>
            <td width="20%">NIS</td><td width="2%">:</td><td>16258</td>
        </tr>
        <tr>
            <td>TANGGAL</td><td>:</td><td>10/01/2016</td>
            <td>NAMA SISWA</td><td>:</td><td>TRI BUDI HARYANTO</td>
        </tr>
        <tr>
            <td>JAM CETAK</td><td>:</td><td>10:48:03</td>
            <td>KELAS</td><td>:</td><td>10 - TPMI</td>
        </tr>
    </table>

    <table class="tabel-bayar">
        <tr class="center">
            <th width="5%">No.</th>
            <th>Keterangan Pembayaran</th>
            <th width="25%">Jumlah (Rp)</th>
        </tr>
        <tr>
            <td class="center">1</td>
            <td>Biaya Penyelenggaraan Pendidikan - AGS 2016/2017</td>
            <td class="right">50,000.00</td>
        </tr>
        <tr>
            <td class="center">2</td>
            <td>Biaya Penyelenggaraan Pendidikan - SEP 2016/2017</td>
            <td class="right">50,000.00</td>
        </tr>
        <tr>
            <td colspan="2" class="right"><b>Grand Total :</b></td>
            <td class="right"><b>100,000.00</b></td>
        </tr>
    </table>

    <p style="font-style:italic; font-size:9pt; margin-top:5px;">
        Terbilang : Seratus Ribu Rupiah
    </p>

    <table border="0" style="margin-top:15px;">
        <tr>
            <td width="65%"></td>
            <td align="center">
                Karanganyar, 18 Oktober 2016<br>
                Yang Menerima,<br><br><br><br>
                <b>Widiya Nanda Gardhea Putri, S.Pd</b>
            </td>
        </tr>
    </table>

    <div class="footer">
        <b>Catatan :</b><br>
        - Disimpan sebagai bukti pembayaran yang sah.<br>
        - Uang yang sudah dibayarkan tidak dapat diminta kembali.<br><br>
        <i>Dicetak tgl : <?=date('d-M-Y H:i:s')?> </i>
    </div>

</body>
</html>
