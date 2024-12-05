<?php

namespace App\Filament\Resources\ServiceChargesResource\Pages;

use App\Filament\Resources\ServiceChargesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditServiceChargesResource extends EditRecord
{
    protected static string $resource = ServiceChargesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
