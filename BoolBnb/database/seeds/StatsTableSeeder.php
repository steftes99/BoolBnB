<?php

use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Stat;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

class StatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartment_ids = Apartment::pluck('id')->toArray();

        for($i = 0; $i < 100; $i++){
            $newStat = new Stat();
            $newStat->apartment_id = Arr::random($apartment_ids);
            $newStat->ip = $faker->ipv4();
            $newStat->date = $faker->dateTime();
            $newStat->save();
        }

    }
}
