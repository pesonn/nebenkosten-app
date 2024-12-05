<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_rechargeable',
    ];

    public function serviceCharges(ServiceCharges $serviceCharges): HasMany
    {
        return $this->hasMany($serviceCharges);
    }
}
