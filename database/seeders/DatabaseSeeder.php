<?php

namespace Database\Seeders;

use App\Models\Artical;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 50) as $value) {
            Artical::create([
            'name' => $faker->sentence(4),
            'author' => $faker->name,
            'content' => $faker->paragraph,
            'publication_date' => $faker->dateTimeInInterval('-1 week', '+3 days')
        ]);
        }
    }
}
