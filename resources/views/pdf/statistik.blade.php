<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Statistik Kunjungan</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; }
        
        /* Gaya Kop Surat Sesuai SOP */
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; position: relative; }
        .logo { position: absolute; left: 0px; top: 0px; width: 70px; }
        .instansi-header { margin-left: 20px; }
        .pemko { font-size: 14pt; font-weight: bold; margin-bottom: -15px; }
        .dinas { font-size: 16pt; font-weight: bold; margin-bottom: 0; text-transform: uppercase; }
        .alamat { font-size: 10pt; margin-top: 5px; }

        /* Gaya Judul Laporan */
        .judul-laporan { text-align: center; font-size: 14pt; font-weight: bold; text-decoration: underline; margin-bottom: 5px; text-transform: uppercase; }
        .sub-judul { text-align: center; font-size: 11pt; margin-bottom: 20px; }
        
        /* Gaya Tabel Statistik (Menyesuaikan input Anda) */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; text-transform: uppercase; }
        .center { text-align: center; }

        /* Gaya Tanda Tangan SOP */
        .footer-container { margin-top: 50px; width: 100%; }
        .ttd-box { float: right; width: 250px; text-align: center; }
        .tgl-cetak { margin-bottom: 60px; }
        .nama-pejabat { font-weight: bold; text-decoration: underline; text-transform: uppercase; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <img src="{{ public_path('images/logo-binjai.jpg') }}" class="logo">
        <div class="instansi-header">
            <p class="pemko">PEMERINTAH KOTA BINJAI</p>
            <p class="dinas">DINAS KOMUNIKASI DAN INFORMATIKA</p>
            <p class="alamat">Jl. Jendral Sudirman No. 6, Kel. Kartini, Kec. Binjai Kota, Kota Binjai, Sumatera Utara 20712</p>
        </div>
    </div>

    <div class="judul-laporan">LAPORAN STATISTIK KUNJUNGAN TAMU</div>
    <div class="sub-judul">Dicetak pada: {{ $tanggal_cetak }}</div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th width="60%">Kategori Periode</th>
                    <th width="40%">Jumlah Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Kunjungan Hari Ini</td>
                    <td class="center">{{ $hari_ini }} orang</td>
                </tr>
                <tr>
                    <td>Kunjungan Minggu Ini</td>
                    <td class="center">{{ $minggu_ini }} orang</td>
                </tr>
                <tr>
                    <td>Kunjungan Bulan Ini</td>
                    <td class="center">{{ $bulan_ini }} orang</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                    <td><strong>Total Seluruh Database</strong></td>
                    <td class="center"><strong>{{ $total }} orang</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer-container clearfix">
        <div class="ttd-box">
            <div class="tgl-cetak">
                Binjai, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                Mengetahui,
            </div>
            <p class="nama-pejabat">NAMA PEJABAT TERKAIT</p>
            <p>NIP. ........................................</p>
        </div>
    </div>

</body>
</html>