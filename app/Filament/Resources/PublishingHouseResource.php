<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublishingHouseResource\Pages;
use App\Models\PublishingHouse;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class PublishingHouseResource extends Resource
{
    protected static ?string $model = PublishingHouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Books & Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('owner_id')
                    ->label('Owner')
                    ->relationship('owner', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn(User $record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name', 'email'])
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(191)
                    ->default(null),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(191)
                    ->default(null),
                Forms\Components\TextInput::make('address')
                    ->maxLength(191)
                    ->default(null),
                Forms\Components\TextInput::make('website')
                    ->maxLength(191)
                    ->default(null),


                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->native(false),

                Forms\Components\DatePicker::make('established_year')
                    ->native(false),

                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->image()
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    // ->imageCropAspectRatio('1:1')
                    ->directory('publishing-houses')
                    ->default(null)
                    ->columnSpanFull(),


                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('social_links')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->circular(),
                Tables\Columns\TextColumn::make('owner.first_name')
                    ->label('Owner')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),

                Tables\Columns\TextColumn::make('established_year')
                    ->badge(),


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
            'index' => Pages\ListPublishingHouses::route('/'),
            'create' => Pages\CreatePublishingHouse::route('/create'),
            'edit' => Pages\EditPublishingHouse::route('/{record}/edit'),
        ];
    }
}
