<?php

namespace App\Filament\Widgets;

use App\Models\Guest;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class GuestChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Kunjungan Mingguan';
    protected static ?int $sort = 2; // Agar muncul DI BAWAH statistik
    protected int | string | array $columnSpan = 'full'; // Agar grafik memanjang full ke samping

    protected function getData(): array
    {
        // Mengambil data 7 hari terakhir dari database
        $counts = Guest::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->pluck('count', 'date');

        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('D'); // Nama hari (Mon, Tue, dst)
            $data[] = $counts->get($date, 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Tamu per Hari',
                    'data' => $data,
                    'fill' => 'start', // Memberikan efek warna di bawah garis
                    'backgroundColor' => 'rgba(49, 46, 129, 0.1)', // Warna Navy transparan
                    'borderColor' => '#312e81', // Warna Navy solid
                    'tension' => 0.3, // Membuat garis menjadi melengkung (smooth)
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Mengubah dari 'bar' menjadi 'line'
    }
}