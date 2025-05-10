<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\PlatformSettings;
use Filament\Widgets\ChartWidget;

class EarningsChartWidget extends ChartWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '300px';

    public function getHeading(): string
    {
        return __('dashboard.monthly_earnings');
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $platformPercentage = PlatformSettings::getSettings()?->profit_percentage ?? 0;

        $data = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $earnings = [];

        foreach ($data as $row) {
            $labels[] = now()->setMonth($row->month)->format('F');
            $earnings[] = round($row->total * ($platformPercentage / 100), 2);
        }

        return [
            'datasets' => [
                [
                    'label' => __('dashboard.platform_earnings'),
                    'data' => $earnings,
                    'borderColor' => '#36A2EB',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => __('dashboard.earnings_dzd'),
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => __('dashboard.month'),
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
        ];
    }
}
