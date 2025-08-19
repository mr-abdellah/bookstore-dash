<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\OrderResource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Resources\PublishingHouseResource;
use Filament\Tables\Actions\ActionGroup;

class EarningsTableWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';

    public function getTableHeading(): string
    {
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
        return Order::query()->with(['items.book', 'items.publishingHouse']);
    }

    protected function getTableColumns(): array
    {
        return [

            Tables\Columns\TextColumn::make('items.book.title')
                ->label(__('dashboard.book_title'))
                ->getStateUsing(function ($record) {
                    return $record->items->pluck('book.title')->join(', ');
                })
                ->searchable(),

            Tables\Columns\TextColumn::make('subtotal')
                ->label(__('dashboard.total'))
                ->money('DZD')
                ->badge()
                ->searchable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label(__('dashboard.date'))
                ->date(),

        ];
    }

    protected function getTableActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('view_order')
                    ->label(__('dashboard.view_order'))
                    ->icon('heroicon-o-eye')
                    ->url(function ($record) {
                        return OrderResource::getUrl('view', ['record' => $record->id]);
                    }),

                Action::make('view_publishing_house')
                    ->label(__('dashboard.view_publishing_house'))
                    ->color('secondary')
                    ->icon('heroicon-o-building-library')
                    ->url(function ($record) {
                        $publishingHouseId = $record->items->first()?->publishing_house_id;
                        return $publishingHouseId
                            ? PublishingHouseResource::getUrl('edit', ['record' => $publishingHouseId])
                            : null;
                    })
                    ->disabled(function ($record) {
                        return !$record->items->first()?->publishing_house_id;
                    }),
            ])
        ];
    }
}