<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlatformSettingResource\Pages;
use App\Models\PlatformSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PlatformSettingResource extends Resource
{
    protected static ?string $model = PlatformSettings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function getLabel(): ?string
    {
        return __('sidebar.settings');
    }

    public static function getPluralLabel(): ?string
    {
        return __('sidebar.settings');
    }

    public static function canCreate(): bool
    {
        return ! self::getModel()::query()->exists();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('platform_name')
                    ->required()
                    ->label(fn() => __('platform_setting.platform_name')),

                Forms\Components\TextInput::make('profit_percentage')
                    ->numeric()
                    ->suffix('%')
                    ->required()
                    ->label(fn() => __('platform_setting.profit_percentage')),

                Forms\Components\TextInput::make('contact_email')
                    ->email()
                    ->label(fn() => __('platform_setting.contact_email')),

                Forms\Components\TextInput::make('contact_phone')
                    ->label(fn() => __('platform_setting.contact_phone')),

                Forms\Components\TextInput::make('address')
                    ->label(fn() => __('platform_setting.address')),

                Forms\Components\TextInput::make('city')
                    ->label(fn() => __('platform_setting.city')),

                Forms\Components\TextInput::make('rc_number')
                    ->label(fn() => __('platform_setting.rc_number')),

                Forms\Components\TextInput::make('nif_number')
                    ->label(fn() => __('platform_setting.nif_number')),

                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->directory('logos')
                    ->label(fn() => __('platform_setting.logo')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('platform_name')
                    ->label(fn() => __('platform_setting.platform_name')),

                Tables\Columns\TextColumn::make('profit_percentage')
                    ->label(fn() => __('platform_setting.profit_percentage'))
                    ->suffix('%'),

                Tables\Columns\TextColumn::make('contact_email')
                    ->label(fn() => __('platform_setting.contact_email')),

                Tables\Columns\TextColumn::make('city')
                    ->label(fn() => __('platform_setting.city')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListPlatformSettings::route('/'),
            'create' => Pages\CreatePlatformSetting::route('/create'),
            'edit' => Pages\EditPlatformSetting::route('/{record}/edit'),
        ];
    }
}
