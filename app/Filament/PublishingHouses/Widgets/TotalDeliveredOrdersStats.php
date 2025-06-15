<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use App\Models\PublisherPayout;
use App\Enums\OrderStatus;
use App\Enums\PublisherPayoutStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalDeliveredOrdersStats extends BaseWidget
{
    protected static bool $isLazy = false;

    protected function getColumns(): int
    {
        return 2;
    }


    protected function getStats(): array
    {
        // Total sold books
        $totalSoldBooks = OrderItem::whereIn('status', [OrderStatus::SHIPPED])
            ->sum('quantity');

        $totalSentPayouts = PublisherPayout::where('status', PublisherPayoutStatus::SENT)
            ->sum('amount');

        return [
            Stat::make(__('order_item.total_sold_books'), number_format($totalSoldBooks)),
            Stat::make(__('order_item.total_revenue'), number_format($totalSentPayouts, 2) . ' ' . __('order_item.currency')),
        ];
    }
}