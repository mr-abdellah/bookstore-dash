<?php

namespace App\Filament\PublishingHouses\Pages;

use App\Enums\OrderStatus;
use App\Models\OrderItem;
use App\Models\Book;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;

class DeliveredBooks extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.publishing-houses.pages.delivered-books';

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.orders_and_sales');
    }

    public static function getNavigationLabel(): string
    {
        return __('order_item.confirmed_orders');
    }


    public function getTotalEarnings(): float
    {
        return OrderItem::where('status', OrderStatus::DELIVERED)
            ->get()
            ->sum(fn($item) => $item->unit_price * $item->quantity);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                OrderItem::query()
                    ->where('status', OrderStatus::DELIVERED)
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
