<?php

namespace App\Filament\PublishingHouses\Pages\Auth;

use App\Models\PublishingHouse;
use Filament\Actions\Action;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class SetupAccount extends Page implements HasForms, HasActions
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.publishing-houses.pages.auth.setup-account';
    public $defaultAction = 'setupAccount';

    public ?array $data = [];

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Publishing House Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('address')
                            ->label('Address')
                            ->maxLength(255),
                        TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('established_year')
                            ->label('Established Year')
                            ->type('date')
                            ->maxLength(255),
                        TextInput::make('description')
                            ->label('Description')
                            ->maxLength(65535),
                    ]),
            ])
            ->statePath('data');
    }

    public function setupAccount(): Action
    {
        return Action::make('setupAccount')
            ->label('Create Publishing House')
            ->color('success')
            ->modalHeading('Welcome to Kotobi')
            ->modalDescription('Set up your publishing house to get started.')
            ->modalCancelAction(false)
            ->modalSubmitActionLabel('Submit')
            ->closeModalByClickingAway(false)
            ->closeModalByEscaping(false)
            ->modalCloseButton(false)
            ->form([
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Publishing House Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('address')
                            ->label('Address')
                            ->maxLength(255),
                        TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('established_year')
                            ->label('Established Year')
                            ->type('date')
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),
            ])
            ->action(function (array $data) {
                $user = Auth::user();
                PublishingHouse::create([
                    'name' => $data['name'],
                    'email' => $data['email'] ?? null,
                    'phone' => $data['phone'] ?? null,
                    'address' => $data['address'] ?? null,
                    'website' => $data['website'] ?? null,
                    'established_year' => $data['established_year'] ?? null,
                    'description' => $data['description'] ?? null,
                    'status' => 'active',
                    'owner_id' => $user->id,
                ]);
                return redirect()->to('/publisher/');
            });
    }
}
