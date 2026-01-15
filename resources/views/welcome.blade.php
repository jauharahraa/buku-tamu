<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu Digital | DISKOMINFO BINJAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 font-sans">

    <nav class="bg-white shadow-sm border-b-4 border-indigo-900 p-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-900 p-2 rounded-lg">
                    <i class="fas fa-landmark text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="font-bold text-slate-800 leading-tight">DISKOMINFO</h2>
                    <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">Kota Binjai</p>
                </div>
            </div>
            <a href="/admin" class="text-sm font-medium text-slate-400 hover:text-indigo-900 transition">Portal Admin</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto my-10 p-4">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
            <div class="flex flex-col md:flex-row">
                
                <div class="md:w-2/5 bg-indigo-900 p-10 text-white relative">
                    <div class="relative z-10">
                        <span class="bg-indigo-500/30 text-indigo-200 text-xs font-bold px-3 py-1 rounded-full uppercase">Guest System</span>
                        <h1 class="text-3xl font-extrabold mt-4 leading-tight">Selamat Datang</h1>
                        <p class="mt-4 text-indigo-100 text-sm leading-relaxed">
                            Silakan isi formulir kunjungan digital ini sebagai bagian dari standar pelayanan di lingkungan Dinas Komunikasi dan Informatika Kota Binjai.
                        </p>
                        
                        <div class="mt-10 space-y-4">
                            <div class="flex items-center gap-3 text-sm text-indigo-200">
                                <i class="fas fa-check-circle text-green-400"></i>
                                <span>Proses cepat & mudah</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-indigo-200">
                                <i class="fas fa-shield-alt text-blue-400"></i>
                                <span>Data tersimpan aman</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 right-0 opacity-10 p-4">
                        <i class="fas fa-city text-9xl"></i>
                    </div>
                </div>

                <div class="md:w-3/5 p-10 bg-white">
                    @if(session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Terkirim',
                                text: "{{ session('success') }}",
                                timer: 3500,
                                showConfirmButton: false,
                                background: '#fff',
                                iconColor: '#312e81'
                            });
                        </script>
                    @endif

                    <form action="{{ route('guest.store') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label class="text-xs font-bold uppercase text-slate-500 mb-2 block">Nama Lengkap</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fas fa-user text-sm"></i>
                                </span>
                                <input type="text" name="nama" value="{{ old('nama') }}" required 
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border @error('nama') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-900 outline-none transition" 
                                    placeholder="Masukkan Nama Anda">
                            </div>
                            @error('nama') <p class="text-red-500 text-[10px] mt-1 font-bold italic">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase text-slate-500 mb-2 block">Instansi / Asal</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fas fa-building text-sm"></i>
                                </span>
                                <input type="text" name="instansi" value="{{ old('instansi') }}" required 
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border @error('instansi') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-900 outline-none transition" 
                                    placeholder="Masukkan Instansi / Asal">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold uppercase text-slate-500 mb-2 block">No. Telepon</label>
                                <input type="text" name="telepon" value="{{ old('telepon') }}" required 
                                    inputmode="numeric"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    minlength="10" 
                                    maxlength="15"
                                    class="w-full px-4 py-3 bg-slate-50 border @error('telepon') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-900 outline-none transition" 
                                    placeholder="08xxxxxxxx">
                                @error('telepon') <p class="text-red-500 text-[10px] mt-1 font-bold italic">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase text-slate-500 mb-2 block">Tujuan Bidang / Bagian</label>
                                <select name="bidang" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-900 outline-none cursor-pointer appearance-none">
                                    <option value="" disabled selected>Pilih Tujuan Bidang</option>
                                    <option value="Kepala Dinas">Kepala Dinas</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Umum dan Kepegawaian">Umum dan Kepegawaian</option>
                                    <option value="Keuangan dan Program">Keuangan dan Program</option>
                                    <option value="Informasi dan Komunikasi Publik (IKP)">Informasi dan Komunikasi Publik (IKP)</option>
                                    <option value="Aplikasi dan Informatika (APTIKA)">Aplikasi dan Informatika (APTIKA)</option>
                                    <option value="Statistik dan Persandian">Statistik dan Persandian</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase text-slate-500 mb-2 block">Keperluan</label>
                            <textarea name="keperluan" rows="3" required 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-900 outline-none transition" 
                                placeholder="Jelaskan tujuan Anda berkunjung...">{{ old('keperluan') }}</textarea>
                        </div>

                        <button type="submit" id="btnSubmit"
                            class="w-full bg-indigo-900 hover:bg-slate-800 text-white font-bold py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-wide">
                            KIRIM DATA KUNJUNGAN
                        </button>

                        <script>
                            document.querySelector('form').addEventListener('submit', function(e) {
                                const telp = document.querySelector('input[name="telepon"]').value;
                                
                                if (telp.length < 10) {
                                    e.preventDefault(); 
                                    
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Nomor HP Tidak Valid',
                                        text: 'Mohon masukkan nomor telepon minimal 10 angka.',
                                        confirmButtonColor: '#312e81', 
                                    });
                                }
                            });
                        </script>
                    </form>
                </div>
            </div>
        </div>
        <p class="text-center mt-6 text-slate-400 text-sm italic">Sistem Informasi Buku Tamu Digital - Diskominfo Binjai</p>
    </div>

</body>
</html>