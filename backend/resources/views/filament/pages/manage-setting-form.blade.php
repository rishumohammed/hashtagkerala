<x-filament-panels::page>
    <form wire:submit="submit">
        {{ $this->form }}
        
        <div style="margin-top: 1.5rem;">
            <x-filament::button type="submit" color="primary">
                Save Settings
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
