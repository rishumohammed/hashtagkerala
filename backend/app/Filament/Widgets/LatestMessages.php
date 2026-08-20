<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestMessages extends TableWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->limit(50),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
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
            ])
            ->paginated(false);
    }
}
