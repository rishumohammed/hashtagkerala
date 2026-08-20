<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MessageStatusChart extends ChartWidget
{
    protected ?string $heading = 'Inquiries by Status';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $statuses = ContactMessage::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $labels = $statuses->pluck('status')->toArray();
        $data = $statuses->pluck('total')->toArray();

        // Default colors mapping for common statuses
        $colorMap = [
            'Open' => '#f59e0b',       // Amber / warning
            'Contacted' => '#3b82f6',  // Blue / info
            'Interested' => '#6366f1', // Indigo / primary
            'Converted' => '#22c55e',  // Green / success
            'Rejected' => '#ef4444',   // Red / danger
        ];

        $backgroundColors = [];
        foreach ($labels as $label) {
            $backgroundColors[] = $colorMap[$label] ?? '#9ca3af'; // Gray fallback
        }

        return [
            'datasets' => [
                [
                    'label' => 'Inquiries',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
