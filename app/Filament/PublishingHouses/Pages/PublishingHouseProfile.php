<?php

namespace App\Filament\PublishingHouses\Pages;

use App\Models\PublishingHouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class PublishingHouseProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static string $view = 'filament.publishing-houses.pages.publishing-house-profile';
    protected static ?string $title = 'Mon Profil';
    protected static ?string $navigationLabel = 'Mon Profil';
    protected static ?int $navigationSort = 1;

    public ?array $data = [];
    public PublishingHouse $record;

    public function mount(): void
    {
        // Get the publishing house for the current authenticated user
        $this->record = PublishingHouse::where('owner_id', Auth::id())->firstOrFail();

        // Properly format the data for the form
        $data = $this->record->toArray();

        // Ensure social_links is properly formatted as array
        if (isset($data['social_links'])) {
            if (is_string($data['social_links'])) {
                $data['social_links'] = json_decode($data['social_links'], true) ?? [];
            } elseif (!is_array($data['social_links'])) {
                $data['social_links'] = [];
            }
        } else {
            $data['social_links'] = [];
        }

        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main Information Section
                Forms\Components\Section::make(__('publishing_house.main_information'))
                    ->description(__('publishing_house.main_information_desc'))
                    ->icon('heroicon-o-building-office')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('publishing_house.name'))
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ex: Éditions Gallimard'),

                        Forms\Components\TextInput::make('email')
                            ->label(__('publishing_house.professional_email'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('contact@votremaisondedition.com'),

                        Forms\Components\TextInput::make('phone')
                            ->label(__('publishing_house.phone'))
                            ->tel()
                            ->maxLength(255)
                            ->placeholder('+33 1 23 45 67 89'),

                        Forms\Components\DatePicker::make('established_year')
                            ->label(__('publishing_house.established_year'))
                            ->native(false),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // Online Presence Section
                Forms\Components\Section::make(__('publishing_house.online_presence'))
                    ->description(__('publishing_house.online_presence_desc'))
                    ->icon('heroicon-o-globe-alt')
                    ->schema([
                        Forms\Components\TextInput::make('website')
                            ->label(__('publishing_house.website'))
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://www.votremaisondedition.com')
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('social_links')
                            ->label(__('publishing_house.social_networks'))
                            ->schema([
                                Forms\Components\Select::make('platform')
                                    ->label(__('publishing_house.platform'))
                                    ->options([
                                        'facebook' => 'Facebook',
                                        'twitter' => 'Twitter/X',
                                        'instagram' => 'Instagram',
                                        'linkedin' => 'LinkedIn',
                                        'youtube' => 'YouTube',
                                        'tiktok' => 'TikTok',
                                        'goodreads' => 'Goodreads',
                                    ])
                                    ->required()
                                    ->searchable(),

                                Forms\Components\TextInput::make('url')
                                    ->label('URL')
                                    ->url()
                                    ->required()
                                    ->placeholder('https://...'),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->defaultItems(0)
                            ->addActionLabel(__('publishing_house.add_social_network'))
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // Address & Description Section
                Forms\Components\Section::make(__('publishing_house.location_description'))
                    ->description(__('publishing_house.location_description_desc'))
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->label(__('publishing_house.complete_address'))
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('123 Rue de la Littérature, 75001 Paris, France'),

                        Forms\Components\Textarea::make('description')
                            ->label(__('publishing_house.publishing_house_description'))
                            ->rows(5)
                            ->maxLength(1000)
                            ->placeholder('Décrivez votre maison d\'édition, vos spécialités, votre histoire...')
                            ->hint(__('publishing_house.max_characters')),
                    ])
                    ->collapsible(),

                // Visual Identity Section
                Forms\Components\Section::make(__('publishing_house.visual_identity'))
                    ->description(__('publishing_house.visual_identity_desc'))
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->label(__('publishing_house.publishing_house_logo'))
                            ->image()
                            ->directory('publishing-houses/logos')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1' => __('publishing_house.square_recommended'),
                                '16:9' => __('publishing_house.landscape'),
                                '4:3' => __('publishing_house.standard'),
                            ])
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText(__('publishing_house.accepted_formats'))
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // Statistics Section (Read-only)
                Forms\Components\Section::make(__('publishing_house.statistics'))
                    ->description(__('publishing_house.statistics_desc'))
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Forms\Components\Placeholder::make('books_count')
                            ->label(__('publishing_house.published_books_count'))
                            ->content(fn() => $this->record->books()->count() . ' ' . __('publishing_house.books')),

                        Forms\Components\Placeholder::make('pending_payouts')
                            ->label(__('publishing_house.pending_payments'))
                            ->content(fn() => number_format($this->record->getPendingPayoutTotal(), 2) . ' €'),

                        Forms\Components\Placeholder::make('total_reviews')
                            ->label(__('publishing_house.received_reviews'))
                            ->content(fn() => $this->record->reviews()->count() . ' ' . __('publishing_house.reviews')),

                        Forms\Components\Placeholder::make('member_since')
                            ->label(__('publishing_house.member_since'))
                            ->content(fn() => $this->record->created_at->format('d/m/Y')),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('publishing_house.save_changes'))
                ->color('primary')
                ->icon('heroicon-o-check')
                ->submit('save')
                ->keyBindings(['mod+s']),

            Action::make('reset')
                ->label(__('publishing_house.cancel_changes'))
                ->color('gray')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    $this->mount();
                    Notification::make()
                        ->title(__('publishing_house.changes_cancelled'))
                        ->body(__('publishing_house.form_reset'))
                        ->warning()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalHeading(__('publishing_house.cancel_changes_confirm'))
                ->modalDescription(__('publishing_house.cancel_changes_desc')),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            // Ensure social_links is properly formatted
            if (isset($data['social_links']) && is_array($data['social_links'])) {
                // Filter out empty entries
                $data['social_links'] = array_filter($data['social_links'], function ($link) {
                    return !empty($link['platform']) && !empty($link['url']);
                });
                // Re-index array
                $data['social_links'] = array_values($data['social_links']);
            }

            $this->record->update($data);

            Notification::make()
                ->title(__('publishing_house.profile_updated'))
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title(__('publishing_house.update_error'))
                ->body(__('publishing_house.error_occurred') . $e->getMessage())
                ->danger()
                ->send();
        }
    }


    public static function canAccess(): bool
    {
        return PublishingHouse::where('owner_id', Auth::id())->exists();
    }
}
