<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location_id',
        'base_rent',
        'additional_costs',
        'started_at',
        'ended_at',
    ];

    protected function casts()
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function serviceCharges(): BelongsToMany
    {
        return $this->belongsToMany(ServiceCharges::class)->withPivot(
            'proportional',
            'proportional_unit'
        );
    }
}
