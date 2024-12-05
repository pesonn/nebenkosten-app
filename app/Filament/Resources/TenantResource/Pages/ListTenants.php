<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Filament\Resources\TenantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTenants extends ListRecords
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }


    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'active' => Tab::make()->modifyQueryUsing(
                fn(Builder $query) => $query->where(['ended_at' => null])
            ),
            'inactive' => Tab::make()->modifyQueryUsing(
                fn(Builder $query) => $query->where(['ended_at' => !null])
            ),
        ];
    }
}
