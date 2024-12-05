<?php

namespace App\Filament\Resources\ServiceChargesResource\Pages;

use App\Filament\Resources\ServiceChargesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateServiceChargesResource extends CreateRecord
{
    protected static string $resource = ServiceChargesResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
