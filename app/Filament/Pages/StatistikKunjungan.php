<?php

namespace App\Filament\Pages;

use App\Models\Guest;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Filament\Widgets\KunjunganChart;
use Illuminate\Support\Carbon;

class StatistikKunjungan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Statistik Kunjungan';
    protected static ?string $title = 'Laporan Statistik';

    // WAJIB ADA: Pastikan baris ini merujuk ke file blade yang benar
    protected static string $view = 'filament.pages.statistik-kunjungan';

    protected function getHeaderWidgets(): array
    {
        return [
            KunjunganChart::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cetak_statistik')
                ->label('Download Laporan Statistik')
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->action(function () {
                    $data = [
                        'hari_ini' => Guest::whereDate('created_at', Carbon::today())->count(),
                        'minggu_ini' => Guest::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
                        'bulan_ini' => Guest::whereMonth('created_at', Carbon::now()->month)->count(),
                        'total' => Guest::count(),
                        'tanggal_cetak' => Carbon::now()->translatedFormat('d F Y H:i'),
                    ];

                    $pdf = Pdf::loadView('pdf.statistik', $data);
                    
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'statistik-kunjungan-' . date('Y-m-d') . '.pdf'
                    );
                }),
        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }
}