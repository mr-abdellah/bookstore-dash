<?php

namespace App\Filament\PublishingHouses\Resources\OrderResource\Pages;

use App\Filament\PublishingHouses\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
