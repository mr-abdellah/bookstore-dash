<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Filament\Resources\OrderResource;
use App\Services\Orders\PurchaseOrderService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

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
                        'confirmed_by' => Auth::id(),
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
                        'confirmed_by' => Auth::id(),
                    ]);
                })
                ->requiresConfirmation(),

            Action::make('update-status')
                ->label(fn() => __('order.update_status'))
                ->color('info')
                ->form([
                    Select::make('order_status')
                        ->native(false)
                        ->label(__('order.status'))
                        ->options(collect(OrderStatus::cases())->pluck('value', 'value')->mapWithKeys(fn($v) => [$v => __('order.statuses.' . $v)]))
                        ->required(),
                    Select::make('payment_status')
                        ->native(false)
                        ->label(__('order.payment_status'))
                        ->options(collect(PaymentStatus::cases())->pluck('value', 'value')->mapWithKeys(fn($v) => [$v => __('order.payment_statuses.' . $v)]))
                        ->required(),
                    Select::make('payment_method')
                        ->native(false)
                        ->label(__('order.payment_method'))
                        ->options(collect(PaymentMethod::cases())->pluck('value', 'value')->mapWithKeys(fn($v) => [$v => __('order.payment_methods.' . $v)]))
                        ->required(),
                ])
                ->action(function ($data, $record) {
                    $record->update([
                        'order_status' => $data['order_status'],
                        'payment_status' => $data['payment_status'],
                        'payment_method' => $data['payment_method'],
                    ]);
                })
                ->requiresConfirmation(),


            ActionGroup::make([
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
            ])
        ];
    }
}
