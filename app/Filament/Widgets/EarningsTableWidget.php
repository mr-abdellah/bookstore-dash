<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class EarningsTableWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';

    public function getTableHeading(): string
    {
        // Calculate total platform earnings for shipped items
        $cacheKey = 'earnings_table_total_' . now()->format('YmdH');
        $totalEarnings = cache()->remember($cacheKey, 300, function () {
            return OrderItem::where('status', OrderStatus::SHIPPED)
                ->selectRaw('SUM(unit_price * quantity * profit_percentage / 100)')
                ->value(DB::raw('SUM(unit_price * quantity * profit_percentage / 100)')) ?? 0;
        });

        return __('dashboard.earnings_table') . ' (Total Earnings: ' . number_format($totalEarnings, 2) . ' DZD)';
    }

    protected function getTableQuery(): Builder
    {
        return Order::query()->with('items')->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label(__('dashboard.order_id'))
                ->searchable(),

            Tables\Columns\TextColumn::make('subtotal')
                ->label(__('dashboard.total'))
                ->money('DZD')
                ->searchable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label(__('dashboard.date'))
                ->date(),

            Tables\Columns\TextColumn::make('platform_earnings')
                ->label(__('dashboard.earnings'))
                ->getStateUsing(function ($record) {
                    return $record->items()
                        ->where('status', OrderStatus::SHIPPED)
                        ->selectRaw('SUM(unit_price * quantity * profit_percentage / 100)')
                        ->value(DB::raw('SUM(unit_price * quantity * profit_percentage / 100)')) ?? 0;
                })
                ->money('DZD')
                ->searchable(),
        ];
    }
}