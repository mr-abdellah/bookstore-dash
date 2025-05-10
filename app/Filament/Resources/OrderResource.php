<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function getLabel(): ?string
    {
        return __('sidebar.orders');
    }

    public static function getPluralLabel(): ?string
    {
        return __('sidebar.orders');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.orders_and_sales');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(fn() => __('order.user_id'))
                    ->relationship('user', 'first_name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                TextInput::make('first_name')
                    ->label(fn() => __('order.first_name'))
                    ->required()
                    ->maxLength(191),

                TextInput::make('last_name')
                    ->label(fn() => __('order.last_name'))
                    ->required()
                    ->maxLength(191),

                TextInput::make('phone')
                    ->label(fn() => __('order.phone'))
                    ->tel()
                    ->required()
                    ->maxLength(191),

                TextInput::make('wilaya')
                    ->label(fn() => __('order.wilaya'))
                    ->required()
                    ->maxLength(191),

                TextInput::make('commune')
                    ->label(fn() => __('order.commune'))
                    ->required()
                    ->maxLength(191),

                Textarea::make('address')
                    ->label(fn() => __('order.address'))
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('total')
                    ->label(fn() => __('order.total'))
                    ->required()
                    ->numeric(),

                Select::make('status')
                    ->label(fn() => __('order.status'))
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled'
                    ])
                    ->required()
                    ->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label(fn() => __('order.user_id'))
                    ->searchable(),

                TextColumn::make('first_name')
                    ->label(fn() => __('order.first_name'))
                    ->searchable(),

                TextColumn::make('last_name')
                    ->label(fn() => __('order.last_name'))
                    ->searchable(),

                TextColumn::make('phone')
                    ->label(fn() => __('order.phone'))
                    ->searchable(),

                TextColumn::make('wilaya')
                    ->label(fn() => __('order.wilaya'))
                    ->searchable(),

                TextColumn::make('commune')
                    ->label(fn() => __('order.commune'))
                    ->searchable(),

                TextColumn::make('address')
                    ->label(fn() => __('order.address'))
                    ->searchable(),

                TextColumn::make('delivery_type_id')
                    ->label(fn() => __('order.delivery_type_id'))
                    ->searchable(),

                TextColumn::make('total')
                    ->label(fn() => __('order.total'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(fn() => __('order.status'))
                    ->searchable(),

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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
