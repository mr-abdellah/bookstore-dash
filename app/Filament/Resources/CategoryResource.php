<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function getLabel(): ?string
    {
        return __('sidebar.categories');
    }

    public static function getPluralLabel(): ?string
    {
        return __('sidebar.categories');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.books_and_content');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name_en')
                    ->label(fn() => __('category.name_en'))
                    ->required()
                    ->maxLength(191),

                TextInput::make('name_fr')
                    ->label(fn() => __('category.name_fr'))
                    ->required()
                    ->maxLength(191),

                TextInput::make('name_ar')
                    ->label(fn() => __('category.name_ar'))
                    ->required()
                    ->maxLength(191),

                TextInput::make('slug')
                    ->label(fn() => __('category.slug'))
                    ->required()
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_en')
                    ->label(fn() => __('category.name_en'))
                    ->searchable(),

                TextColumn::make('name_fr')
                    ->label(fn() => __('category.name_fr'))
                    ->searchable(),

                TextColumn::make('name_ar')
                    ->label(fn() => __('category.name_ar'))
                    ->searchable(),

                TextColumn::make('slug')
                    ->label(fn() => __('category.slug'))
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
