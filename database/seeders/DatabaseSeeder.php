<?php

namespace Database\Seeders;

use App\Models\MeterReader;
use App\Models\MeterReading;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
        ]);

        MeterReader::factory(5)
            ->has(MeterReading::factory(10))
            ->create();

        $this->call([ServiceChargesSeeder::class]);
    }
}
