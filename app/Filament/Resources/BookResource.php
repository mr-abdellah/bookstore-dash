<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Discount;
use App\Models\PublishingHouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Books & Content';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('author_id')
                    ->label('Author')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name_en')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('publishing_house_id')
                    ->label('Publishing House')
                    ->relationship('publishingHouse', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\Select::make('discount_id')
                    ->label('Discount')
                    ->relationship('discount', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(191),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->suffix('DA'),

                Forms\Components\Select::make('language')
                    ->options([
                        'English' => 'English',
                        'French' => 'French',
                        'Arabic' => 'Arabic',
                        'Spanish' => 'Spanish',
                        'German' => 'German',
                        'Chinese' => 'Chinese',
                        'Japanese' => 'Japanese',
                        'Russian' => 'Russian',
                        'Portuguese' => 'Portuguese',
                        'Italian' => 'Italian',
                        'Hindi' => 'Hindi',
                        'Korean' => 'Korean',
                        'Turkish' => 'Turkish',
                        'Polish' => 'Polish',
                        'Dutch' => 'Dutch',
                        'Swedish' => 'Swedish',
                        'Persian' => 'Persian',
                        'Indonesian' => 'Indonesian',
                        'Malay' => 'Malay',
                        'Hebrew' => 'Hebrew',
                        'Ukrainian' => 'Ukrainian',
                        'Vietnamese' => 'Vietnamese',
                        'Thai' => 'Thai',
                        'Romanian' => 'Romanian',
                        'Czech' => 'Czech',
                        'Hungarian' => 'Hungarian',
                        'Greek' => 'Greek',
                        'Bengali' => 'Bengali',
                        'Tamil' => 'Tamil',
                        'Urdu' => 'Urdu',
                    ])
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('dimensions')
                    ->maxLength(191)
                    ->hint('Format: Width x Height x Depth')
                    ->default(null),
                Forms\Components\TextInput::make('pages_count')
                    ->numeric()
                    ->default(null),
                Forms\Components\FileUpload::make('images')
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
                    ->label('Author')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('category.name_en')
                    ->label('Category')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('publishingHouse.name')
                    ->label('Publishing House')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('discount.name')
                    ->label('Discount')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('language')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('dimensions')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('pages_count')
                    ->numeric()
                    ->sortable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('updated_at')
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
