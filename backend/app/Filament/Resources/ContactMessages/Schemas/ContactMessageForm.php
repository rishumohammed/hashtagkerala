<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Inquiry Details')
                    ->components([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('email')
                            ->email()
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('phone')
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('subject')
                            ->columnSpanFull()
                            ->disabled(),
                        \Filament\Forms\Components\Textarea::make('message')
                            ->columnSpanFull()
                            ->rows(5)
                            ->disabled(),
                        \Filament\Forms\Components\Select::make('status')
                            ->options(function () {
                                $settings = \App\Models\SiteSetting::pluck('value', 'key')->toArray();
                                $arr = isset($settings['inquiry_statuses']) ? json_decode($settings['inquiry_statuses'], true) : [];
                                if (empty($arr)) {
                                    $arr = ['Open', 'Contacted', 'Interested', 'Converted', 'Rejected'];
                                }
                                return collect($arr)->mapWithKeys(fn($item) => [
                                    (is_array($item) ? $item['name'] : $item) => (is_array($item) ? $item['name'] : $item)
                                ])->toArray();
                            })
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
