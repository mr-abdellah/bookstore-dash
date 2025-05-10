<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Users & Access';
    protected static ?int $navigationSort = 1;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('avatar')
                    ->image()
                    ->directory('avatars')
                    ->preserveFilenames()
                    ->default(null)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(191),

                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->native(false)
                    ->required()
                    ->hiddenOn('create'),

                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(191)
                    ->default(null),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(191),

                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(191)
                    ->default('active'),

                Forms\Components\Select::make('role')
                    ->required()
                    ->native(false)
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ])
                    ->default('user'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->placeholder('N/A'),
                Tables\Columns\ImageColumn::make('avatar')
                    ->square()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
