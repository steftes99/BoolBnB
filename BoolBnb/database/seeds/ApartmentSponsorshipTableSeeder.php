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
        $apartments = Apartment::with('sponsorships')->get();
        /* $apartments = Apartment::all(); */

        foreach($apartments as $apartment){
            $now = Carbon::now();
            $apartment->sponsorships()->sync(Arr::random($sponsorship_ids));
            /* $apartment->sponsorships()->start_date = $now;
            $apartment->sponsorships()->end_date = $now->addHours(1); */
        }
    }
}
