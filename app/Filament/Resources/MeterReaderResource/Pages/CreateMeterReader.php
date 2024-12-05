<?php

namespace App\Filament\Resources\MeterReaderResource\Pages;

use App\Filament\Resources\MeterReaderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMeterReader extends CreateRecord
{
    protected static string $resource = MeterReaderResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
