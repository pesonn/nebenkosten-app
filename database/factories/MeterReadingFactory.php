<?php

namespace Database\Factories;

use App\Models\MeterReader;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MeterReading>
 */
class MeterReadingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'meter_reader_id' => MeterReader::factory(),
            'reading' => fake()->numberBetween(1, 100000),
            'reading_date' => fake()->dateTimeBetween('-2 years'),
        ];
    }
}
