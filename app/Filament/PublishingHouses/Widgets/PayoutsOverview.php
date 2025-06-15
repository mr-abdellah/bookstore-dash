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
        return 2;
    }


    protected function getStats(): array
    {
        $totalPendingPayouts = PublisherPayout::where('status', PublisherPayoutStatus::PENDING)
            ->sum('amount');

        $totalSentPayouts = PublisherPayout::where('status', PublisherPayoutStatus::SENT)
            ->sum('amount');

        return [
            Stat::make(__('order_item.total_pending_payouts'), number_format($totalPendingPayouts, 2) . ' ' . __('order_item.currency')),
            Stat::make(__('order_item.total_revenue'), number_format($totalSentPayouts, 2) . ' ' . __('order_item.currency')),
        ];
    }
}
