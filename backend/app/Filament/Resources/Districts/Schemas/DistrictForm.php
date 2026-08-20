<?php

namespace App\Filament\Resources\Districts\Schemas;

use Filament\Schemas\Schema;

class DistrictForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, \Filament\Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                \Filament\Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->unique(\App\Models\District::class, 'slug', ignoreRecord: true),
                \Filament\Forms\Components\Textarea::make('subtitle')
                    ->rows(3),
                \Filament\Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->imageEditor()
                    ->directory('districts')
                    ->disk('public'),
            ]);
    }
}
