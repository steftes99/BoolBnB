<?php


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class ,
            ApartmentsTableSeeder::class,
            FacilitiesTableSeeder::class,
            SponsorshipsTableSeeder::class,
            MessagesTableSeeder::class,
            StatsTableSeeder::class,
            ApartmentFacilityTableSeeder::class,
            ApartmentSponsorshipTableSeeder::class
        ]);
       
    }
}
