<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryTypeResource\Pages;
use App\Models\DeliveryType;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class DeliveryTypeResource extends Resource
{
    protected static ?string $model = DeliveryType::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function getLabel(): ?string
    {
        return __('sidebar.delivery_types');
    }

    public static function getPluralLabel(): ?string
    {
        return __('sidebar.delivery_types');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.orders_and_sales');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(fn() => __('delivery_type.name'))
                    ->required()
                    ->maxLength(191),

                TextInput::make('logo_url')
                    ->label(fn() => __('delivery_type.logo_url'))
                    ->maxLength(191)
                    ->default(null),

                TextInput::make('api_code')
                    ->label(fn() => __('delivery_type.api_code'))
                    ->maxLength(191)
                    ->default(null),

                TextInput::make('estimated_delay')
                    ->label(fn() => __('delivery_type.estimated_delay'))
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(fn() => __('delivery_type.name'))
                    ->searchable(),

                TextColumn::make('logo_url')
                    ->label(fn() => __('delivery_type.logo_url'))
                    ->searchable(),

                TextColumn::make('api_code')
                    ->label(fn() => __('delivery_type.api_code'))
                    ->searchable(),

                TextColumn::make('estimated_delay')
                    ->label(fn() => __('delivery_type.estimated_delay'))
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
            'index' => Pages\ListDeliveryTypes::route('/'),
            'create' => Pages\CreateDeliveryType::route('/create'),
            'edit' => Pages\EditDeliveryType::route('/{record}/edit'),
        ];
    }
}
