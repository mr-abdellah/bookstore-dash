<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Grouping\Group;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Summarizers\Sum;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('publishingHouse.logo')
                    ->label('')
                    ->circular()
                    ->size(50),
                TextColumn::make('book.title')
                    ->label(fn() => __('order_item.book_title'))
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label(fn() => __('order_item.quantity'))
                    ->numeric(),
                TextColumn::make('unit_price')
                    ->label(fn() => __('order_item.unit_price'))
                    ->numeric(),
                TextColumn::make('commission')
                    ->label(fn() => __('order_item.commission'))
                    ->numeric()
                    ->summarize(Sum::make()->label(fn() => __('order_item.total_profit'))),
                TextColumn::make('status')
                    ->label(fn() => __('order_item.status'))
                    ->formatStateUsing(fn($record) => __('order_item.status_' . $record->status->value))
                    ->badge()
                    ->color(fn($record) => match ($record->status->value) {
                        'pending' => 'warning',
                        'confirmed' => 'primary',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->icon(fn($record) => match ($record->status->value) {
                        'pending' => 'heroicon-o-clock',
                        'confirmed' => 'heroicon-o-check-circle',
                        'shipped' => 'heroicon-o-truck',
                        'delivered' => 'heroicon-o-check',
                        'cancelled' => 'heroicon-o-x-circle',
                    })
                    ->size(TextColumn\TextColumnSize::Large)
                    ->searchable(),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                // Add individual actions if needed
            ])
            ->bulkActions([
                BulkAction::make('confirm')
                    ->label(fn() => __('order_item.confirm_selected'))
                    ->action(function ($records) {
                        $records->each->update(['status' => 'confirmed']);
                    })
                    ->deselectRecordsAfterCompletion(),
                BulkAction::make('cancel')
                    ->label(fn() => __('order_item.cancel_selected'))
                    ->action(function ($records) {
                        $records->each->update(['status' => 'cancelled']);
                    })
                    ->deselectRecordsAfterCompletion(),
            ])
            ->groups([
                Group::make('status')
                    ->label(fn() => __('order_item.status'))
                    ->getTitleFromRecordUsing(fn($record) => __("order_item.status_{$record->status->value}")),
                Group::make('book.publishingHouse.name')
                    ->label(fn() => __('order_item.publishing_house'))
                    ->collapsible(),
            ])
            ->defaultGroup('book.publishingHouse.name')
        ;
    }
}