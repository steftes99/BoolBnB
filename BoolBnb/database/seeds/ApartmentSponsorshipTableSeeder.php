<?php

use App\Models\Apartment;
use App\Models\ApartmentSponsorship;
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
        $apartments = Apartment::with('sponsorships')->get();
        $sponsorships = Sponsorship::pluck('hour_duration','id')->toArray();

        foreach($apartments as $apartment){
            
            $apartment->sponsorships()->attach($apartment ,[
                'sponsorship_id' => Arr::random($sponsorship_ids),
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addHours(Arr::random($sponsorships)),
            ]);
        }

    }
}
