<?php

namespace App\Filament\Resources\ServiceChargesResource\Pages;

use App\Filament\Resources\ServiceChargesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceCharges extends ViewRecord
{
    protected static string $resource = ServiceChargesResource::class;

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
