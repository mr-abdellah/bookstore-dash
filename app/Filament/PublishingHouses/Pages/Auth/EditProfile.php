<?php

namespace App\Filament\PublishingHouses\Pages\Auth;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('avatar')
                    ->label(fn() => __('user.avatar'))
                    ->image()
                    ->directory('avatars')
                    ->preserveFilenames()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                    ])
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->columnSpanFull(),
                TextInput::make('first_name')
                    ->label(__('user.first_name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label(__('user.last_name'))
                    ->required()
                    ->maxLength(255),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
