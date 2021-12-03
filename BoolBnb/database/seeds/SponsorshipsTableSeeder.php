<?php

use Illuminate\Database\Seeder;
use App\Models\Sponsorship;

class SponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prices = [2.99, 5.99, 9.99];
        $durations = [24, 72, 144];

        for($i = 0 ; $i < count($prices); $i++){
            $newSponsorship = new Sponsorship();
            $newSponsorship->price = $prices[$i];
            $newSponsorship->hour_duration = $durations[$i];
            $newSponsorship->save();
        }
    }
}
