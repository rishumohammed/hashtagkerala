<x-filament-panels::page>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        @foreach ($this->getCards() as $card)
            <a href="{{ $card['url'] }}" style="text-decoration: none; color: inherit; display: block;">
                <x-filament::section style="height: 100%; transition: all 0.2s ease-in-out;" class="hover:shadow-md">
                    <div style="display: flex; align-items: center; gap: 1.25rem;">
                        <div style="display: flex; align-items: center; justify-content: center; width: 3rem; height: 3rem; border-radius: 0.5rem; background-color: rgba(var(--primary-500), 0.1);">
                            <x-filament::icon
                                icon="{{ $card['icon'] }}"
                                style="width: 1.75rem; height: 1.75rem; color: rgb(var(--primary-600));"
                            />
                        </div>
                        <div style="flex: 1;">
                            <h2 style="font-size: 1.125rem; font-weight: 600; margin: 0;">
                                {{ $card['title'] }}
                            </h2>
                        </div>
                        <div>
                            <x-filament::icon
                                icon="heroicon-m-chevron-right"
                                style="width: 1.25rem; height: 1.25rem; opacity: 0.5;"
                            />
                        </div>
                    </div>
                </x-filament::section>
            </a>
        @endforeach
    </div>
</x-filament-panels::page>
