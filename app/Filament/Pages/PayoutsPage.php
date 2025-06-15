<?php

namespace App\Filament\Pages;

use App\Enums\PublisherPayoutStatus;
use App\Models\PublisherPayout;
use App\Models\PublishingHouse;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\Support\Htmlable;

class PayoutsPage extends Page implements HasTable
{
    use InteractsWithTable;
    protected static string $view = 'filament.pages.payouts-page';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public function getTitle(): string|Htmlable
    {
        return __('payouts.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('payouts.title');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sidebar.orders_and_sales');
    }

    public ?string $activeTab = '';

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function updatedActiveTab()
    {
        $this->resetTable();
    }

    public function getCountForStatus(string $status): int
    {
        return PublisherPayout::query()
            ->when($status, fn($query) => $query->where('status', $status))
            ->count();
    }

    public function getAllCount(): int
    {
        return $this->getCountForStatus('');
    }

    public function getPendingCount(): int
    {
        return $this->getCountForStatus(PublisherPayoutStatus::PENDING->value);
    }

    public function getSentCount(): int
    {
        return $this->getCountForStatus(PublisherPayoutStatus::SENT->value);
    }

    public function getFailedCount(): int
    {
        return $this->getCountForStatus(PublisherPayoutStatus::FAILED->value);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                ImageColumn::make('orderItem.book.cover')
                    ->label(' '),
                TextColumn::make('orderItem.book.title')
                    ->label(__('payouts.book'))
                    ->sortable(),
                TextColumn::make('publishingHouse.name')
                    ->label(__('payouts.publishing_house'))
                    ->sortable(),
                TextColumn::make('orderItem.quantity')
                    ->label(__('payouts.quantity'))
                    ->sortable(),
                TextColumn::make('amount')
                    ->label(__('payouts.total'))
                    ->suffix(__("order_item.currency"))
                    ->summarize(
                        \Filament\Tables\Columns\Summarizers\Sum::make()
                            ->suffix(__("order_item.currency"))
                    )
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('payouts.status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        PublisherPayoutStatus::PENDING->value => 'warning',
                        PublisherPayoutStatus::SENT->value => 'success',
                        PublisherPayoutStatus::FAILED->value => 'danger',
                    })
                    ->sortable()
                    ->formatStateUsing(fn(string $state) => __($this->getTranslatedStatus($state))),
                TextColumn::make('sent_at')
                    ->label(__('payouts.sent_at'))
                    ->placeholder('N/A')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('payouts.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('publishing_house')
                    ->label(__('payouts.publishing_house'))
                    ->relationship('publishingHouse', 'name')
                    ->options(
                        PublishingHouse::pluck('name', 'id')->toArray()
                    )
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\Action::make('mark_as_sent')
                        ->label(__('payouts.mark_as_sent'))
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading(__('payouts.mark_as_sent'))
                        ->modalDescription(__('payouts.confirm_mark_sent'))
                        ->action(function (PublisherPayout $record) {
                            $record->update([
                                'status' => PublisherPayoutStatus::SENT->value,
                                'sent_at' => now(),
                            ]);
                        })
                        ->visible(fn(PublisherPayout $record) => $record->status === PublisherPayoutStatus::PENDING->value),
                    Tables\Actions\Action::make('mark_as_failed')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->label(__('payouts.mark_as_failed'))
                        ->requiresConfirmation()
                        ->modalHeading(__('payouts.mark_as_failed'))
                        ->modalDescription(__('payouts.confirm_mark_failed'))
                        ->action(function (PublisherPayout $record) {
                            $record->update([
                                'status' => PublisherPayoutStatus::FAILED->value,
                                'sent_at' => null,
                            ]);
                        })
                        ->visible(fn(PublisherPayout $record) => $record->status === PublisherPayoutStatus::PENDING->value),
                ])
            ])
            ->defaultSort('created_at', 'desc');
    }

    protected function getTranslatedStatus(string $state): string
    {
        return match ($state) {
            PublisherPayoutStatus::PENDING->value => __('payouts.pending'),
            PublisherPayoutStatus::SENT->value => __('payouts.sent'),
            PublisherPayoutStatus::FAILED->value => __('payouts.failed'),
            default => $state,
        };
    }

    protected function getTableQuery()
    {
        return PublisherPayout::query()
            ->with(['orderItem.book', 'publishingHouse'])
            ->when($this->activeTab, fn($query) => $query->where('status', $this->activeTab));
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}