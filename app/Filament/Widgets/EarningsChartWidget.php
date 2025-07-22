<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PlatformSettings;
use App\Enums\OrderStatus;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EarningsChartWidget extends ChartWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

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

        // Get shipped order items for the current year
        $data = OrderItem::where('status', OrderStatus::SHIPPED)
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->selectRaw('MONTH(orders.created_at) as month, SUM(order_items.unit_price * order_items.quantity * order_items.profit_percentage / 100) as earnings')
            ->whereYear('orders.created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $earnings = [];

        // Initialize data for all months
        for ($month = 1; $month <= 12; $month++) {
            $labels[] = now()->setMonth($month)->format('F');
            $earnings[] = 0; // Default to 0
        }

        // Fill in actual earnings data
        foreach ($data as $row) {
            $monthIndex = $row->month - 1; // Adjust for 0-based array
            $earnings[$monthIndex] = round($row->earnings * ($platformPercentage / 100), 2);
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