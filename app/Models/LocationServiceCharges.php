<?php

namespace App\Models;

use App\Observers\LocationServiceChargesObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([LocationServiceChargesObserver::class])]
class LocationServiceCharges extends Pivot
{

    protected $fillable = [
        'amount',
        'proportional',
        'proportional_unit',
        'related_meter_readers',
    ];

    protected $casts = [
        'related_meter_readers' => 'array',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function serviceCharge(): BelongsTo
    {
        return $this->belongsTo(ServiceCharges::class, 'service_charges_id');
    }

}
