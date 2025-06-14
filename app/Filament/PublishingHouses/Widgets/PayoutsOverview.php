<?php

namespace App\Filament\PublishingHouses\Widgets;

use App\Enums\PublisherPayoutStatus;
use App\Models\PublisherPayout;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PayoutsOverview extends BaseWidget
{
    protected static bool $isLazy = false;


    protected function getColumns(): int
    {
        return 1;
    }


    protected function getStats(): array
    {


        // Total pending payouts to publishing houses
        $totalPendingPayouts = PublisherPayout::where('status', PublisherPayoutStatus::PENDING)
            ->sum('amount');

        return [
            // Stat::make(__('order_item.total_sold_books'), number_format($totalSoldBooks)),
            Stat::make(__('order_item.total_pending_payouts'), number_format($totalPendingPayouts, 2) . ' ' . __('order_item.currency')),
        ];
    }
}
