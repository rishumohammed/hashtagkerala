<?php

namespace App\Filament\Resources\Hotels\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class HotelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('image_path')
                    ->disk('public')
                    ->label('Image'),
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('district.title')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('category')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('district_id')
                    ->label('District')
                    ->relationship('district', 'title'),
                \Filament\Tables\Filters\SelectFilter::make('category')
                    ->options(function () {
                        $settings = \App\Models\SiteSetting::pluck('value', 'key')->toArray();
                        $arr = isset($settings['hotel_categories']) ? json_decode($settings['hotel_categories'], true) : [];
                        if (!is_array($arr)) return [];
                        return collect($arr)->mapWithKeys(fn($item) => [$item => $item])->toArray();
                    }),
            ], layout: \Filament\Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(2)
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
