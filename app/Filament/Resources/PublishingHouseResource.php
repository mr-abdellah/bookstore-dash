<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublishingHouseResource\Pages;
use App\Models\PublishingHouse;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class PublishingHouseResource extends Resource
{
    protected static ?string $model = PublishingHouse::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    public static function getLabel(): ?string
    {
        return __('sidebar.publishing_houses');
    }

    public static function getPluralLabel(): ?string
    {
        return __('sidebar.publishing_houses');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.books_and_content');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('owner_id')
                    ->label(fn() => __('publishing_house.owner'))
                    ->relationship('owner', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn(User $record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name', 'email'])
                    ->preload()
                    ->required(),

                TextInput::make('name')
                    ->label(fn() => __('publishing_house.name'))
                    ->required()
                    ->maxLength(191),

                TextInput::make('email')
                    ->label(fn() => __('publishing_house.email'))
                    ->email()
                    ->maxLength(191)
                    ->default(null),

                TextInput::make('phone')
                    ->label(fn() => __('publishing_house.phone'))
                    ->tel()
                    ->maxLength(191)
                    ->default(null),

                TextInput::make('address')
                    ->label(fn() => __('publishing_house.address'))
                    ->maxLength(191)
                    ->default(null),

                TextInput::make('website')
                    ->label(fn() => __('publishing_house.website'))
                    ->maxLength(191)
                    ->default(null),

                Select::make('status')
                    ->label(fn() => __('publishing_house.status'))
                    ->options([
                        'active' => __('publishing_house.active'),
                        'inactive' => __('publishing_house.inactive'),
                    ])
                    ->native(false),

                DatePicker::make('established_year')
                    ->label(fn() => __('publishing_house.established_year'))
                    ->native(false),

                FileUpload::make('logo')
                    ->label(fn() => __('publishing_house.logo'))
                    ->image()
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->directory('publishing-houses')
                    ->default(null)
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label(fn() => __('publishing_house.description'))
                    ->columnSpanFull(),

                Textarea::make('social_links')
                    ->label(fn() => __('publishing_house.social_links'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label(fn() => __('publishing_house.logo'))
                    ->circular(),

                TextColumn::make('owner.first_name')
                    ->label(fn() => __('publishing_house.owner'))
                    ->searchable(),

                TextColumn::make('name')
                    ->label(fn() => __('publishing_house.name'))
                    ->searchable(),

                TextColumn::make('email')
                    ->label(fn() => __('publishing_house.email'))
                    ->searchable(),

                TextColumn::make('phone')
                    ->label(fn() => __('publishing_house.phone'))
                    ->searchable(),

                TextColumn::make('address')
                    ->label(fn() => __('publishing_house.address'))
                    ->searchable(),

                TextColumn::make('website')
                    ->label(fn() => __('publishing_house.website'))
                    ->searchable(),

                TextColumn::make('status')
                    ->label(fn() => __('publishing_house.status'))
                    ->searchable(),

                TextColumn::make('established_year')
                    ->label(fn() => __('publishing_house.established_year'))
                    ->badge(),

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
            'index' => Pages\ListPublishingHouses::route('/'),
            'create' => Pages\CreatePublishingHouse::route('/create'),
            'edit' => Pages\EditPublishingHouse::route('/{record}/edit'),
        ];
    }
}
