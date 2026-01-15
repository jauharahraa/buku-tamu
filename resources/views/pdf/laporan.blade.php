<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Buku Tamu Digital</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; }
        
        /* Gaya Kop Surat */
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; position: relative; }
        .logo { position: absolute; left: 0px; top: 0px; width: 70px; } /* Ukuran logo disesuaikan agar proporsional */
        .instansi-header { margin-left: 15px; }
        .pemko { font-size: 14pt; font-weight: bold; margin-bottom: -15px; }
        .dinas { font-size: 16pt; font-weight: bold; margin-bottom: 0; text-transform: uppercase; }
        .alamat { font-size: 10pt; margin-top: 5px; }

        .judul-laporan { text-align: center; font-size: 14pt; font-weight: bold; text-decoration: underline; margin-bottom: 10px; }
        
        /* Gaya Tabel */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10pt; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; text-transform: uppercase; }
        .center { text-align: center; }

        /* Gaya Tanda Tangan */
        .ttd-container { margin-top: 40px; float: right; width: 250px; text-align: center; }
        .tgl-cetak { margin-bottom: 60px; }
        .nama-pejabat { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    {{-- Baris "Judul Laporan" yang paling atas sendiri sudah dihapus --}}

    <div class="kop-surat">
        <img src="{{ public_path('images/logo-binjai.jpg') }}" class="logo">
        <div class="instansi-header">
            <p class="pemko">PEMERINTAH KOTA BINJAI</p>
            <p class="dinas">DINAS KOMUNIKASI DAN INFORMATIKA</p>
            <p class="alamat">Jl. Jendral Sudirman No. 6, Kel. Kartini, Kec. Binjai Kota, Kota Binjai, Sumatera Utara 20712</p>
        </div>
    </div>

    <div class="judul-laporan">LAPORAN KUNJUNGAN TAMU DIGITAL</div>

    @if(request()->has('tableFilters'))
        <div style="text-align: center; margin-bottom: 15px; font-size: 10pt;">
            Periode: 
            {{ request('tableFilters')['created_at']['dari_tanggal'] ?? 'Awal' }} 
            s/d 
            {{ request('tableFilters')['created_at']['sampai_tanggal'] ?? 'Sekarang' }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Nama</th>
                <th width="15%">Instansi</th>
                <th width="12%">No. Telepon</th>
                <th width="13%">Tujuan Bidang</th>
                <th width="25%">Keperluan</th>
                <th width="15%">Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guests as $key => $guest)
            <tr>
                <td class="center">{{ $key + 1 }}</td>
                <td>{{ $guest->nama }}</td>
                <td>{{ $guest->instansi }}</td>
                <td>{{ $guest->telepon }}</td>
                <td>{{ $guest->bidang }}</td>
                <td>{{ $guest->keperluan }}</td>
                <td class="center">{{ $guest->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd-container">
        <div class="tgl-cetak">
            Binjai, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
            Mengetahui,
        </div>
        <p class="nama-pejabat">NAMA PEJABAT TERKAIT</p>
        <p>NIP. ........................................</p>
    </div>

</body>
</html>