<?php

namespace App\Filament\Widgets;

use App\Models\Guest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    // Tambahkan baris ini agar dashboard refresh angka setiap 15 detik
    protected static ?string $pollingInterval = '15s'; 

    protected function getStats(): array
    {
        return [
            // Tamu Hari Ini
            Stat::make('Tamu Hari Ini', Guest::whereDate('created_at', Carbon::today())->count())
                ->description('Total kunjungan tanggal ' . now()->format('d/m/Y'))
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([3, 5, 4, 6, 4, 8, 6]),

            // Tamu Minggu Ini (7 Hari Terakhir)
            Stat::make('Tamu Minggu Ini', Guest::where('created_at', '>=', now()->subDays(7))->count())
                ->description('Total akumulasi 7 hari terakhir')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),

            // Total Seluruh Tamu (Paling Akurat)
            Stat::make('Total Seluruh Tamu', Guest::count())
                ->description('Total database tamu aktif')
                ->descriptionIcon('heroicon-m-circle-stack')
                ->color('primary'),
        ];
    }
}