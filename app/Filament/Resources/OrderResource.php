<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Infolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ViewAction;

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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make(fn() => __('order.user_information'))
                    ->schema([
                        Infolists\Components\TextEntry::make('first_name')
                            ->label(fn() => __('order.first_name')),
                        Infolists\Components\TextEntry::make('last_name')
                            ->label(fn() => __('order.last_name')),
                        Infolists\Components\TextEntry::make('phone')
                            ->label(fn() => __('order.phone')),
                        Infolists\Components\TextEntry::make('wilaya')
                            ->label(fn() => __('order.wilaya')),
                        Infolists\Components\TextEntry::make('commune')
                            ->label(fn() => __('order.commune')),
                        Infolists\Components\TextEntry::make('address')
                            ->label(fn() => __('order.address')),
                        Infolists\Components\TextEntry::make('order_status')
                            ->formatStateUsing(fn($record) => __('order.status_' . $record->order_status->value))
                            ->label(fn() => __('order.order_status'))
                            ->badge()
                            ->color(fn(OrderStatus $state): string => match ($state->value) {
                                'pending' => 'warning',
                                'confirmed' => 'primary',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                                default => 'secondary',
                            })
                    ])
                    ->columns([
                        'default' => 2,
                        'md' => 3,
                        'lg' => 4,
                    ])

            ]);
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
                        'pending' => __('order.status_pending'),
                        'processing' => __('order.status_processing'),
                        'shipped' => __('order.status_shipped'),
                        'delivered' => __('order.status_delivered'),
                        'cancelled' => __('order.status_cancelled')
                    ])
                    ->required()
                    ->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('address')
                    ->label(fn() => __('order.address'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('total')
                    ->label(fn() => __('order.total'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('order_status')
                    ->label(fn() => __('order.status'))
                    ->badge()
                    ->color(
                        fn(?OrderStatus $state): string => match ($state) {
                            OrderStatus::PENDING => 'warning',
                            OrderStatus::CONFIRMED => 'primary',
                            OrderStatus::SHIPPED => 'info',
                            OrderStatus::DELIVERED => 'success',
                            OrderStatus::CANCELLED => 'danger',
                            null => 'secondary',
                        }
                    )
                    ->icon(
                        fn(?OrderStatus $state): string => match ($state) {
                            OrderStatus::PENDING => 'heroicon-o-clock',
                            OrderStatus::CONFIRMED => 'heroicon-o-check',
                            OrderStatus::SHIPPED => 'heroicon-o-truck',
                            OrderStatus::DELIVERED => 'heroicon-o-check-circle',
                            OrderStatus::CANCELLED => 'heroicon-o-x-circle',
                            null => 'heroicon-o-question-mark-circle',
                        }
                    )
                    ->formatStateUsing(
                        fn(?OrderStatus $state): string => match ($state) {
                            OrderStatus::PENDING => __('order.statuses.pending'),
                            OrderStatus::CONFIRMED => __('order.statuses.confirmed'),
                            OrderStatus::SHIPPED => __('order.statuses.shipped'),
                            OrderStatus::DELIVERED => __('order.statuses.delivered'),
                            OrderStatus::CANCELLED => __('order.statuses.cancelled'),
                            null => __('order.statuses.default'),
                        }
                    )
                    ->searchable(),

                TextColumn::make('payment_status')
                    ->label(fn() => __('order.payment_status'))
                    ->badge()
                    ->color(
                        fn(PaymentStatus $state): string => match ($state) {
                            PaymentStatus::PENDING => 'warning',
                            PaymentStatus::PO_SIGNED => 'info',
                            PaymentStatus::PAYMENT_CONFIRMED => 'primary',
                            PaymentStatus::PAID => 'success',
                            PaymentStatus::FAILED => 'danger',
                            default => 'secondary',
                        }
                    )
                    ->icon(
                        fn(PaymentStatus $state): string => match ($state) {
                            PaymentStatus::PENDING => 'heroicon-o-clock',
                            PaymentStatus::PO_SIGNED => 'heroicon-o-pencil-square',
                            PaymentStatus::PAYMENT_CONFIRMED => 'heroicon-o-check-badge',
                            PaymentStatus::PAID => 'heroicon-o-currency-dollar',
                            PaymentStatus::FAILED => 'heroicon-o-x-circle',
                            default => 'heroicon-o-question-mark-circle',
                        }
                    )
                    ->formatStateUsing(
                        fn(PaymentStatus $state): string => match ($state) {
                            PaymentStatus::PENDING => __('order.payment_statuses.pending'),
                            PaymentStatus::PO_SIGNED => __('order.payment_statuses.po_signed'),
                            PaymentStatus::PAYMENT_CONFIRMED => __('order.payment_statuses.payment_confirmed'),
                            PaymentStatus::PAID => __('order.payment_statuses.paid'),
                            PaymentStatus::FAILED => __('order.payment_statuses.failed'),
                            default => __('order.payment_statuses.default'),
                        }
                    )
                    ->searchable(),

                TextColumn::make('payment_method')
                    ->label(fn() => __('order.payment_method'))
                    ->badge()
                    ->color(
                        fn(PaymentMethod $state): string => match ($state) {
                            PaymentMethod::OFFLINE => 'warning',
                            PaymentMethod::ONLINE => 'info',
                            default => 'gray',
                        }
                    )
                    ->icon(
                        fn(PaymentMethod $state): string => match ($state) {
                            PaymentMethod::OFFLINE => 'heroicon-o-banknotes',
                            PaymentMethod::ONLINE => 'heroicon-o-credit-card',
                            "default" => 'heroicon-o-question-mark-circle',
                        }
                    )
                    ->formatStateUsing(
                        fn(PaymentMethod $state): string => match ($state) {
                            PaymentMethod::OFFLINE => __('order.payment_methods.offline'),
                            PaymentMethod::ONLINE => __('order.payment_methods.online'),
                            default =>  __('order.payment_methods.offline'),
                        }
                    ),


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
                SelectFilter::make('order_status')
                    ->searchable()
                    ->label(__('order.order_status'))
                    ->options(collect(OrderStatus::cases())->mapWithKeys(fn($status) => [$status->value => __('order.statuses.' . $status->value)])),

                SelectFilter::make('payment_status')
                    ->searchable()
                    ->label(__('order.payment_status'))
                    ->options(collect(PaymentStatus::cases())->mapWithKeys(fn($status) => [$status->value => __('order.payment_statuses.' . $status->value)])),

                SelectFilter::make('payment_method')
                    ->searchable()
                    ->label(__('order.payment_method'))
                    ->options(collect(PaymentMethod::cases())->mapWithKeys(fn($method) => [$method->value => __('order.payment_methods.' . $method->value)])),
            ])

            ->actions([
                ViewAction::make(),
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
            ItemsRelationManager::class,
        ];
    }

    public static function eagerLoadForIndex(): array
    {
        return ['items.book.publishingHouse'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
