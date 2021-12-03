<?php

use App\Models\Apartment;
use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ApartmentFacilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilities_ids = Facility::pluck('id')->toArray();
        $apartments = Apartment::all();

        

        foreach($apartments as $apartment){
            $apartment->facilities()->sync([
                Arr::random($facilities_ids),
                Arr::random($facilities_ids),
                Arr::random($facilities_ids),
                Arr::random($facilities_ids),
                Arr::random($facilities_ids),
                Arr::random($facilities_ids),
                Arr::random($facilities_ids),
                Arr::random($facilities_ids),
            ]);
        }
    }
}
