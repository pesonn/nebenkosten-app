<?php

namespace App\Observers;

use App\Models\LocationServiceCharges;

class LocationServiceChargesObserver
{
    public function saved(LocationServiceCharges $locationServiceCharges): void
    {
        $locationServiceCharges->serviceCharge->recalculateRatioAmountForLocations();
    }
}
