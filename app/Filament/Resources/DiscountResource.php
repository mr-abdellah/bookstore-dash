<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Models\Discount;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Orders & Sales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191),



                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(191)
                    ->suffixAction(
                        Action::make('generate_code')
                            ->label('Generate Code')
                            ->icon('heroicon-m-arrow-path')
                            ->action(function ($get, $set) {
                                $generatedCode = strtoupper(Str::random(1)) . rand(10, 99) . strtoupper(Str::random(1)) . rand(10, 99);
                                $set('code', $generatedCode);
                            })
                    ),


                Forms\Components\TextInput::make('percent')
                    ->required()
                    ->suffix("%")
                    ->numeric(),

                Forms\Components\DatePicker::make('starts_at')
                    ->native(false),

                Forms\Components\DatePicker::make('ends_at')
                    ->native(false),

                Forms\Components\Toggle::make('active')
                    ->inline(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->copyable()
                    ->badge()
                    ->copyMessage('Code copied'),
                Tables\Columns\TextColumn::make('percent')
                    ->numeric()
                    ->sortable()
                    ->suffix("%"),
                Tables\Columns\TextColumn::make('starts_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }
}
