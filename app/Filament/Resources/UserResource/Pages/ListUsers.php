<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tombol ini untuk menambah Admin baru di menu Kelola Admin
            Actions\CreateAction::make()
                ->label('Tambah Admin Baru'),
        ];
    }
}