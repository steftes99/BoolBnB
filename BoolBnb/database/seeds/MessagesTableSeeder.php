<?php

use App\Models\Apartment;
use App\Models\Message;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartment_ids = Apartment::pluck('id')->toArray();

        for($i = 0; $i < 15; $i++){
            $newMessage = new Message();
            $newMessage->apartment_id = Arr::random($apartment_ids);
            $newMessage->email = $faker->email();
            $newMessage->message = $faker->paragraph();
            $newMessage->name = $faker->name();
            $newMessage->surname = $faker->lastName();
            $newMessage->save();
        }
    }
}
