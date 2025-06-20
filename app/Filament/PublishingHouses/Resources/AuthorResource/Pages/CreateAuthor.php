<?php

namespace App\Filament\PublishingHouses\Resources\AuthorResource\Pages;

use App\Filament\PublishingHouses\Resources\AuthorResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $publishing_house = Auth::user()->publishingHouse;
        $data['publishing_house_id'] = $publishing_house->id;

        return $data;
    }
}
