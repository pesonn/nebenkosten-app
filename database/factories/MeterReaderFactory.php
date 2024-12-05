<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\MeterReader;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MeterReaderFactory extends Factory
{
    protected $model = MeterReader::class;

    public function definition(): array
    {
        return [
            'meter_number' => $this->faker->randomNumber(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'location_id' => Location::factory(),
        ];
    }
}
