<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Terkirim | DISKOMINFO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 max-w-lg w-full text-center">
        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check text-4xl"></i>
        </div>

        <h1 class="text-3xl font-extrabold text-slate-800 mb-2">Data Terkirim!</h1>
        <p class="text-slate-500 mb-8">Terima kasih, <span class="font-bold text-indigo-900">{{ session('nama_tamu') }}</span>. Kunjungan Anda telah tercatat dalam sistem kami.</p>

        <div class="bg-slate-50 rounded-2xl p-6 mb-8 text-left border border-slate-100">
            <div class="flex justify-between py-2 border-b border-slate-200">
                <span class="text-xs font-bold uppercase text-slate-400">Waktu</span>
                <span class="text-sm font-bold text-slate-700">{{ now()->format('H:i') }} WIB</span>
            </div>
            <div class="flex justify-between py-2 border-b border-slate-200">
                <span class="text-xs font-bold uppercase text-slate-400">Tujuan Bidang</span>
                <span class="text-sm font-bold text-slate-700">{{ session('bidang_tamu') }}</span>
            </div>
            <div class="flex justify-between py-2">
                <span class="text-xs font-bold uppercase text-slate-400">ID Kunjungan</span>
                <span class="text-sm font-bold text-indigo-600">#000{{ session('id_tamu') }}</span>
            </div>
        </div>

        <p class="text-[10px] text-slate-400 italic mb-8">
            Silakan tunjukkan halaman ini kepada petugas resepsionis jika diperlukan.
        </p>

        <a href="/" class="block w-full bg-indigo-900 hover:bg-indigo-800 text-white font-bold py-4 rounded-xl shadow-lg transition-all transform hover:scale-[1.02] active:scale-95">
            Kembali ke Beranda
        </a>
    </div>

</body>
</html>