<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'base_rent' => $this->faker->numberBetween(350, 550),
            'additional_costs' => $this->faker->numberBetween(200, 400),
            'started_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'location_id' => Location::factory(),
        ];
    }
}
