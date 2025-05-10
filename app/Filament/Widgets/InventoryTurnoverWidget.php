<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\OrderItem;
use App\Models\Stock;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class InventoryTurnoverWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        // Calculate turnover rates
        $overallRate = $this->calculateTurnoverRate();
        $quarterlyRate = $this->calculateTurnoverRate(Carbon::now()->subMonths(3));
        $monthlyRate = $this->calculateTurnoverRate(Carbon::now()->subMonth());

        // Determine trend
        $trend = $monthlyRate > $quarterlyRate ? __('dashboard.trend_increasing') : __('dashboard.trend_decreasing');
        $trendColor = $monthlyRate > $quarterlyRate ? 'success' : 'danger';

        return [
            Stat::make(__('dashboard.inventory_turnover_overall'), number_format($overallRate, 2))
                ->description(__('dashboard.description_cogs_year'))
                ->color('primary'),

            Stat::make(__('dashboard.inventory_turnover_quarterly'), number_format($quarterlyRate, 2))
                ->description(__('dashboard.description_last_3_months'))
                ->color('info'),

            Stat::make(__('dashboard.inventory_turnover_monthly'), number_format($monthlyRate, 2))
                ->description(str_replace(':trend', $trend, __('dashboard.description_trend')))
                ->color($trendColor),
        ];
    }

    private function calculateTurnoverRate(?Carbon $since = null): float
    {
        // Get cost of goods sold (COGS)
        $cogs = OrderItem::query()
            ->join('books', 'order_items.book_id', '=', 'books.id')
            ->when($since, fn($query) => $query->where('order_items.created_at', '>=', $since))
            ->sum(DB::raw('order_items.quantity * books.price'));

        // Get average inventory value
        $averageInventory = Stock::query()
            ->join('books', 'stocks.book_id', '=', 'books.id')
            ->when($since, fn($query) => $query->where('stocks.updated_at', '>=', $since))
            ->avg(DB::raw('stocks.quantity * books.price'));

        if ($averageInventory === 0 || $averageInventory === null) {
            return 0;
        }

        $turnoverRate = $cogs / $averageInventory;

        if ($since) {
            $daysSince = Carbon::now()->diffInDays($since);
            if ($daysSince > 0 && $daysSince < 365) {
                $turnoverRate = $turnoverRate * (365 / $daysSince);
            }
        }

        return $turnoverRate;
    }
}
