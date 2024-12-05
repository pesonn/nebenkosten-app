<?php

namespace App\Filament\Resources\ServiceChargesResource\Pages;

use App\Filament\Resources\ServiceChargesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServiceChargesResource_s extends ListRecords
{
    protected static string $resource = ServiceChargesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
