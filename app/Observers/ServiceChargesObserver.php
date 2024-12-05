<?php

namespace App\Observers;

use App\Models\ServiceCharges;

class ServiceChargesObserver
{

    public function updated(ServiceCharges $serviceCharges): void
    {
        $serviceCharges->recalculateRatioAmountForLocations();
    }
}
