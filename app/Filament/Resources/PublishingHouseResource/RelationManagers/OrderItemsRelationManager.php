<?php

namespace App\Filament\Resources\PublishingHouseResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;


class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    // protected static ?string $title = __('order_item.heading');

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('order_item.heading');
    }
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('book.title')
                    ->label(__('order_item.book_title'))
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('order_item.quantity'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->label(__('order_item.unit_price'))
                    ->numeric()
                    ->sortable()
                    ->suffix(' ' . __('order_item.currency')),


                Tables\Columns\TextColumn::make('profit_percentage')
                    ->label(__('order_item.profit_percentage'))
                    ->formatStateUsing(
                        fn($state) =>
                        $state !== null
                        ? rtrim(rtrim(number_format((float) $state, 2, '.', ''), '0'), '.') . '%'
                        : '-'
                    ),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('order_item.status'))
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        if (is_null($state))
                            return '-';
                        if (is_string($state))
                            return $state;
                        if (is_object($state) && property_exists($state, 'value'))
                            return (string) $state->value;
                        if (is_object($state) && method_exists($state, 'value'))
                            return (string) $state->value();
                        return (string) $state;
                    }),
                Tables\Columns\TextColumn::make('confirmed_at')
                    ->label(__('order_item.confirm_selected'))
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()->hidden(),
                Tables\Actions\DeleteAction::make()->hidden(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->hidden(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return true;
    }
}
