<?php

namespace App\Filament\Resources\MeterReaderResource\Pages;

use App\Filament\Resources\MeterReaderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeterReaders extends ListRecords
{
    protected static string $resource = MeterReaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
