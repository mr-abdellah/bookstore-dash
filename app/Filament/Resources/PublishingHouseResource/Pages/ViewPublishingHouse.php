<?php

namespace App\Filament\Resources\PublishingHouseResource\Pages;

use App\Filament\Resources\PublishingHouseResource;
use App\Filament\Resources\PublishingHouseResource\RelationManagers\OrderItemsRelationManager;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewPublishingHouse extends ViewRecord
{
    protected static string $resource = PublishingHouseResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('publishing_house.pages.view.title');
    }

    public function infolist(Infolist $infolist): Infolist
    {
        $record = $this->record;

        $formatStatus = function ($state) {
            if (is_null($state)) {
                return __('publishing_house.placeholders.dash');
            }
            if (is_string($state)) {
                return $state;
            }
            if (is_object($state) && property_exists($state, 'value')) {
                return (string) $state->value;
            }
            if (is_object($state) && method_exists($state, 'value')) {
                return (string) $state->value();
            }
            return (string) $state;
        };

        $formatWebsite = fn($state) => is_string($state) && strlen($state) ? $state : null;

        return $infolist
            ->state([
                'name' => (string) $record->name,
                'owner' => optional($record->owner)->getFilamentName() ?? __('publishing_house.placeholders.dash'),
                'email' => (string) ($record->email ?? __('publishing_house.placeholders.dash')),
                'phone' => (string) ($record->phone ?? __('publishing_house.placeholders.dash')),
                'address' => (string) ($record->address ?? __('publishing_house.placeholders.dash')),
                'website' => $record->website,
                'established_year' => (string) ($record->established_year ?? __('publishing_house.placeholders.dash')),
                'status' => $record->status,
                'logo' => $record->logo ? asset('storage/' . $record->logo) : null,
                'description' => (string) ($record->description ?? __('publishing_house.placeholders.dash')),
                'books_count' => (string) $record->books()->count(),
                'order_items_count' => (string) $record->orderItems()->count(),
                'pending_payout_total' => number_format((float) $record->getPendingPayoutTotal(), 2),
                'sent_payout_total' => number_format((float) $record->getSentPayoutTotal(), 2),
            ])
            ->schema([
                Section::make(__('publishing_house.sections.overview'))
                    ->columns(3)
                    ->schema([
                        ImageEntry::make('logo')
                            ->label(__('publishing_house.labels.logo'))
                            ->hidden(fn($state) => empty($state)),

                        TextEntry::make('name')
                            ->label(__('publishing_house.labels.name'))
                            ->columnSpan(2)
                            ->weight('bold'),

                        TextEntry::make('owner')->label(__('publishing_house.labels.owner')),
                        TextEntry::make('email')->label(__('publishing_house.labels.email')),
                        TextEntry::make('phone')->label(__('publishing_house.labels.phone')),

                        TextEntry::make('website')
                            ->label(__('publishing_house.labels.website'))
                            ->url(fn($state) => $formatWebsite($state), true)
                            ->openUrlInNewTab()
                            ->placeholder(__('publishing_house.placeholders.dash')),

                        TextEntry::make('address')
                            ->label(__('publishing_house.labels.address'))
                            ->columnSpan(2),

                        TextEntry::make('established_year')
                            ->label(__('publishing_house.labels.established_year')),

                        TextEntry::make('status')
                            ->label(__('publishing_house.labels.status'))
                            ->badge()
                            ->formatStateUsing($formatStatus),
                    ]),

                Section::make(__('publishing_house.sections.description'))
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextEntry::make('description')
                            ->label(__('publishing_house.labels.description'))
                            ->prose()
                            ->columnSpanFull(),
                    ]),

                Section::make(__('publishing_house.sections.quick_stats'))
                    ->columns(4)
                    ->schema([
                        TextEntry::make('books_count')->label(__('publishing_house.labels.books_count'))->badge(),
                        TextEntry::make('order_items_count')->label(__('publishing_house.labels.order_items_count'))->badge(),
                        TextEntry::make('pending_payout_total')->label(__('publishing_house.labels.pending_payout_total'))->badge()->color('warning'),
                        TextEntry::make('sent_payout_total')->label(__('publishing_house.labels.sent_payout_total'))->badge()->color('success'),
                    ]),
            ]);
    }

    public function getRelationManagers(): array
    {
        return [
            OrderItemsRelationManager::class,
        ];
    }
}
