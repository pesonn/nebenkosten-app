<?php

namespace App\Services;

use App\Models\Billing;
use Illuminate\Support\Collection;

class BillingService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Billing $billing)
    {
        //
    }

    public function getRelatedServiceChargesFromLocationsWithinBillingPeriod(): Collection
    {
        return $this->billing->location->serviceCharges()
            ->withinPeriod(
                $this->billing->period_starts_at,
                $this->billing->period_ends_at
            )
            ->orderBy('period_started_at')
            ->get();
    }

    public function attachRelatedServiceChargesFromLocationsWithinBillingPeriod(): void
    {
        $serviceCharges = $this->getRelatedServiceChargesFromLocationsWithinBillingPeriod()
            ->pluck(
                'id'
            )
            ->toArray();

        $this->billing->serviceCharges()->syncWithoutDetaching($serviceCharges);
    }
}
