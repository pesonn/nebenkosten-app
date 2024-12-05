<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\MeterReader;
use App\Models\Provider;
use App\Models\ServiceCharges;
use App\Models\ServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ServiceChargesFactory extends Factory
{
    protected $model = ServiceCharges::class;

    public function definition(): array
    {
        return [
            'period_started_at' => Carbon::now(),
            'period_ended_at' => Carbon::now(),
            'amount' => $this->faker->randomFloat(),
            'file_path' => $this->faker->word(),
            'payed_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'provider_id' => Provider::factory(),
            'service_type_id' => ServiceType::factory(),
        ];
    }
}
