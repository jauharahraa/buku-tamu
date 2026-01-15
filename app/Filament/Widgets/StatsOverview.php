<?php

namespace App\Filament\Widgets;

use App\Models\Guest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

  protected function getStats(): array
{
    return [
        // Menggunakan whereDate agar tamu yang terdaftar hari ini (6 orang) terhitung semua
        Stat::make('Tamu Hari Ini', \App\Models\Guest::whereDate('created_at', now())->count())
            ->description('Total kunjungan tanggal ' . now()->format('d/m/Y'))
            ->descriptionIcon('heroicon-m-user-group')
            ->color('success')
            ->chart([7, 3, 4, 5, 6, 3, 6]), // Garis grafik kecil bawah

        // Menghitung akumulasi dalam 7 hari terakhir
        Stat::make('Tamu Minggu Ini', \App\Models\Guest::where('created_at', '>=', now()->subDays(7))->count())
            ->description('Total akumulasi minggu ini')
            ->color('info'),

        // Menghitung seluruh data tanpa filter
        Stat::make('Total Seluruh Tamu', \App\Models\Guest::count())
            ->description('Total database tamu')
            ->descriptionIcon('heroicon-m-circle-stack')
            ->color('primary'),
    ];
}
}