<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 10; $i++){

            $newUser = new User();
            $newUser->name = $faker->name();
            $newUser->surname = $faker->lastName();
            $newUser->email = $faker->email();
            $newUser->password = bcrypt($faker->password(8,10));
            $newUser->date_of_birth = $faker->dateTimeBetween();
            $newUser->save();

        }
    }
}
