<?php

namespace App\Filament\Resources\GuestResource\Pages;

use App\Filament\Resources\GuestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuests extends ListRecords
{
    protected static string $resource = GuestResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         // Tombol "New Guest" sudah dihapus sesuai permintaan Anda sebelumnya
    //         Actions\Action::make('cetak_pdf')
    //             ->label('Cetak Laporan PDF')
    //             ->color('danger')
    //             ->icon('heroicon-o-printer'),
    //     ];
    // }
}