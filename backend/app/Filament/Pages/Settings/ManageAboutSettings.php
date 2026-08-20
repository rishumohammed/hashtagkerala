<?php

namespace App\Filament\Pages\Settings;

use App\Models\SiteSetting;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageAboutSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'About Us';
    protected static ?string $title = 'Manage About Us';
    protected static bool $shouldRegisterNavigation = false;

    // Use a standard blade view for the form
    protected string $view = 'filament.pages.manage-setting-form';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                TextInput::make('about_title')->label('Title')->required(),
                Textarea::make('about_content')->label('Content')->rows(4)->required(),
                Textarea::make('about_mission')->label('Mission')->rows(3)->required(),
                Textarea::make('about_vision')->label('Vision')->rows(3)->required(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Notification::make()
            ->title('About settings saved successfully')
            ->success()
            ->send();
    }
}
