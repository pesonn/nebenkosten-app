<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class MeterReading extends Model
{
    use HasFactory;

    public function meterReader(): BelongsTo
    {
        return $this->belongsTo(MeterReader::class);
    }
}
