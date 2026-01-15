<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu Digital | DISKOMINFO BINJAI</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --binjai-blue: #0A2647;
            --binjai-orange: #FF6B35;
            --binjai-dark: #051937;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Custom Styling */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 7%;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-title {
            color: var(--binjai-blue);
            font-weight: 700;
            font-size: 1.1rem;
            line-height: 1.2;
        }

        .brand-subtitle {
            color: var(--binjai-orange);
            font-size: 0.7rem;
            letter-spacing: 1.5px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .nav-link {
            text-decoration: none;
            color: var(--binjai-blue);
            font-weight: 500;
            font-size: 0.9rem;
            transition: 0.3s;
            position: relative;
        }

        .nav-link:hover { color: var(--binjai-orange); }

        .btn-login {
            background: var(--binjai-blue);
            color: white;
            padding: 7px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
            border: 2px solid var(--binjai-blue);
        }

        .btn-login:hover {
            background: transparent;
            color: var(--binjai-blue);
        }

        /* Background & Form Customization */
        .bg-binjai-gradient {
            background: linear-gradient(135deg, var(--binjai-blue) 0%, var(--binjai-dark) 100%);
        }
        
        .accent-orange { color: var(--binjai-orange); }
        .bg-orange-binjai { background-color: var(--binjai-orange); }

        /* Footer Styling */
        .footer {
            background: var(--binjai-dark);
            color: white;
            padding: 40px 5% 20px;
            margin-top: 60px;
        }
    </style>
</head>
<body class="bg-slate-100">

    <nav class="navbar">
        <a href="#" class="brand">
            <img src="{{ asset('images/logo-binjai.jpg') }}" alt="" width="80" >
            <br>
            <div class="brand-text">
                <div class="brand-title">DISKOMINFO</div>
                <div class="brand-subtitle">Kota Binjai</div>
            </div>
        </a>
        <div class="nav-actions">
            <a href="/admin" class="btn-login">Portal Admin</a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto my-10 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-slate-200">
            <div class="flex flex-col md:flex-row">
                
                <div class="md:w-2/5 bg-binjai-gradient p-10 text-white relative">
                    <div class="relative z-10">
                        <span class="bg-orange-600/20 text-orange-400 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                            Guest System
                        </span>
                        <h1 class="text-3xl font-extrabold mt-4 leading-tight">Selamat Datang</h1>
                        <p class="mt-4 text-slate-300 text-sm leading-relaxed">
                            Silakan isi formulir kunjungan digital ini sebagai bagian dari standar pelayanan di lingkungan Dinas Komunikasi dan Informatika Kota Binjai.
                        </p>
                        
                        <div class="mt-10 space-y-4">
                            <div class="flex items-center gap-3 text-sm text-slate-300">
                                <i class="fas fa-check-circle accent-orange"></i>
                                <span>Proses cepat & mudah</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-slate-300">
                                <i class="fas fa-shield-alt accent-orange"></i>
                                <span>Data tersimpan aman</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 right-0 opacity-5 p-4">
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
                                iconColor: '#0A2647'
                            });
                        </script>
                    @endif

                    <form action="{{ route('guest.store') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label class="text-[10px] font-bold uppercase text-slate-400 mb-2 block tracking-wider">Nama Lengkap</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fas fa-user text-sm"></i>
                                </span>
                                <input type="text" name="nama" value="{{ old('nama') }}" required 
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#0A2647] outline-none transition" 
                                    placeholder="Masukkan Nama Anda">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold uppercase text-slate-400 mb-2 block tracking-wider">Instansi / Asal</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fas fa-building text-sm"></i>
                                </span>
                                <input type="text" name="instansi" value="{{ old('instansi') }}" required 
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#0A2647] outline-none transition" 
                                    placeholder="Masukkan Instansi / Asal">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold uppercase text-slate-400 mb-2 block tracking-wider">No. Telepon</label>
                                <input type="text" name="telepon" value="{{ old('telepon') }}" required 
                                    inputmode="numeric"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    minlength="10" maxlength="15"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#0A2647] outline-none transition" 
                                    placeholder="08xxxxxxxx">
                            </div>

                            <div>
                                <label class="text-[10px] font-bold uppercase text-slate-400 mb-2 block tracking-wider">Tujuan Bidang</label>
                                <select name="bidang" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#0A2647] outline-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Tujuan</option>
                                    <option value="Kepala Dinas">Kepala Dinas</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Umum dan Kepegawaian">Umum dan Kepegawaian</option>
                                    <option value="Keuangan dan Program">Keuangan dan Program</option>
                                    <option value="IKP">Informasi dan Komunikasi Publik (IKP)</option>
                                    <option value="APTIKA">Aplikasi dan Informatika (APTIKA)</option>
                                    <option value="Statistik">Statistik dan Persandian</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold uppercase text-slate-400 mb-2 block tracking-wider">Keperluan</label>
                            <textarea name="keperluan" rows="3" required 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#0A2647] outline-none transition" 
                                placeholder="Jelaskan tujuan Anda berkunjung...">{{ old('keperluan') }}</textarea>
                        </div>

                        <button type="submit" 
                            class="w-full bg-[#0A2647] hover:bg-[#FF6B35] text-white font-bold py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-sm">
                            Kirim Data Kunjungan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="text-center border-b border-white/10 pb-8 mb-6">
            <h3 class="font-bold text-lg tracking-wide">Pemerintah Kota Binjai</h3>
            <p class="text-xs text-slate-400">Dinas Komunikasi dan Informatika</p>
        </div>
        <div class="text-center">
            <p class="text-sm text-slate-400">© Copyright Pemko Binjai. All Rights Reserved</p>
            <p class="text-sm font-semibold accent-orange mt-1">Designed by Kominfo</p>
        </div>
    </footer>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const telp = document.querySelector('input[name="telepon"]').value;
            if (telp.length < 10) {
                e.preventDefault(); 
                Swal.fire({
                    icon: 'error',
                    title: 'Nomor HP Tidak Valid',
                    text: 'Mohon masukkan nomor telepon minimal 10 angka.',
                    confirmButtonColor: '#0A2647', 
                });
            }
        });
    </script>
</body>
</html>