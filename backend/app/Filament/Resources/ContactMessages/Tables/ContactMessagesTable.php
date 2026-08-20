<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('subject')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Open' => 'warning',
                        'Contacted' => 'info',
                        'Interested' => 'primary',
                        'Converted' => 'success',
                        'Rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options(function () {
                        $settings = \App\Models\SiteSetting::pluck('value', 'key')->toArray();
                        $arr = isset($settings['inquiry_statuses']) ? json_decode($settings['inquiry_statuses'], true) : [];
                        if (empty($arr)) {
                            $arr = ['Open', 'Contacted', 'Interested', 'Converted', 'Rejected'];
                        }
                        return collect($arr)->mapWithKeys(fn($item) => [
                            (is_array($item) ? $item['name'] : $item) => (is_array($item) ? $item['name'] : $item)
                        ])->toArray();
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
