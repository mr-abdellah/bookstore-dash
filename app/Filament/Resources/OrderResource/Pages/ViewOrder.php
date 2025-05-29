<?php

namespace App\Filament\Resources\OrderResource\Pages;

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
            Action::make('download')
                ->label('Télécharger Bon de Commande')
                ->icon('heroicon-o-document-arrow-down')
                ->color('primary')
                ->action(function ($record) {
                    $service = app(PurchaseOrderService::class);
                    return $service->downloadPdf($record);
                }),

            Action::make('preview')
                ->label('Aperçu')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn($record) => route('purchase-order.preview', $record))
                ->openUrlInNewTab(),

            Action::make('delete')
                ->color('danger')
                ->action('delete')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation(),
        ];
    }
}