<?php

namespace App\Filament\PublishingHouses\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getAvatarFormComponent(),
                        $this->getFirstNameFormComponent(),
                        $this->getLastNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPhoneFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getAvatarFormComponent(): Component
    {
        return FileUpload::make('avatar')
            ->label(__('user.avatar'))
            ->image()
            ->directory('avatars')
            ->preserveFilenames()
            ->imageEditor()
            ->imageEditorAspectRatios([
                '1:1',
            ])
            ->maxSize(2048)
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->columnSpanFull()
            ->nullable();
    }

    protected function getFirstNameFormComponent(): Component
    {
        return TextInput::make('first_name')
            ->label(__('user.first_name'))
            ->required()
            ->maxLength(255);
    }

    protected function getLastNameFormComponent(): Component
    {
        return TextInput::make('last_name')
            ->label(__('user.last_name'))
            ->required()
            ->maxLength(255);
    }

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label(__('user.phone'))
            ->tel()
            ->required()
            ->maxLength(20)
            ->placeholder('+1234567890');
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['role'] = 'publisher';
        return $data;
    }
}
