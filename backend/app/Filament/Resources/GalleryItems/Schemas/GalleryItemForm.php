<?php

namespace App\Filament\Resources\GalleryItems\Schemas;

use Filament\Schemas\Schema;

class GalleryItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('title'),
                \Filament\Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('gallery')
                    ->disk('public')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
