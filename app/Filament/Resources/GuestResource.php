<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestResource\Pages;
use App\Models\Guest;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action; 
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout; // Tambahkan import ini
use Barryvdh\DomPDF\Facade\Pdf;      
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon; 

class GuestResource extends Resource
{
    protected static ?string $model = Guest::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Daftar Tamu';
    protected static ?string $pluralModelLabel = 'Daftar Tamu';

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::whereDate('created_at', now()->today())->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getNavigationBadge() > 0 ? 'success' : 'gray';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\TextInput::make('nama')->required(),
            \Filament\Forms\Components\TextInput::make('instansi'),
            \Filament\Forms\Components\TextInput::make('telepon'),
            \Filament\Forms\Components\Select::make('bidang')
                ->options([
                    'Kepala Dinas' => 'Kepala Dinas',
                    'Sekretaris' => 'Sekretaris',
                    'Umum dan Kepegawaian' => 'Umum dan Kepegawaian',
                    'Keuangan dan Program' => 'Keuangan dan Program',
                    'Aplikasi dan Informatika (APTIKA)' => 'Aplikasi dan Informatika (APTIKA)',
                    'Informasi dan Komunikasi Publik (IKP)' => 'Informasi dan Komunikasi Publik (IKP)',
                    'Statistik dan Persandian' => 'Statistik dan Persandian',
                ]),
            \Filament\Forms\Components\Textarea::make('keperluan'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id') 
                    ->label('ID Kunjungan')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->formatStateUsing(fn (string $state): string => "#" . str_pad($state, 5, '0', STR_PAD_LEFT))
                    ->color('primary')
                    ->weight('bold')
                    ->fontFamily('mono'),

                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->weight('bold')
                    ->color('primary')
                    ->label('Nama Pengunjung'),
                
                Tables\Columns\TextColumn::make('instansi')
                    ->label('Asal Instansi')
                    ->icon('heroicon-m-building-office')
                    ->iconColor('gray'),

                Tables\Columns\TextColumn::make('bidang')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Kepala Dinas', 'Sekretaris' => 'warning',
                        'Aplikasi dan Informatika (APTIKA)' => 'info',
                        'Informasi dan Komunikasi Publik (IKP)' => 'success',
                        default => 'primary',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Kedatangan')
                    ->dateTime('d M Y')
                    ->description(fn ($record) => $record->created_at->format('H:i') . ' WIB')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('periode')
                    ->label('Filter Statistik')
                    ->options([
                        'minggu' => 'Minggu Ini',
                        'bulan' => 'Bulan Ini',
                        'tahun' => 'Tahun Ini',
                    ])
                    ->native(false)
                    ->query(function (Builder $query, array $data): Builder {
                        $value = $data['value'] ?? null;
                        return $query->when($value, function (Builder $query, $value) {
                            if ($value === 'minggu') {
                                return $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                            }
                            if ($value === 'bulan') {
                                return $query->whereMonth('created_at', Carbon::now()->month)
                                            ->whereYear('created_at', Carbon::now()->year);
                            }
                            if ($value === 'tahun') {
                                return $query->whereYear('created_at', Carbon::now()->year);
                            }
                            return $query;
                        });
                    }),

                SelectFilter::make('bidang')
                    ->label('Filter Bidang')
                    ->options([
                        'Kepala Dinas' => 'Kepala Dinas',
                        'Sekretaris' => 'Sekretaris',
                        'Umum dan Kepegawaian' => 'Umum dan Kepegawaian',
                        'Keuangan dan Program' => 'Keuangan dan Program',
                        'Informasi dan Komunikasi Publik (IKP)' => 'Informasi dan Komunikasi Publik (IKP)',
                        'Aplikasi dan Informatika (APTIKA)' => 'Aplikasi dan Informatika (APTIKA)',
                        'Statistik dan Persandian' => 'Statistik dan Persandian',
                    ])
                    ->native(false),

                Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('dari_tanggal')->label('Dari Tanggal'),
                        \Filament\Forms\Components\DatePicker::make('sampai_tanggal')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ], layout: FiltersLayout::Modal) // MENGUBAH LAYOUT MENJADI MODAL (Icon kecil di samping search)
            ->filtersTriggerAction(
                fn (Tables\Actions\Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->headerActions([
                Action::make('cetak_pdf')
                    ->label('Cetak Laporan PDF')
                    ->icon('heroicon-o-printer')
                    ->color('warning')
                    ->action(function (Tables\Contracts\HasTable $livewire) {
                        $records = $livewire->getFilteredTableQuery()->get(); 
                        $pdf = Pdf::loadView('pdf.laporan', ['guests' => $records]);
                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'laporan-tamu-' . date('Y-m-d') . '.pdf'
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus') 
                    ->modalHeading('Hapus Data Tamu') 
                    ->successNotificationTitle('Data tamu berhasil dihapus'),
                ])
                ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuests::route('/'),
            'create' => Pages\CreateGuest::route('/create'), 
            'edit' => Pages\EditGuest::route('/{record}/edit'),
        ];
    }
}