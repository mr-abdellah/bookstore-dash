<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderItemResource\Pages;
use App\Models\OrderItem;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;
    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    public static function getLabel(): ?string
    {
        return __('sidebar.order_items');
    }

    public static function getPluralLabel(): ?string
    {
        return __('sidebar.order_items');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.orders_and_sales');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('order_id')
                    ->label(fn() => __('order_item.order_id'))
                    ->required()
                    ->maxLength(36),

                TextInput::make('book_id')
                    ->label(fn() => __('order_item.book_id'))
                    ->required()
                    ->maxLength(36),

                TextInput::make('quantity')
                    ->label(fn() => __('order_item.quantity'))
                    ->required()
                    ->numeric(),

                TextInput::make('unit_price')
                    ->label(fn() => __('order_item.unit_price'))
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_id')
                    ->label(fn() => __('order_item.order_id'))
                    ->searchable(),

                TextColumn::make('book_id')
                    ->label(fn() => __('order_item.book_id'))
                    ->searchable(),

                TextColumn::make('quantity')
                    ->label(fn() => __('order_item.quantity'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('unit_price')
                    ->label(fn() => __('order_item.unit_price'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItem::route('/create'),
            'edit' => Pages\EditOrderItem::route('/{record}/edit'),
        ];
    }
}
