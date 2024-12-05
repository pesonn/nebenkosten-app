<?php

namespace App\Observers;

use App\Models\Billing;
use App\Services\BillingService;

class BillingObserver
{
    public function created(Billing $billing): void
    {
        $this->attachRelatedServiceChargesFromLocationsWithinBillingPeriod($billing);
    }

    public function saved(Billing $billing): void
    {
        $this->attachRelatedServiceChargesFromLocationsWithinBillingPeriod($billing);
    }

    private function attachRelatedServiceChargesFromLocationsWithinBillingPeriod(Billing $billing): void
    {
        $billingService = new BillingService($billing);
        $serviceCharges = $billingService->getRelatedServiceChargesFromLocationsWithinBillingPeriod()->pluck(
            'id'
        )->toArray();
        $billing->serviceCharges()->syncWithoutDetaching($serviceCharges);
    }
}
