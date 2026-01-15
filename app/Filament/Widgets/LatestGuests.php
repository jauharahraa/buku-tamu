<?php

// namespace App\Filament\Widgets;

// use App\Models\Guest;
// use Filament\Tables;
// use Filament\Tables\Table;
// use Filament\Widgets\TableWidget as BaseWidget;

// class LatestGuests extends BaseWidget
// {
//     protected static ?string $pollingInterval = '5s';
//     protected static ?int $sort = 3; 
//     protected int | string | array $columnSpan = 'full';

//     public function table(Table $table): Table
// {
//     return $table
//         ->query(Guest::query()->latest()->limit(5))
//         ->columns([
//             Tables\Columns\TextColumn::make('nama')
//                 ->label('Nama Pengunjung')
//                 ->searchable()
//                 ->weight('bold')
//                 ->icon('heroicon-m-user-circle')
//                 ->iconColor('primary'), // Ikon Biru
                
//             Tables\Columns\TextColumn::make('instansi')
//                 ->label('Asal Instansi')
//                 ->badge()
//                 ->color('gray'), // Badge abu-abu profesional
                
//             Tables\Columns\TextColumn::make('created_at')
//                 ->label('Jam Kedatangan')
//                 ->dateTime('H:i')
//                 ->badge()
//                 ->color('primary'), // Badge Biru Navy
//         ])
//         // Header warna putih bersih dengan tombol aksi kuning
//         ->headerActions([
//             Tables\Actions\Action::make('cetak')
//                 ->label('Cetak Laporan')
//                 ->icon('heroicon-m-printer')
//                 ->color('warning'), // Tombol Kuning Emas
//         ]);
