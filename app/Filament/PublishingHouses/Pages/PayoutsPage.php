<?php

namespace App\Filament\PublishingHouses\Pages;

use App\Enums\PublisherPayoutStatus;
use App\Filament\PublishingHouses\Widgets\PayoutsOverview;
use App\Models\PublisherPayout;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Support\Htmlable;

class PayoutsPage extends Page implements HasTable
{
    use InteractsWithTable;
    protected static string $view = 'filament.publishing-houses.pages.payouts-page';

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
                TextColumn::make('amount')
                    ->label(__('payouts.amount'))
                    ->suffix(__("order_item.currency"))
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
            ->filters([])
            ->defaultSort('created_at', 'desc');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PayoutsOverview::class
        ];
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
            ->when($this->activeTab, fn($query) => $query->where('status', $this->activeTab));
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
