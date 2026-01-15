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
            ->brandName('E-Tamu Diskominfo Binjai')
            ->brandLogo(asset('images/logo-binjai.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('favicon.ico'))
            
            // --- CUSTOM CSS UNTUK MENGUBAH IKON PANAH SIDEBAR MENJADI HAMBURGER ---
            // ->renderHook(
            //     \Filament\View\PanelsRenderHook::HEAD_START,
            //     fn (): string => \Illuminate\Support\Facades\Blade::render('
            //         <style>
            //             /* 1. Sembunyikan ikon panah asli bawaan Filament */
            //             .fi-sidebar-header button svg {
            //                 display: none !important;
            //             }

            //             /* 2. Atur tata letak Header: Hamburger Kiri, Logo Kanan */
            //             .fi-sidebar-header {
            //                 display: flex !important;
            //                 flex-direction: row-reverse !important; 
            //                 justify-content: flex-end !important;
            //                 align-items: center !important;
            //                 gap: 12px !important;
            //                 padding: 0.5rem 1rem !important;
            //             }

            //             /* 3. Pastikan tombol navigasi tetap ada dan berbentuk lingkaran */
            //             .fi-sidebar-header button {
            //                 display: flex !important;
            //                 visibility: visible !important;
            //                 opacity: 1 !important;
            //                 width: 40px !important;
            //                 height: 40px !important;
            //                 border-radius: 50% !important;
            //                 flex-shrink: 0 !important;
            //                 align-items: center;
            //                 justify-content: center;
            //                 background-color: transparent !important;
            //                 transition: background-color 0.2s;
            //                 position: relative !important;
            //             }

            //             .fi-sidebar-header button:hover {
            //                 background-color: rgba(13, 13, 13, 0.05) !important;
            //             }

            //             /* 4. Suntikkan Ikon Hamburger (Bars-3) Abu-abu Gelap */
            //             .fi-sidebar-header button::after {
            //                 content: "";
            //                 position: absolute;
            //                 width: 24px;
            //                 height: 24px;
            //                 background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%235f6368\' stroke-width=\'2\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5\' /></svg>");
            //                 background-repeat: no-repeat;
            //                 background-position: center;
            //                 background-size: contain;
            //                 display: block !important;
            //             }

            //             /* 5. Rapikan tampilan Logo Diskominfo */
            //             .fi-sidebar-header a img {
            //                 max-height: 2.2rem !important;
            //                 width: auto !important;
            //             }
            //         </style>
            //     '),
            // )
            ->colors([
                'primary' => [
                    50 => '238, 242, 255',
                    100 => '224, 231, 255',
                    200 => '199, 210, 254',
                    300 => '165, 180, 252',
                    400 => '129, 140, 248',
                    500 => '#1E3A8A',
                    600 => '#1E40AF',
                    700 => '#1D4ED8',
                    800 => '#1E40AF',
                    900 => '#1E3A8A',
                    950 => '#172554',
                ],
                'warning' => '#FBBF24',
                'success' => '#10B981',
                'danger' => '#EF4444',
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
             ->widgets([
            //     Widgets\AccountWidget::class,
            ])
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