<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'description',
        'name',
    ];

    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class);
    }

    public function meterReaders(): HasMany
    {
        return $this->hasMany(MeterReader::class);
    }

    public function serviceCharges(): BelongsToMany
    {
        return $this->belongsToMany(ServiceCharges::class)->withPivot(
            'amount',
            'proportional',
            'proportional_unit',
            'related_meter_readers'
        )->using(LocationServiceCharges::class);
    }

    public function billings(): HasMany
    {
        return $this->hasMany(Billing::class);
    }

    /**
     * Returns Percentage as float. E.q. 19 = 0.19
     * @returns float
     */
    public function getPercentageForServiceCharge(ServiceCharges $serviceCharge): float
    {
        return $this->serviceCharges()->where(
                'service_charges_id',
                $serviceCharge->id
            )->first()->pivot->proportional / 100;
    }
}
