<?php

namespace App\Observers;

use App\Models\Billing;
use App\Services\BillingService;

class BillingObserver
{
    public function created(Billing $billing): void
    {
        (new BillingService($billing))->attachRelatedServiceChargesFromLocationsWithinBillingPeriod();
    }

    public function saved(Billing $billing): void
    {
        (new BillingService($billing))->attachRelatedServiceChargesFromLocationsWithinBillingPeriod();
    }


}
