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
            ->brandLogo(asset('images/logo-binjai.jpg'))
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
                PanelsRenderHook::HEAD_START,
                fn (): string => Blade::render('
                    <style>
                        /* Import Google Font */
                        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap");

                        :root {
                            --primary-blue: #0F4C81;
                            --secondary-blue: #1E5A8E;
                            --primary-orange: #FF6B35;
                            --secondary-orange: #FF8C42;
                            --accent-orange: #FFA366;
                            --light-orange: #FFE5D9;
                            --dark-blue: #0A3A5C;
                        }

                        * {
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                        }

                        /* FIX: DROPDOWN & MODAL Z-INDEX */
                        .fi-dropdown-panel {
                            z-index: 9999 !important;
                        }

                        /* === TOP NAVIGATION BAR STICKY === */
                        .fi-topbar {
                            position: sticky !important;
                            top: 0 !important;
                            z-index: 35 !important;
                            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #ffffff 100%) !important;
                            border-bottom: 3px solid transparent !important;
                            border-image: linear-gradient(90deg, #FF6B35, #FF8C42, #FF6B35) 1 !important;
                            box-shadow: 0 4px 20px rgba(15, 76, 129, 0.12) !important;
                            backdrop-filter: blur(10px) !important;
                        }

                        /* Memastikan konten tidak tertutup navbar sticky */
                        .fi-main {
                            overflow: visible !important;
                        }

                        /* === HAMBURGER ICON === */
                        .fi-sidebar-header button svg, 
                        .fi-sidebar-header button span svg {
                            display: none !important;
                        }

                        .fi-sidebar-header button::before {
                            content: "";
                            display: block;
                            width: 24px;
                            height: 24px;
                            background-color: currentColor;
                            -webkit-mask-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke-width=\'1.5\' stroke=\'currentColor\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5\'/%3E%3C/svg%3E");
                            mask-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke-width=\'1.5\' stroke=\'currentColor\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5\'/%3E%3C/svg%3E");
                            -webkit-mask-repeat: no-repeat;
                            mask-repeat: no-repeat;
                            -webkit-mask-position: center;
                            mask-position: center;
                            -webkit-mask-size: contain;
                            mask-size: contain;
                        }

                        .fi-sidebar-header button {
                            padding: 0.5rem !important;
                            border-radius: 12px !important;
                            background: rgba(255, 107, 53, 0.1) !important;
                        }

                        .fi-sidebar-header button:hover {
                            background: rgba(255, 107, 53, 0.25) !important;
                            transform: rotate(90deg) scale(1.1) !important;
                        }

                        /* === SIDEBAR REDESIGN === */
                        .fi-sidebar {
                            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
                            border-right: 1px solid rgba(226, 232, 240, 0.8) !important;
                            box-shadow: 8px 0 40px rgba(15, 76, 129, 0.08) !important;
                            backdrop-filter: blur(20px) !important;
                        }

                        .fi-sidebar-header {
                            padding: 1.5rem !important;
                            border-bottom: 2px solid rgba(255, 107, 53, 0.1) !important;
                        }

                        /* === NAVIGATION ITEMS === */
                        .fi-sidebar-nav-item {
                            border-radius: 12px !important;
                            margin: 0.25rem 0.75rem !important;
                        }

                        .fi-sidebar-nav-item:hover {
                            transform: translateX(4px) !important;
                        }

                        /* === BUTTONS & CARDS === */
                        .fi-btn-primary {
                            background: linear-gradient(135deg, #FF6B35 0%, #FF8C42 100%) !important;
                        }

                        /* === TABLES === */
                        .fi-table-header-cell {
                            background: #0F4C81 !important;
                            color: #ffffff !important;
                        }

                        /* === FOOTER === */
                        .fi-footer {
                            border-top: 1px solid rgba(226, 232, 240, 0.8);
                            background: #f8fafc;
                        }
                    </style>
                '),
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
            ])
            ->font('Poppins')
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
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