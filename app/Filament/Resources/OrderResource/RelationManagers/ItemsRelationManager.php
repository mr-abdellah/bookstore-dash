<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Grouping\Group;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('book.title')
                    ->label('Book Title')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->numeric(),
                TextColumn::make('unit_price')
                    ->label('Unit Price')
                    ->numeric(),
                TextColumn::make('commission')
                    ->label('Commission')
                    ->numeric(),
                // TextColumn::make('status')
                //     ->label('Status')
                //     ->searchable(),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                // Add individual actions if needed
            ])
            ->bulkActions([
                BulkAction::make('confirm')
                    ->label('Confirm Selected')
                    ->action(function ($records) {
                        $records->each->update(['status' => 'confirmed']);
                    })
                    ->deselectRecordsAfterCompletion(),
                BulkAction::make('cancel')
                    ->label('Cancel Selected')
                    ->action(function ($records) {
                        $records->each->update(['status' => 'cancelled']);
                    })
                    ->deselectRecordsAfterCompletion(),
            ])
            ->groups([
                Group::make('status')
                    ->label('Status')
                    ->getTitleFromRecordUsing(fn($record) => ucfirst($record->status)),
                Group::make('book.publishing_house.name')
                    ->label('Publishing House'),
            ])
            ->defaultGroup('book.publishing_house.name');
    }
}