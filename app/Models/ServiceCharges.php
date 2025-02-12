<?php

namespace App\Models;

use App\Enums\ServiceTypeCalculationBase;
use App\Observers\ServiceChargesObserver;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy([ServiceChargesObserver::class])]
class ServiceCharges extends Model
{
    use HasFactory;

    protected $casts = [
        'calculation_base' => ServiceTypeCalculationBase::class,
    ];

    protected $fillable = [
        'provider_id',
        'service_type_id',
        'invoice_id',
        'meter_reader_id',
        'amount',
        'total_usage',
        'usage_unit',
        'calculation_base',
        'period_started_at',
        'period_ended_at',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function meterReaders(): BelongsToMany
    {
        return $this->belongsToMany(
            MeterReader::class
        );
    }

    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class)->withPivot(
            'usage',
            'amount',
            'related_meter_readers'
        )->using(
            LocationServiceCharges::class
        );
    }

    public function billings(): BelongsToMany
    {
        return $this->belongsToMany(Billing::class);
    }

    public function isRechargeable(): bool
    {
        return $this->serviceType->is_rechargeable;
    }

    public function recalculateRatioAmountForLocations(): void
    {
        if (!$this->locations) {
            return;
        }
        foreach ($this->locations as $location) {
            $ratio = $location->pivot->usage / 100;

            $newCalculatedAmount = round($this->amount * $ratio, 2);
            if ($newCalculatedAmount === $location->pivot->amount) {
                continue;
            }
            $this->locations()->updateExistingPivot($location->id, ['amount' => $newCalculatedAmount]);
        }
    }

    public function scopeWithinPeriod(Builder $query, Carbon $start, Carbon $end): Builder
    {
        return $query->where('period_started_at', '<=', $end)
            ->where('period_ended_at', '>=', $start);
    }
}
