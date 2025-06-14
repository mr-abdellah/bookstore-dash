<?php

namespace App\Filament\PublishingHouses\Pages;

use App\Enums\OrderStatus;
use App\Filament\Widgets\TotalDeliveredOrdersStats;
use App\Models\OrderItem;
use App\Models\Book;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\Support\Htmlable;

class DeliveredBooks extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.publishing-houses.pages.delivered-books';

    public function getTitle(): string|Htmlable
    {
        return __('order_item.confirmed_orders');
    }
    public static function getLabel(): ?string
    {
        return __('order_item.confirmed_orders');
    }

    public static function getPluralLabel(): ?string
    {
        return __('order_item.confirmed_orders');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.orders_and_sales');
    }

    public static function getNavigationLabel(): string
    {
        return __('order_item.confirmed_orders');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) OrderItem::where('status', OrderStatus::SHIPPED)->count();
    }


    protected function getHeaderWidgets(): array
    {
        return [
            TotalDeliveredOrdersStats::class
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 2;
    }

    public function getTotalEarnings(): float
    {
        return OrderItem::where('status', OrderStatus::SHIPPED)
            ->get()
            ->sum(fn($item) => $item->unit_price * $item->quantity);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                OrderItem::query()
                    ->where('status', OrderStatus::SHIPPED)
                    ->with('book')
            )
            ->columns([
                TextColumn::make('book.title')
                    ->label(__('order_item.book_title'))
                    ->searchable(),

                TextColumn::make('quantity')
                    ->label(__('order_item.quantity')),

                TextColumn::make('unit_price')
                    ->label(__('order_item.unit_price'))
                    ->suffix(__("order_item.currency"))
                    ->badge()
                    ->color('warning'),

                TextColumn::make('total')
                    ->label(__('order_item.total_price'))
                    ->getStateUsing(fn($record) => number_format($record->unit_price * $record->quantity, 2))
                    ->suffix(__("order_item.currency"))
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                SelectFilter::make('book_id')
                    ->label(__('order_item.book_title'))
                    ->options(Book::pluck('title', 'id')->toArray()),

                SelectFilter::make('status')
                    ->label(__('order_item.status'))
                    ->options([
                        OrderStatus::SHIPPED->value => __('order_item.statuses.shipped'),
                        OrderStatus::DELIVERED->value => __('order_item.statuses.delivered'),
                    ]),
            ]);
    }
}
