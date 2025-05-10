<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function getLabel(): ?string
    {
        return __('sidebar.reviews');
    }

    public static function getPluralLabel(): ?string
    {
        return __('sidebar.reviews');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.user_interaction');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('user_id')
                    ->label(fn() => __('review.user_id'))
                    ->required()
                    ->maxLength(36),

                TextInput::make('reviewable_type')
                    ->label(fn() => __('review.reviewable_type'))
                    ->required()
                    ->maxLength(191),

                TextInput::make('reviewable_id')
                    ->label(fn() => __('review.reviewable_id'))
                    ->required()
                    ->numeric(),

                TextInput::make('rating')
                    ->label(fn() => __('review.rating'))
                    ->required()
                    ->numeric(),

                Textarea::make('comment')
                    ->label(fn() => __('review.comment'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label(fn() => __('review.user_id'))
                    ->searchable(),

                TextColumn::make('reviewable_type')
                    ->label(fn() => __('review.reviewable_type'))
                    ->searchable(),

                TextColumn::make('reviewable_id')
                    ->label(fn() => __('review.reviewable_id'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('rating')
                    ->label(fn() => __('review.rating'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('comment')
                    ->label(fn() => __('review.comment'))
                    ->toggleable(isToggledHiddenByDefault: true),

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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
