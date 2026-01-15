<?php

namespace App\Filament\Widgets; 

use App\Models\Guest;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KunjunganChart extends ChartWidget
{
    protected static bool $isLazy = false;
    protected static ?string $heading = 'Statistik Kunjungan Tamu';
    protected static string $color = 'info';
    public ?string $filter = 'month'; // Filter default saat pertama dibuka

        public static function canView(): bool
    {
        // Grafik besar ini HANYA tampil jika kita berada di halaman 'statistik-kunjungan'
        return str_contains(request()->url(), 'statistik-kunjungan');
    }
    // Mengatur daftar pilihan filter di pojok kanan atas grafik
    protected function getFilters(): ?array
    {
        return [
            'week' => 'Minggu Ini',
            'month' => 'Bulan Ini',
            'year' => 'Tahun Ini',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $data = [];
        $labels = [];

        if ($activeFilter === 'week') {
            // Logika: Ambil data 7 hari terakhir
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $labels[] = $date->translatedFormat('l'); // Nama hari (Senin, Selasa...)
                $data[] = Guest::whereDate('created_at', $date)->count();
            }
        } elseif ($activeFilter === 'year') {
            // Logika: Ambil data 12 bulan terakhir
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $labels[] = $date->translatedFormat('F'); // Nama bulan (Januari, Februari...)
                $data[] = Guest::whereMonth('created_at', $date->month)
                               ->whereYear('created_at', $date->year)
                               ->count();
            }
        } else {
            // Default: 'month' (Ambil data per minggu/4 minggu dalam bulan ini)
            for ($i = 3; $i >= 0; $i--) {
                $start = Carbon::now()->subWeeks($i)->startOfWeek();
                $end = Carbon::now()->subWeeks($i)->endOfWeek();
                $labels[] = "Minggu " . (4 - $i);
                $data[] = Guest::whereBetween('created_at', [$start, $end])->count();
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengunjung',
                    'data' => $data,
                    'fill' => 'start',
                    'tension' => 0.3,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Grafik garis agar terlihat tren kenaikannya
    }
}