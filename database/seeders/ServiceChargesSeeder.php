<?php

namespace Database\Seeders;

use App\Models\MeterReader;
use App\Models\ServiceCharges;
use App\Models\Location;
use Illuminate\Database\Seeder;

class ServiceChargesSeeder extends Seeder
{
    public function run(): void
    {
        ServiceCharges::factory(2)->hasAttached(
            Location::factory(),
            ['proportional' => fake()->numberBetween(0, 100), 'proportional_unit' => "%"]
        )->create();

        ServiceCharges::factory(2)->hasAttached(
            MeterReader::factory()
        )->create();
    }
}
