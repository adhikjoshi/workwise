<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 15) as $value) {
            Candidate::create([
            'name' => $faker->name,
            'title' => $faker->jobTitle,
            'type_of_employment' => $faker->randomElement(['fulltime', 'partime','contract','internship']),
            'skills' => $faker->randomElement(['php', 'laravel','mysql','api','json']),
            'location' => $faker->city,
            'last_active' => $faker->dateTimeInInterval('-4 week', '+1 days')
        ]);
        } 
    }
}
