<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ManageSiteSettings extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Settings';
    protected static ?string $title = 'Site Settings';
    protected static ?int $navigationSort = 6;
    
    // The view rendering the cards grid
    protected string $view = 'filament.pages.settings-hub';

    public function getCards(): array
    {
        return [
            [
                'title' => 'About Us',
                'description' => 'Manage the content, mission, and vision statements for the About page.',
                'icon' => 'heroicon-o-information-circle',
                'url' => \App\Filament\Pages\Settings\ManageAboutSettings::getUrl(),
            ],
            [
                'title' => 'Website Settings',
                'description' => 'Manage global website configurations, hero video, and inquiries.',
                'icon' => 'heroicon-o-globe-alt',
                'url' => \App\Filament\Pages\Settings\ManageWebsiteSettings::getUrl(),
            ],
            [
                'title' => 'Hotel Configurations',
                'description' => 'Manage global options for amenities, room types, and categories.',
                'icon' => 'heroicon-o-building-office-2',
                'url' => \App\Filament\Pages\Settings\ManageHotelSettings::getUrl(),
            ],
        ];
    }
}
