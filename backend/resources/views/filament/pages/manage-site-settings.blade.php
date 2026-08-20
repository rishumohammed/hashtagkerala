<x-filament-panels::page>
    <form wire:submit="submit">
        {{ $this->form }}
        
        <div class="mt-4 text-right">
            <x-filament::button type="submit" color="primary">
                Save Settings
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
