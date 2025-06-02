<?php

namespace App\Filament\PublishingHouses\Resources\AuthorResource\Pages;

use App\Filament\PublishingHouses\Resources\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;
}
