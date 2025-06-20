<?php

namespace App\Filament\Resources\PlatformSettingResource\Pages;

use App\Filament\Resources\PlatformSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlatformSettings extends ListRecords
{
    protected static string $resource = PlatformSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
