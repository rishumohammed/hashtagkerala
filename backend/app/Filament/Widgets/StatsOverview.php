<?php

namespace App\Filament\Widgets;

use App\Models\Hotel;
use App\Models\Article;
use App\Models\ContactMessage;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Hotels', Hotel::count())
                ->description('Active listed properties')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('success'),
            Stat::make('Open Inquiries', ContactMessage::where('status', 'Open')->count())
                ->description('Requires attention')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('danger'),
            Stat::make('Published News', Article::where('is_published', true)->count())
                ->description('Active news articles')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('primary'),
        ];
    }
}
