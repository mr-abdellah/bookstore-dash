<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalOrdersStats extends BaseWidget
{
    protected static bool $isLazy = false;

    protected function getColumns(): int
    {
        return 1;
    }

    protected function getStats(): array
    {
        // Total confirmed order items
        $totalConfirmedOrders = OrderItem::where('status', OrderStatus::CONFIRMED)->count();

        return [
            Stat::make(__('order_item.total_new_orders'), number_format($totalConfirmedOrders)),
        ];
    }
}