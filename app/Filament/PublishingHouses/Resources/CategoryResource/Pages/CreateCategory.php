<?php

namespace App\Filament\PublishingHouses\Resources\CategoryResource\Pages;

use App\Filament\PublishingHouses\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $publishing_house = Auth::user()->publishingHouse;
        $data['publishing_house_id'] = $publishing_house->id;
        return $data;
    }
}
