<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\PlatformSettings;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;


class EarningsTableWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Order::query()->latest();
    }

    public function getTableHeading(): string
    {
        return __('dashboard.earnings_table');
    }

    protected function getTableColumns(): array
    {
        $platformPercentage = PlatformSettings::getSettings()?->profit_percentage ?? 0;

        return [
            Tables\Columns\TextColumn::make('id')
                ->label(__('dashboard.order_id'))
                ->searchable(),

            Tables\Columns\TextColumn::make('total')
                ->label(__('dashboard.total'))
                ->money('DZD')
                ->searchable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label(__('dashboard.date'))
                ->date(),

            Tables\Columns\TextColumn::make('platform_earnings')
                ->label(__('dashboard.earnings'))
                ->getStateUsing(fn($record) => round($record->total * ($platformPercentage / 100), 2))
                ->money('DZD')
                ->searchable(),
        ];
    }
}
