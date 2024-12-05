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
        return $this->billing->location->serviceCharges()->whereBetween(
            'period_started_at',
            [$this->billing->period_starts_at, $this->billing->period_ends_at]
        )->orWhereBetween(
            'period_ended_at',
            [$this->billing->period_starts_at, $this->billing->period_ends_at]
        )->get();
    }
}
