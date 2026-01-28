<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Illuminate\Support\Facades\Blade;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings; 
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Colors\Color;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login() 
            ->darkMode(false)
            ->brandName('E-Tamu Diskominfo Binjai')
            ->brandLogo(asset('images/logo-binjai-removebg-preview.png'))
            ->brandLogoHeight('4rem')
            ->favicon(asset('favicon.ico'))
            ->font('Poppins')
            ->maxContentWidth('full')
            
            // FOOTER
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn (): string => Blade::render('
                    <footer class="fi-footer p-6 text-center text-sm text-gray-500">
                        <p>© Copyright <strong>Pemko Binjai</strong>. All Rights Reserved</p>
                        <p class="mt-1">Designed by <span style="color: #FF6B35; font-weight: 600;">Kominfo</span></p>
                    </footer>
                '),
            )
            
            // CUSTOM CSS
            ->renderHook(
                'panels::head.end',
                fn () => new \Illuminate\Support\HtmlString("
                    <style>
                        :root {
                            --bg-dongker: #0f172a; 
                            --primary-orange: #FF6B35;
                        }

                        /* SIDEBAR & NAVBAR */
                        .fi-sidebar, .fi-sidebar-header, .fi-layout header.fi-topbar {
                            background-color: var(--bg-dongker) !important;
                        }

                        .fi-sidebar {
                            width: var(--sidebar-width) !important;
                            z-index: 50 !important; /* Pastikan di depan elemen lain */
                            overflow-y: auto !important; /* Jika menu sangat banyak, sidebar bisa di-scroll sendiri */
                        }
                        /* WARNA FONT SIDEBAR */
                        .fi-sidebar nav * {
                            color: white !important;
                        }

                        /* LOGO & HEADER SIDEBAR */
                        .fi-sidebar-header {
                            display: flex !important;
                            flex-direction: column !important;
                            align-items: center !important;
                            padding: 2rem 1rem 1.5rem !important;
                            min-height: 180px !important;
                            position: relative !important;
                        }

                        .fi-sidebar-header a {
                            display: flex !important;
                            justify-content: center !important;
                            align-items: center !important;
                            background-color: white !important;
                            width: 80px !important;
                            height: 80px !important;
                            border-radius: 50% !important;
                            margin-bottom: 12px !important;
                            overflow: hidden !important;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;
                        }

                        .fi-sidebar-header::after {
                            content: 'DISKOMINFO\\A K O T A   B I N J A I';
                            white-space: pre;
                            text-align: center;
                            color: white;
                            font-weight: 800;
                            font-size: 1rem;
                            line-height: 1.2;
                            letter-spacing: 1px;
                        }

                        .fi-sidebar-header-brand { 
                            display: none !important; 
                        }

                        /* SEMBUNYIKAN TOMBOL COLLAPSE/HAMBURGER */
                        .fi-sidebar-collapse-button,
                        .fi-sidebar-close-button {
                            display: none !important;
                        }

                        /* MENU AKTIF & HOVER */
                        .fi-sidebar-item-active {
                            background-color: white !important;
                            border-radius: 8px !important;
                        }

                        .fi-sidebar-item-active *, 
                        .fi-sidebar-item-active span,
                        .fi-sidebar-item-active svg {
                            color: #000000 !important;
                            fill: #000000 !important;
                        }

                        .fi-sidebar-item:hover {
                            background-color: rgba(255, 255, 255, 0.9) !important;
                            border-radius: 8px !important;
                        }

                        .fi-sidebar-item:hover * {
                            color: #000000 !important;
                        }

                        /* SEMBUNYIKAN BADGE/NOTIFIKASI */
                        .fi-sidebar-item-badge, 
                        .fi-badge, 
                        span.fi-badge {
                            display: none !important;
                        }

                        /* OPTIMASI GRAFIK */
                        .fi-wi-chart canvas, 
                        .apexcharts-canvas, 
                        .apexcharts-svg {
                            max-height: 350px !important;
                        }

                        .fi-wi-stats-overview-stat {
                            padding: 0.75rem !important;
                        }

                        .fi-section-content {
                            padding: 1rem !important;
                        }

                        .fi-section {
                            max-height: 500px !important;
                        }

                        /* PROFIL ADMIN (POJOK KANAN ATAS) */
                        .fi-user-menu button {
                            background-color: rgba(255, 255, 255, 0.1) !important;
                            padding: 5px 12px !important;
                            border-radius: 50px !important;
                            border: 1px solid rgba(255, 255, 255, 0.2) !important;
                            transition: all 0.3s ease !important;
                        }

                        .fi-user-menu button:hover {
                            background-color: var(--primary-orange) !important;
                            border-color: var(--primary-orange) !important;
                        }

                        .fi-user-menu img, 
                        .fi-user-menu .fi-avatar {
                            border: 2px solid white !important;
                            box-shadow: 0 2px 5px rgba(0,0,0,0.3) !important;
                        }

                        .fi-user-menu .fi-avatar {
                            background-color: var(--primary-orange) !important;
                            color: white !important;
                            font-weight: bold !important;
                        }

                        /* DESAIN KHUSUS HALAMAN LOGIN */
                        .fi-simple-layout {
                            background-color: #0d3760 !important; /* Warna Background Luar */
                        }

                        .fi-simple-main-ctn {
                            border-top: 5px solid var(--primary-orange) !important;
                            border-radius: 12px !important;
                            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
                        }

                        /* Tombol Sign In agar Orange */
                        .fi-btn-color-primary {
                            background-color: var(--primary-orange) !important;
                        }

                        /* Tulisan Sign In */
                        .fi-simple-header-heading {
                            color: var(--bg-dongker) !important;
                            font-weight: 800 !important;
                            letter-spacing: -0.5px;
                        }

                        /* --- HEADER SIDEBAR & LOGO --- */
                        .fi-sidebar-header {
                            position: relative !important;
                            display: flex !important;
                            flex-direction: column !important;
                            align-items: center !important;
                            padding-top: 2rem !important;
                        }

                        .fi-sidebar-header a {
                            background-color: white !important;
                            width: 80px !important;
                            height: 80px !important;
                            border-radius: 50% !important;
                            display: flex !important;
                            justify-content: center !important;
                            align-items: center !important;
                            overflow: hidden !important;
                        }

                        /* TEKS DISKOMINFO */
                        .fi-sidebar-header::after {
                            content: 'DISKOMINFO\\A K O T A   B I N J A I';
                            white-space: pre;
                            text-align: center;
                            color: white;
                            font-weight: 800;
                            font-size: 0.9rem;
                            margin-top: 10px;
                            display: block;
                        }

                        /* --- TOMBOL HAMBURGER (PERSIS GAMBAR) --- */
                        .fi-sidebar-collapse-button {
                            display: flex !important;
                            position: absolute !important;
                            right: 10px !important;
                            top: 15px !important;
                            background-color: #FFF0EB !important; /* Warna muda orange di gambar */
                            color: var(--primary-orange) !important;
                            border-radius: 8px !important;
                            padding: 6px !important;
                            z-index: 100;
                            transition: all 0.2s;
                        }

                        /* Mengubah icon panah menjadi garis tiga (Hamburger) via CSS */
                        .fi-sidebar-collapse-button svg {
                            width: 24px !important;
                            height: 24px !important;
                        }
                        
                        /* Trik CSS: Sembunyikan icon asli, ganti dengan garis hamburger */
                        .fi-sidebar-collapse-button svg path { display: none !important; }
                        .fi-sidebar-collapse-button svg {
                            background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23FF6B35' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5' /%3E%3C/svg%3E\");
                            background-repeat: no-repeat;
                            background-position: center;
                        }

                        /* --- RESPONSIF SAAT SIDEBAR MENGECIL --- */
                        .fi-main-sidebar[style*='--sidebar-width: var(--sidebar-collapsed-width)'] .fi-sidebar-header::after {
                            display: none !important;
                        }
                        
                        /* Agar logo tetap kecil saat collapsed */
                        .fi-main-sidebar[style*='--sidebar-width: var(--sidebar-collapsed-width)'] .fi-sidebar-header a {
                            width: 45px !important;
                            height: 45px !important;
                        }

                        /* MENU ACTIVE */
                        .fi-sidebar-item-active { background-color: white !important; border-radius: 8px !important; }
                        .fi-sidebar-item-active * { color: black !important; }

                        /* Pastikan layout utama memberikan padding kiri seukuran sidebar */
.fi-layout {
    display: flex !important;
}

/* Saat sidebar terbuka (lebar normal), beri margin pada konten */
.fi-main-ctn {
    transition: all 0.3s ease-in-out;
}

@media (min-width: 1024px) {
    .fi-main {
        margin-left: 0 !important; /* Reset jika ada fixed sebelumnya */
    }
}

/* Mengatur transisi halus saat tombol hamburger diklik */
.fi-sidebar {
    transition: width 0.3s ease-in-out !important;
}
                    </style>
                "),
            )
            
            ->colors([
                'primary' => Color::Blue,
                'warning' => Color::Orange,
                'success' => '#10B981',
                'danger' => '#EF4444',
                'info' => '#3b82f6',
            ])
            
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            
            ->pages([
                Pages\Dashboard::class,
            ])
            
            ->widgets([])
            
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}