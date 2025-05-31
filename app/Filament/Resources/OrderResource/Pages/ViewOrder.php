<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use App\Services\PurchaseOrderService;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('confirm')
                ->color('success')
                ->label(fn() => __('order.confirm'))
                ->action(function ($record) {
                    $record->update(['order_status' => OrderStatus::CONFIRMED]);

                    // Update all order items to confirmed status
                    $record->items()->update([
                        'status' => OrderStatus::CONFIRMED,
                        'confirmed_at' => now(),
                        'confirmed_by' => auth()->id(),
                    ]);
                })
                ->requiresConfirmation(),

            Action::make('cancel')
                ->color('warning')
                ->label(fn() => __('order.cancel'))
                ->action(function ($record) {
                    $record->update(['order_status' => OrderStatus::CANCELLED]);
                    $record->items()->update([
                        'status' => OrderStatus::CANCELLED,
                        'confirmed_at' => now(),
                        'confirmed_by' => auth()->id(),
                    ]);
                })
                ->requiresConfirmation(),
            Action::make('download')
                ->label(fn() => __('order.download_purchase_order'))
                ->icon('heroicon-o-document-arrow-down')
                ->color('info')
                ->action(function ($record) {
                    $service = app(PurchaseOrderService::class);
                    return $service->downloadPdf($record);
                }),

            Action::make('preview')
                ->label(fn() => __('order.preview'))
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn($record) => route('purchase-order.preview', $record))
                ->openUrlInNewTab(),

            Action::make('delete')
                ->color('danger')
                ->label(fn() => __('order.delete'))
                ->action('delete')
                ->icon('heroicon-o-trash')
                ->action(function ($record) {
                    $record->delete();
                    return redirect(OrderResource::getUrl('index'));
                })
                ->requiresConfirmation(),
        ];
    }
}
