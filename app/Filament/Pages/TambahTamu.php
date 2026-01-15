<?php

namespace App\Filament\Pages;

use App\Models\Guest;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

class TambahTamu extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationLabel = 'Tambah Tamu Baru';
    protected static ?string $title = 'Input Data Tamu';
    protected static string $view = 'filament.pages.tambah-tamu';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->placeholder('Nama Lengkap'),
                TextInput::make('instansi')
                    ->required()
                    ->placeholder('Asal Instansi'),
                TextInput::make('telepon')
                    ->tel()
                    ->required()
                    ->numeric(),
                Select::make('bidang')
                    ->options([
                        'Kepala Dinas' => 'Kepala Dinas',
                        'Sekretaris' => 'Sekretaris',
                        'Umum dan Kepegawaian' => 'Umum dan Kepegawaian',
                        'Keuangan dan Program' => 'Keuangan dan Program',
                        'Informasi dan Komunikasi Publik (IKP)' => 'Informasi dan Komunikasi Publik (IKP)',
                        'Aplikasi dan Informatika (APTIKA)' => 'Aplikasi dan Informatika (APTIKA)',
                        'Statistik dan Persandian' => 'Statistik dan Persandian',
                    ])
                    ->required(),
                Textarea::make('keperluan')
                    ->required()
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();
        
        Guest::create($data);

        $this->form->fill();

        Notification::make()
            ->title('Berhasil Simpan')
            ->success()
            ->send();
    }
}