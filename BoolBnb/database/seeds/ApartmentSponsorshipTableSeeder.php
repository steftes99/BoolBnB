<?php

use App\Models\Apartment;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ApartmentSponsorshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorship_ids = Sponsorship::pluck('id')->toArray();
        $apartments = Apartment::all();

        foreach($apartments as $apartment){
            $apartment->sponsorships()->sync(Arr::random($sponsorship_ids));
        }

        


    }
}