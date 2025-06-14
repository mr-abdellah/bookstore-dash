<?php

namespace App\Filament\PublishingHouses\Pages;

use App\Enums\OrderStatus;
use App\Filament\Widgets\TotalOrdersStats;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use App\Models\OrderItem;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Support\Htmlable;

class NewOrders extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static string $view = 'filament.publishing-houses.pages.new-orders';

    public function getTitle(): string|Htmlable
    {
        return __('order_item.new_orders');
    }

    public static function getNavigationLabel(): string
    {
        return __('order_item.new_orders');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.orders_and_sales');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) OrderItem::where('status', OrderStatus::CONFIRMED)->count();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TotalOrdersStats::class
        ];
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                OrderItem::query()
                    ->where('status', OrderStatus::CONFIRMED)
                    ->with('book')
            )
            ->columns([
                TextColumn::make('book.title')
                    ->label(__('order_item.book_title')),

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
            ->actions([
                Action::make('markAsShipped')
                    ->label(__('order_item.mark_as_shipped'))
                    ->color('primary')
                    ->icon('heroicon-o-truck')
                    ->visible(fn($record) => $record->status === OrderStatus::CONFIRMED)
                    ->requiresConfirmation()
                    ->action(function (OrderItem $record) {
                        $record->status = OrderStatus::SHIPPED;
                        $record->save();
                    }),
            ])
            ->bulkActions([
                BulkAction::make('markAsShipped')
                    ->label(__('order_item.mark_as_shipped'))
                    ->icon('heroicon-o-truck')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        foreach ($records as $record) {
                            if ($record->status === OrderStatus::CONFIRMED) {
                                $record->status = OrderStatus::SHIPPED;
                                $record->save();
                            }
                        }
                    }),
            ]);
        ;
    }
}
