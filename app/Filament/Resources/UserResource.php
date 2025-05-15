<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getLabel(): ?string
    {
        return __('sidebar.users');
    }

    public static function getPluralLabel(): ?string
    {
        return __('sidebar.users');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.users_and_access');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('avatar')
                    ->label(fn() => __('user.avatar'))
                    ->image()
                    ->directory('avatars')
                    ->preserveFilenames()
                    ->default(null)
                    ->columnSpanFull(),

                TextInput::make('first_name')
                    ->label(fn() => __('user.first_name'))
                    ->required()
                    ->maxLength(191),

                TextInput::make('last_name')
                    ->label(fn() => __('user.last_name'))
                    ->required()
                    ->maxLength(191),

                TextInput::make('email')
                    ->label(fn() => __('user.email'))
                    ->email()
                    ->required()
                    ->maxLength(191),

                DateTimePicker::make('email_verified_at')
                    ->label(fn() => __('user.email_verified_at'))
                    ->native(false)
                    ->hiddenOn('create'),

                TextInput::make('phone')
                    ->label(fn() => __('user.phone'))
                    ->tel()
                    ->maxLength(191)
                    ->default(null),

                TextInput::make('password')
                    ->label(fn() => __('user.password'))
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $context): bool => $context === 'create'),

                Select::make('status')
                    ->label(fn() => __('user.role'))
                    ->required()
                    ->native(false)
                    ->options([
                        'active' => __('user.active'),
                        'inactive' => __('user.inactive'),
                    ])
                    ->default('active'),

                Select::make('role')
                    ->label(fn() => __('user.role'))
                    ->required()
                    ->native(false)
                    ->options([
                        'admin' => __('user.admin'),
                        'user' => __('user.user_role'),
                    ])
                    ->default('user'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label(fn() => __('user.first_name'))
                    ->searchable()
                    ->placeholder('N/A'),

                TextColumn::make('last_name')
                    ->label(fn() => __('user.last_name'))
                    ->searchable()
                    ->placeholder('N/A'),

                TextColumn::make('email')
                    ->label(fn() => __('user.email'))
                    ->searchable()
                    ->placeholder('N/A'),

                TextColumn::make('email_verified_at')
                    ->label(fn() => __('user.email_verified_at'))
                    ->dateTime()
                    ->sortable()
                    ->placeholder('N/A'),

                TextColumn::make('phone')
                    ->label(fn() => __('user.phone'))
                    ->searchable()
                    ->placeholder('N/A'),

                TextColumn::make('status')
                    ->label(fn() => __('user.status'))
                    ->searchable()
                    ->placeholder('N/A')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'inactive' => 'danger',
                        'active' => 'success',
                    })
                ,

                TextColumn::make('role')
                    ->label(fn() => __('user.role'))
                    ->searchable()
                    ->placeholder('N/A'),

                ImageColumn::make('avatar')
                    ->label(fn() => __('user.avatar'))
                    ->square()
                    ->placeholder('N/A'),

                TextColumn::make('created_at')
                    ->label(fn() => __('user.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('N/A'),

                TextColumn::make('updated_at')
                    ->label(fn() => __('user.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('N/A'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
