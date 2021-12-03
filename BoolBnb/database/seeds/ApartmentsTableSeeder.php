<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Apartment;
use App\User;
use Illuminate\Support\Arr;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker, User $user)
    {
            $user_ids = User::pluck('id')->toArray();

        for($i = 0 ; $i < 10; $i++){
            $newApartment = new Apartment();
            $newApartment->user_id = Arr::random($user_ids);
            $newApartment->title = $faker->sentence(5);
            $newApartment->rooms = $faker->numberBetween(1,10);
            $newApartment->beds = $faker->numberBetween(1,20);
            $newApartment->bathrooms = $faker->numberBetween(1,8);
            $newApartment->square = $faker->numberBetween(50,800);
            $newApartment->city = $faker->city();
            $newApartment->country = $faker->country(); 
            $newApartment->region = $faker->state();
            $newApartment->address = $faker->address();
            $newApartment->lat = $faker->latitude();
            $newApartment->long = $faker->longitude();
            $newApartment->image = $faker->imageUrl();
            $newApartment->visible = $faker->boolean();
            $newApartment->save();



        }
    }
}
