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
            // --- RENDER HOOK UNTUK FOOTER & STICKY NAVBAR ---
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn (): string => Blade::render('
                    <footer class="fi-footer p-6 text-center text-sm text-gray-500">
                        <p>© Copyright <strong>Pemko Binjai</strong>. All Rights Reserved</p>
                        <p class="mt-1">Designed by <span style="color: #FF6B35; font-weight: 600;">Kominfo</span></p>
                    </footer>
                '),
            )
->renderHook(
    'panels::head.end',
    fn () => new \Illuminate\Support\HtmlString("
        <style>
            :root {
                --bg-dongker: #0f172a; 
                --primary-orange: #FF6B35;
            }

            /* 1. SIDEBAR & NAVBAR DASAR */
            .fi-sidebar, .fi-sidebar-header, .fi-layout header.fi-topbar {
                background-color: var(--bg-dongker) !important;
            }

            .fi-sidebar {
                border-right: 3px solid var(--primary-orange) !important;
            }

            /* 2. WARNA FONT DEFAULT */
            .fi-sidebar nav * {
                color: white !important;
            }

            /* KHUSUS NAV BAR (TOPBAR) JADI HITAM */
            .fi-topbar *:not(.fi-dropdown *), .fi-topbar svg:not(.fi-dropdown *) {
                color: #000000 !important;
            }
            
            .fi-dropdown-list-item-label, 
            .fi-dropdown-list-item-icon {
                color: #334155 !important;
            }

            /* 3. LOGO SIDEBAR & TEKS */
            .fi-sidebar-header {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                padding: 3rem 1rem 2rem !important;
                min-height: 220px !important;
            }

            .fi-sidebar-header a {
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                background-color: white !important;
                width: 90px !important;
                height: 90px !important;
                border-radius: 50% !important;
                margin-bottom: 15px !important;
                overflow: hidden !important;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;
            }

            .fi-sidebar-header::after {
                content: 'DISKOMINFO\\A K O T A   B I N J A I';
                white-space: pre;
                text-align: center;
                color: white;
                font-weight: 800;
                font-size: 1.1rem;
                line-height: 1.2;
                letter-spacing: 1px;
            }

            .fi-sidebar-header-brand { display: none !important; }

            /* 4. NAVBAR (TOPBAR) */
            .fi-topbar button {
                order: -1 !important;
                margin-right: auto !important;
            }

            /* 5. MENU AKTIF & HOVER */
            .fi-sidebar-item-active,
            .fi-sidebar-item:hover:not(.fi-sidebar-item-active) { 
                background-color: white !important; 
            }

            .fi-sidebar-item-active *, 
            .fi-sidebar-item:hover * {
                color: #000000 !important;
            }

            /* 7. ICON HAMBURGER */
            .fi-sidebar-collapse-button svg,
            .fi-sidebar-close-button svg {
                display: none !important;
            }

            .fi-sidebar-collapse-button::before,
            .fi-sidebar-close-button::before {
                content: '';
                display: block;
                width: 24px;
                height: 24px;
                background-color: var(--primary-orange) !important;
                -webkit-mask-image: url(\"data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke-width=%271.5%27 stroke=%27currentColor%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 d=%27M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5%27/%3E%3C/svg%3E\");
                mask-image: url(\"data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke-width=%271.5%27 stroke=%27currentColor%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 d=%27M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5%27/%3E%3C/svg%3E\");
                mask-repeat: no-repeat;
                mask-size: contain;
            }

            /* 8. BADGE ANGKA HITAM */
            .fi-sidebar-item-badge {
                display: flex !important;
                background-color: #f1f5f9 !important;
                border-radius: 6px !important;
                padding: 0px 6px !important;
            }

            .fi-sidebar-item-badge span {
                color: #000000 !important;
                font-weight: bold !important;
            }

            /* 9. PERBAIKAN GRAFIK AGAR FIT DI LAYAR */
            .fi-wi-chart canvas {
                max-height: 280px !important; /* Membatasi tinggi grafik */
            }

            .fi-wi-stats-overview-stat {
                margin-bottom: 0.5rem !important; /* Mengecilkan jarak antar card statistik */
            }
        </style>
    "),
)
            ->colors([
                'primary' => [
                    50 => '#e8f4ff',
                    100 => '#d4e9ff',
                    200 => '#a9d3ff',
                    300 => '#7ebdff',
                    400 => '#53a7ff',
                    500 => '#1E5A8E',
                    600 => '#0F4C81',
                    700 => '#0A3A5C',
                    800 => '#062D47',
                    900 => '#042033',
                    950 => '#02131F',
                ],
                'warning' => '#FF8C42',
                'success' => '#10B981',
                'danger' => '#EF4444',
                'info' => '#3b82f6',
                'primary' => Color::Blue,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->font('Poppins')
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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