<?php

namespace App\Filament\PublishingHouses\Resources\BookResource\Pages;

use App\Filament\PublishingHouses\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $publishing_house = Auth::user()->publishingHouse;
        $data['publishing_house_id'] = $publishing_house->id;
        return $data;
    }
}
