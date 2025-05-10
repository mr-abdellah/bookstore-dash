<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\PlatformSettings;
use App\Models\PublishingHouse;
use App\Models\Book;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class EarningsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $platformPercentage = PlatformSettings::getSettings()?->profit_percentage ?? 0;

        // Fetch total sales and other metrics
        $totalSales = Order::sum('total');
        $platformEarnings = $totalSales * ($platformPercentage / 100);
        $sellerEarnings = $totalSales - $platformEarnings;

        $todaySales = Order::whereDate('created_at', now()->toDateString())->sum('total');
        $todayEarnings = $todaySales * ($platformPercentage / 100);

        $monthlySales = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        $monthlyEarnings = $monthlySales * ($platformPercentage / 100);

        // Counts
        $publishingHouseCount = PublishingHouse::count();
        $ordersCount = Order::count();
        $booksCount = Book::count();

        // Historical data for charts
        $totalSalesChart = $this->getHistoricalData(
            Order::query(),
            'total',
            'sum',
            fn($value) => $value
        );

        $platformEarningsChart = $this->getHistoricalData(
            Order::query(),
            'total',
            'sum',
            fn($value) => $value * ($platformPercentage / 100)
        );

        $sellerEarningsChart = $this->getHistoricalData(
            Order::query(),
            'total',
            'sum',
            fn($value) => $value * (1 - $platformPercentage / 100)
        );

        $todaySalesChart = $this->getHistoricalData(
            Order::whereDate('created_at', now()->toDateString()),
            'total',
            'sum'
        );

        $todayEarningsChart = $this->getHistoricalData(
            Order::whereDate('created_at', now()->toDateString()),
            'total',
            'sum',
            fn($value) => $value * ($platformPercentage / 100)
        );

        $monthlyEarningsChart = $this->getHistoricalData(
            Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year),
            'total',
            'sum',
            fn($value) => $value * ($platformPercentage / 100)
        );

        $publishingHousesChart = $this->getHistoricalData(
            PublishingHouse::query(),
            'id',
            'count'
        );

        $ordersChart = $this->getHistoricalData(
            Order::query(),
            'id',
            'count'
        );

        $booksChart = $this->getHistoricalData(
            Book::query(),
            'id',
            'count'
        );

        return [
            Stat::make(__('dashboard.total_sales'), number_format($totalSales, 2) . ' DZD')
                ->chart($totalSalesChart)
                ->color('success'),

            Stat::make(__('dashboard.platform_earnings'), number_format($platformEarnings, 2) . ' DZD')
                ->chart($platformEarningsChart)
                ->color('success'),

            Stat::make(__('dashboard.seller_earnings'), number_format($sellerEarnings, 2) . ' DZD')
                ->chart($sellerEarningsChart)
                ->color('success'),

            Stat::make(__('dashboard.todays_sales'), number_format($todaySales, 2) . ' DZD')
                ->chart($todaySalesChart)
                ->color('success'),

            Stat::make(__('dashboard.todays_earnings'), number_format($todayEarnings, 2) . ' DZD')
                ->chart($todayEarningsChart)
                ->color('success'),

            Stat::make(__('dashboard.monthly_earnings'), number_format($monthlyEarnings, 2) . ' DZD')
                ->chart($monthlyEarningsChart)
                ->color('success'),

            Stat::make(__('dashboard.publishing_houses'), number_format($publishingHouseCount))
                ->icon('heroicon-o-building-office')
                ->chart($publishingHousesChart)
                ->color('success'),

            Stat::make(__('dashboard.total_orders'), number_format($ordersCount))
                ->icon('heroicon-o-shopping-bag')
                ->chart($ordersChart)
                ->color('success'),

            Stat::make(__('dashboard.total_books'), number_format($booksCount))
                ->icon('heroicon-o-book-open')
                ->chart($booksChart)
                ->color('success'),
        ];
    }

    private function getHistoricalData(
        Builder $query,
        string $column,
        string $aggregateType,
        ?callable $valueModifier = null
    ): array {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $data = $query
            ->selectRaw("DATE(created_at) as date, {$aggregateType}({$column}) as value")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) use ($valueModifier) {
                $value = $valueModifier ? $valueModifier($item->value) : $item->value;
                return [
                    'date' => $item->date,
                    'value' => round($value, 2)
                ];
            })
            ->pluck('value', 'date')
            ->toArray();

        // Ensure all dates in range are present
        $result = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateString = $currentDate->toDateString();
            $result[$dateString] = $data[$dateString] ?? 0;
            $currentDate->addDay();
        }

        return array_values($result);
    }
}
