<?php

namespace App\Models;

use App\Observers\BillingObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy([BillingObserver::class])]
class Billing extends Model
{
    protected $fillable = [
        'period_starts_at',
        'period_ends_at',
        'location_id',
    ];


    protected function casts(): array
    {
        return [
            'period_starts_at' => 'date',
            'period_ends_at' => 'date',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function serviceCharges(): BelongsToMany
    {
        return $this->belongsToMany(ServiceCharges::class);
    }
}
