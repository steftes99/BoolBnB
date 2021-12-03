<?php

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilities = ['piscina','wifi','posto macchina','sauna','portineria','vista mare','aria condizionata','ascensore','balcone','tv','ferro da stiro','asciugamani','lenzuola','riscaldamento','asciugacapelli','estintore','bagno in comune','bagno in stanza','cortile'];

        foreach( $facilities as $facility){
            $newFacility = new Facility();
            $newFacility->name = $facility;
            $newFacility->save();
        }

    }
}
