<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getLabel(): ?string
    {
        return __('sidebar.books');
    }

    public static function getPluralLabel(): ?string
    {
        return __('sidebar.books');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.books_and_content');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('author_id')
                    ->label(fn() => __('book.author'))
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('category_id')
                    ->label(fn() => __('book.category'))
                    ->relationship('category', 'name_en')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('publishing_house_id')
                    ->label(fn() => __('book.publishing_house'))
                    ->relationship('publishingHouse', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),


                Forms\Components\TextInput::make('title')
                    ->label(fn() => __('book.title'))
                    ->required()
                    ->maxLength(191),

                Forms\Components\Textarea::make('description')
                    ->label(fn() => __('book.description'))
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('price')
                    ->label(fn() => __('book.price'))
                    ->required()
                    ->numeric()
                    ->suffix('DA'),

                Forms\Components\TextInput::make('quantity')
                    ->label(fn() => __('book.quantity'))
                    ->required()
                    ->numeric(),

                Forms\Components\Select::make('language')
                    ->label(fn() => __('book.language'))
                    ->options([
                        'English' => __('book.English'),
                        'French' => __('book.French'),
                        'Arabic' => __('book.Arabic'),
                        'Spanish' => __('book.Spanish'),
                        'German' => __('book.German'),
                        'Chinese' => __('book.Chinese'),
                        'Japanese' => __('book.Japanese'),
                        'Russian' => __('book.Russian'),
                        'Portuguese' => __('book.Portuguese'),
                        'Italian' => __('book.Italian'),
                        'Hindi' => __('book.Hindi'),
                        'Korean' => __('book.Korean'),
                        'Turkish' => __('book.Turkish'),
                        'Polish' => __('book.Polish'),
                        'Dutch' => __('book.Dutch'),
                        'Swedish' => __('book.Swedish'),
                        'Persian' => __('book.Persian'),
                        'Indonesian' => __('book.Indonesian'),
                        'Malay' => __('book.Malay'),
                        'Hebrew' => __('book.Hebrew'),
                        'Ukrainian' => __('book.Ukrainian'),
                        'Vietnamese' => __('book.Vietnamese'),
                        'Thai' => __('book.Thai'),
                        'Romanian' => __('book.Romanian'),
                        'Czech' => __('book.Czech'),
                        'Hungarian' => __('book.Hungarian'),
                        'Greek' => __('book.Greek'),
                        'Bengali' => __('book.Bengali'),
                        'Tamil' => __('book.Tamil'),
                        'Urdu' => __('book.Urdu'),
                    ])
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('dimensions')
                    ->label(fn() => __('book.dimensions'))
                    ->maxLength(191)
                    ->hint(__('book.dimensions'))
                    ->default(null),

                Forms\Components\TextInput::make('pages_count')
                    ->label(fn() => __('book.pages_count'))
                    ->numeric()
                    ->default(null),

                Forms\Components\FileUpload::make('cover')
                    ->label(fn() => __('book.cover'))
                    ->image()
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('2:3')
                    ->directory('books/covers'),

                Forms\Components\FileUpload::make('images')
                    ->label(fn() => __('book.images'))
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author.name')
                    ->label(fn() => __('book.author_name'))
                    ->searchable()
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('category.name_en')
                    ->label(fn() => __('book.category_name'))
                    ->searchable()
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('quantity')
                    ->label(fn() => __('book.quantity'))
                    ->numeric(),

                Tables\Columns\TextColumn::make('publishingHouse.name')
                    ->label(fn() => __('book.publishing_house_name'))
                    ->searchable()
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('discount.name')
                    ->label(fn() => __('book.discount_name'))
                    ->searchable()
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('title')
                    ->label(fn() => __('book.title'))
                    ->searchable()
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('price')
                    ->label(fn() => __('book.price'))
                    ->money()
                    ->sortable()
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('language')
                    ->label(fn() => __('book.language'))
                    ->searchable()
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('dimensions')
                    ->label(fn() => __('book.dimensions'))
                    ->searchable()
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('pages_count')
                    ->label(fn() => __('book.pages_count'))
                    ->numeric()
                    ->sortable()
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(fn() => __('book.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('N/A'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(fn() => __('book.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('N/A'),
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
