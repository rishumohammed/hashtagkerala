<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Schemas\Schema;

class ArticleForm
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
                    ->unique(\App\Models\Article::class, 'slug', ignoreRecord: true),
                \Filament\Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('articles')
                    ->disk('public'),
                \Filament\Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                \Filament\Forms\Components\Toggle::make('is_published')
                    ->required(),
                \Filament\Forms\Components\DateTimePicker::make('published_at'),
            ]);
    }
}
