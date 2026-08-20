<?php

namespace App\Filament\Pages\Settings;

use App\Models\SiteSetting;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;

class ManageWebsiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'Website Settings';
    protected static ?string $title = 'Manage Website Settings';
    protected static bool $shouldRegisterNavigation = false;

    // Use a standard blade view for the form
    protected string $view = 'filament.pages.manage-setting-form';

    public ?array $data = [];

    // Fields that should be handled as arrays
    protected array $arrayKeys = [
        'inquiry_statuses',
        'social_links',
    ];

    public function mount(): void
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        foreach ($this->arrayKeys as $key) {
            if (isset($settings[$key])) {
                $decoded = json_decode($settings[$key], true) ?? [];
                $settings[$key] = $decoded;
            } else {
                $settings[$key] = [];
            }
        }

        if (!isset($settings['hero_youtube_id'])) {
            $settings['hero_youtube_id'] = 'm7CR9A2sgok';
        }
        if (!isset($settings['district_card_label'])) {
            $settings['district_card_label'] = 'Signature district';
        }

        $this->form->fill($settings);
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                Section::make('Contact Information')
                    ->components([
                        TextInput::make('contact_email')->label('Email Address')->email()->required(),
                        TextInput::make('contact_phone')->label('Phone Number')->required(),
                    ])->columns(2),

                Section::make('Social Media Links')
                    ->components([
                        Repeater::make('social_links')
                            ->label('Social Profiles')
                            ->schema([
                                TextInput::make('platform')->label('Platform Name (e.g., Instagram, Facebook)')->required(),
                                TextInput::make('url')->label('Profile URL')->url()->required(),
                            ])->columns(2)
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add Social Link'),
                    ]),

                Section::make('Hero Section')
                    ->components([
                        TextInput::make('hero_youtube_id')
                            ->label('Homepage Hero YouTube Video ID')
                            ->helperText('e.g., m7CR9A2sgok (the part after v= in a YouTube URL)')
                            ->required(),
                    ]),

                Section::make('Content & Labels')
                    ->components([
                        TextInput::make('district_card_label')
                            ->label('District Card Eyebrow Label')
                            ->helperText('The small uppercase label above the district name on cards (e.g., "Signature district")')
                            ->required(),
                    ]),

                Section::make('Inquiries & Contacts')
                    ->components([
                        Repeater::make('inquiry_statuses')
                            ->label('Inquiry Statuses')
                            ->simple(TextInput::make('name')->required())
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add Status')
                            ->default([['name' => 'Open'], ['name' => 'Contacted'], ['name' => 'Interested'], ['name' => 'Converted'], ['name' => 'Rejected']]),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            if (in_array($key, $this->arrayKeys)) {
                $value = json_encode($value ?: []);
            }
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Notification::make()
            ->title('Website settings saved successfully')
            ->success()
            ->send();
    }
}
