<?php

namespace App\Filament\PublishingHouses\Resources;

use App\Filament\PublishingHouses\Resources\AuthorResource\Pages;
use App\Models\Author;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('publishing_house_id', Auth::user()?->publishingHouse?->id);
    }

    public static function getLabel(): ?string
    {
        return __('sidebar.authors');
    }

    public static function getPluralLabel(): ?string
    {
        return __('sidebar.authors');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.books_and_content');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('author.name'))
                    ->required()
                    ->maxLength(191),

                FileUpload::make('avatar')
                    ->label(__('author.avatar'))
                    ->directory('authors')
                    ->image()
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->default(''),

                Textarea::make('bio')
                    ->label(__('author.bio'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([



                TextColumn::make('name')
                    ->label(__('author.name'))
                    ->searchable()
                    ->placeholder('N/A')
                    ->placeholder('N/A'),

                TextColumn::make('bio')
                    ->label(__('author.bio'))
                    ->wrap()
                    ->searchable()
                    ->placeholder('N/A'),

                ImageColumn::make('avatar')
                    ->label(__('author.avatar'))
                    ->circular(),

                TextColumn::make('created_at')
                    ->label(__('author.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('updated_at')
                    ->label(__('author.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

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
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
