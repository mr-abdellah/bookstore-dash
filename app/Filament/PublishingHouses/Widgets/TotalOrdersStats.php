<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalOrdersStats extends BaseWidget
{
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        // Total sold books
        $totalSoldBooks = OrderItem::whereIn('status', [OrderStatus::SHIPPED, OrderStatus::DELIVERED])->sum('quantity');

        // Total earnings minus platform profit (publisher's net earnings)
        $totalNetEarnings = OrderItem::whereIn('status', [OrderStatus::SHIPPED, OrderStatus::DELIVERED])
            ->get()
            ->sum(function ($item) {
                $total = $item->unit_price * $item->quantity;
                $profit = $total * ($item->profit_percentage / 100);
                return $total - $profit;
            });

        return [
            Stat::make(__('order_item.total_sold_books'), number_format($totalSoldBooks)),
            Stat::make(__('order_item.total_profit'), number_format($totalNetEarnings, 2) . ' ' . __('order_item.currency')),
        ];
    }
}
