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
                            ->label(__('setup-account.form.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('setup-account.form.email'))
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label(__('setup-account.form.phone'))
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('address')
                            ->label(__('setup-account.form.address'))
                            ->maxLength(255),
                        TextInput::make('website')
                            ->label(__('setup-account.form.website'))
                            ->url()
                            ->maxLength(255),
                        TextInput::make('established_year')
                            ->label(__('setup-account.form.established_year'))
                            ->type('date')
                            ->maxLength(255),
                        TextInput::make('description')
                            ->label(__('setup-account.form.description'))
                            ->maxLength(65535),
                    ]),
            ])
            ->statePath('data');
    }

    public function setupAccount(): Action
    {
        return Action::make('setupAccount')
            ->label(__('setup-account.button.create'))
            ->color('success')
            ->modalHeading(__('setup-account.modal.heading'))
            ->modalDescription(__('setup-account.modal.description'))
            ->modalCancelAction(false)
            ->modalSubmitActionLabel(__('setup-account.modal.submit'))
            ->closeModalByClickingAway(false)
            ->closeModalByEscaping(false)
            ->modalCloseButton(false)
            ->form([
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('setup-account.form.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('setup-account.form.email'))
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label(__('setup-account.form.phone'))
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('address')
                            ->label(__('setup-account.form.address'))
                            ->maxLength(255),
                        TextInput::make('website')
                            ->label(__('setup-account.form.website'))
                            ->url()
                            ->maxLength(255),
                        TextInput::make('established_year')
                            ->label(__('setup-account.form.established_year'))
                            ->type('date')
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label(__('setup-account.form.description'))
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),
            ])
            ->action(function (array $data) {
                $user = Auth::user();
                PublishingHouse::create([
                    'name' => $data['name'],
                    'email' => $data['email'] ?? '',
                    'phone' => $data['phone'] ?? '',
                    'address' => $data['address'] ?? '',
                    'website' => $data['website'] ?? '',
                    'established_year' => $data['established_year'] ?? '',
                    'description' => $data['description'] ?? '',
                    'status' => 'active',
                    'owner_id' => $user->id,
                ]);
                return redirect()->to('/publisher/');
            });
    }
}
