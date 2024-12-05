<?php

namespace App\Filament\Resources\MeterReaderResource\Pages;

use App\Filament\Resources\MeterReaderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMeterReader extends EditRecord
{
    protected static string $resource = MeterReaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
