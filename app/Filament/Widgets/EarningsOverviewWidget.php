<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use App\Models\PublishingHouse;
use App\Enums\OrderStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class EarningsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        // Cache main queries for 5 minutes
        $cacheKey = 'earnings_overview_' . now()->format('YmdH');

        $data = cache()->remember($cacheKey, 300, function () use ($startDate, $endDate) {
            $ordersQuery = Order::query()
                ->with('items')
                ->whereBetween('created_at', [$startDate, $endDate]);

            // Calculate totals in PHP since total is an accessor
            $totalSales = Order::with('items')->get()->sum('subtotal'); // Use subtotal instead of total
            $platformEarnings = OrderItem::where('status', OrderStatus::SHIPPED)
                ->selectRaw('SUM(unit_price * quantity * profit_percentage / 100)')
                ->value(DB::raw('SUM(unit_price * quantity * profit_percentage / 100)')) ?? 0;

            $todayOrders = $ordersQuery->clone()->whereDate('created_at', now()->toDateString());
            $monthlyOrders = $ordersQuery->clone()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);

            return [
                'total_sales' => $totalSales,
                'platform_earnings' => $platformEarnings,
                'today_sales' => $todayOrders->get()->sum('subtotal'),
                'today_earnings' => $this->calculatePlatformEarnings($todayOrders->pluck('id')),
                'monthly_sales' => $monthlyOrders->get()->sum('subtotal'),
                'monthly_earnings' => $this->calculatePlatformEarnings($monthlyOrders->pluck('id')),
                'counts' => [
                    'publishing_houses' => PublishingHouse::count(),
                    'orders' => Order::count(),
                    'books' => Book::count(),
                ],
                'charts' => [
                    'total_sales' => $this->getHistoricalSalesData($ordersQuery),
                    'platform_earnings' => $this->getHistoricalPlatformEarningsData($ordersQuery),
                    'seller_earnings' => $this->getHistoricalSellerEarningsData($ordersQuery),
                    'today_sales' => $this->getHistoricalSalesData($todayOrders),
                    'today_earnings' => $this->getHistoricalPlatformEarningsData($todayOrders),
                    'monthly_earnings' => $this->getHistoricalPlatformEarningsData($monthlyOrders),
                    'publishing_houses' => $this->getHistoricalData(PublishingHouse::query(), 'id', 'count'),
                    'orders' => $this->getHistoricalData(Order::query(), 'id', 'count'),
                    'books' => $this->getHistoricalData(Book::query(), 'id', 'count'),
                ]
            ];
        });

        return [
            Stat::make(__('dashboard.total_sales'), number_format($data['total_sales'], 2) . ' DZD')
                ->chart($data['charts']['total_sales'])
                ->color('success'),
            Stat::make(__('dashboard.platform_earnings'), number_format($data['platform_earnings'], 2) . ' DZD')
                ->chart($data['charts']['platform_earnings'])
                ->color('success'),
            Stat::make(__('dashboard.seller_earnings'), number_format($data['total_sales'] - $data['platform_earnings'], 2) . ' DZD')
                ->chart($data['charts']['seller_earnings'])
                ->color('success'),
            Stat::make(__('dashboard.todays_sales'), number_format($data['today_sales'], 2) . ' DZD')
                ->chart($data['charts']['today_sales'])
                ->color('success'),
            Stat::make(__('dashboard.todays_earnings'), number_format($data['today_earnings'], 2) . ' DZD')
                ->chart($data['charts']['today_earnings'])
                ->color('success'),
            Stat::make(__('dashboard.monthly_earnings'), number_format($data['monthly_earnings'], 2) . ' DZD')
                ->chart($data['charts']['monthly_earnings'])
                ->color('success'),
            Stat::make(__('dashboard.publishing_houses'), number_format($data['counts']['publishing_houses']))
                ->icon('heroicon-o-building-office')
                ->chart($data['charts']['publishing_houses'])
                ->color('success'),
            Stat::make(__('dashboard.total_orders'), number_format($data['counts']['orders']))
                ->icon('heroicon-o-shopping-bag')
                ->chart($data['charts']['orders'])
                ->color('success'),
            Stat::make(__('dashboard.total_books'), number_format($data['counts']['books']))
                ->icon('heroicon-o-book-open')
                ->chart($data['charts']['books'])
                ->color('success'),
        ];
    }

    private function calculatePlatformEarnings($orderIds): float
    {
        if (empty($orderIds)) {
            return 0;
        }

        return OrderItem::whereIn('order_id', $orderIds)
            ->where('status', OrderStatus::SHIPPED)
            ->selectRaw('SUM(unit_price * quantity * profit_percentage / 100)')
            ->value(DB::raw('SUM(unit_price * quantity * profit_percentage / 100)')) ?? 0;
    }

    private function getHistoricalSalesData(Builder $baseQuery): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $data = $baseQuery->clone()
            ->with('items')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(fn($order) => $order->created_at->toDateString())
            ->map(fn($orders) => $orders->sum('subtotal'))
            ->toArray();

        return $this->fillMissingDates($data, $startDate, $endDate);
    }

    private function getHistoricalPlatformEarningsData(Builder $baseQuery): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $orderIds = $baseQuery->clone()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->pluck('id');

        if ($orderIds->isEmpty()) {
            return array_fill(0, 7, 0);
        }

        $data = OrderItem::whereIn('order_id', $orderIds)
            ->where('status', OrderStatus::SHIPPED)
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->selectRaw('DATE(orders.created_at) as date, SUM(order_items.unit_price * order_items.quantity * order_items.profit_percentage / 100) as commission')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('commission', 'date')
            ->toArray();

        return $this->fillMissingDates($data, $startDate, $endDate);
    }

    private function getHistoricalSellerEarningsData(Builder $baseQuery): array
    {
        $salesData = $this->getHistoricalSalesData($baseQuery);
        $platformData = $this->getHistoricalPlatformEarningsData($baseQuery);

        return array_map(fn($sales, $platform) => round($sales - $platform, 2), $salesData, $platformData);
    }

    private function getHistoricalData(Builder $query, string $column, string $aggregateType): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $data = $query->clone()
            ->selectRaw("DATE(created_at) as date, {$aggregateType}({$column}) as value")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('value', 'date')
            ->toArray();

        return $this->fillMissingDates($data, $startDate, $endDate);
    }

    private function fillMissingDates(array $data, $startDate, $endDate): array
    {
        $result = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateString = $currentDate->toDateString();
            $result[] = round($data[$dateString] ?? 0, 2);
            $currentDate->addDay();
        }
        return $result;
    }
}