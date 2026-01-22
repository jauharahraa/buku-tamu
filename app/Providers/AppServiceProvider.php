<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Tambahkan import Filament di bawah ini
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Konfigurasi warna Filament
        FilamentColor::register([
            'primary' => Color::Blue,
            'warning' => Color::Orange,
        ]);
    }
}