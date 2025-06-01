<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Filament\Resources\BookResource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Illuminate\Database\Query\Builder;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(__("order_item.heading"))
            ->description(fn() => __('order_item.subheading'))
            ->columns([
                ImageColumn::make('publishingHouse.logo')
                    ->label('')
                    ->circular()
                    ->size(50),
                TextColumn::make('book.title')
                    ->label(fn() => __('order_item.book_title'))
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label(fn() => __('order_item.quantity'))
                    ->numeric(),
                TextColumn::make('unit_price')
                    ->label(fn() => __('order_item.unit_price'))
                    ->numeric(),

                TextColumn::make('commission')
                    ->label(fn() => __('order_item.total_price'))
                    ->suffix(" " . __("order_item.currency"))
                    ->state(function ($record) {
                        $totalPrice = $record->quantity * $record->unit_price;
                        $profitAmount = ($totalPrice * $record->profit_percentage) / 100;
                        return $profitAmount;
                    })
                    ->numeric(),

                TextColumn::make('profit_percentage')
                    ->label(fn() => __('order_item.profit_percentage'))
                    ->suffix("%")
                    ->badge()
                    ->icon("heroicon-o-percent-badge")
                    ->color("warning")
                    ->numeric()
                    ->summarize(Summarizer::make()
                        ->label(fn() => __('order_item.total_profit'))
                        ->using(fn(Builder $query): float => $query->sum(\Illuminate\Support\Facades\DB::raw('quantity * unit_price * profit_percentage / 100')))),

                TextColumn::make('status')
                    ->label(fn() => __('order_item.status'))
                    ->formatStateUsing(fn($record) => __('order_item.status_' . $record->status->value))
                    ->badge()
                    ->color(fn($record) => match ($record->status->value) {
                        'pending' => 'warning',
                        'confirmed' => 'primary',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->icon(fn($record) => match ($record->status->value) {
                        'pending' => 'heroicon-o-clock',
                        'confirmed' => 'heroicon-o-check-circle',
                        'shipped' => 'heroicon-o-truck',
                        'delivered' => 'heroicon-o-check',
                        'cancelled' => 'heroicon-o-x-circle',
                    })
                    ->size(TextColumn\TextColumnSize::Large)
                    ->searchable(),
            ])
            ->actions([
                Action::make('viewBook')
                    ->label(fn() => __('order_item.view_book'))
                    ->action(function ($record) {
                        return redirect(BookResource::getUrl('edit', [
                            'record' => $record->book->id
                        ]));
                    })
                    ->icon('heroicon-o-book-open')
                    ->color('info'),
                EditAction::make('delete')
                    ->label(fn() => __('order_item.delete'))
                    ->action(fn($record) => $record->delete())
                    ->requiresConfirmation()
                    ->color('danger'),
                EditAction::make('editProfitPercentage')
                    ->label(fn() => __('order_item.edit_profit_percentage'))
                    ->modalHeading(__('order_item.edit_profit_percentage'))
                    ->form([
                        TextInput::make('profit_percentage')
                            ->label(fn() => __('order_item.profit_percentage'))
                            ->numeric()
                            ->required(),
                    ])
                    ->after(function ($record, $data) {
                        $record->update(['profit_percentage' => $data['profit_percentage']]);
                    })
                    ->color('primary'),
            ])
            // ->bulkActions([
            //     BulkAction::make('confirm')
            //         ->label(fn() => __('order_item.confirm_selected'))
            //         ->action(function ($records) {
            //             $records->each->update(['status' => 'confirmed']);
            //         })
            //         ->requiresConfirmation()
            //         ->deselectRecordsAfterCompletion(),
            //     BulkAction::make('cancel')
            //         ->label(fn() => __('order_item.cancel_selected'))
            //         ->action(function ($records) {
            //             $records->each->update(['status' => 'cancelled']);
            //         })
            //         ->deselectRecordsAfterCompletion(),
            // ])
            ->groups([
                Group::make('status')
                    ->label(fn() => __('order_item.status'))
                    ->getTitleFromRecordUsing(fn($record) => __("order_item.status_{$record->status->value}")),
                Group::make('book.publishingHouse.name')
                    ->label(fn() => __('order_item.publishing_house'))
                    ->collapsible(),
            ])
            ->defaultGroup(null)
        ;
    }
}
