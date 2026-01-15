<x-filament-panels::page>
    <form wire:submit="create">
        {{ $this->form }}
        
        <div class="mt-6">
            <x-filament::button type="submit" class="w-full">
                Simpan Data Tamu
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>