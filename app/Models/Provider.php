<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'address',
        'customer_number',
        'contract_number',
    ];

    public function serviceCharges(): HasMany
    {
        return $this->hasMany(ServiceCharges::class);
    }
}
