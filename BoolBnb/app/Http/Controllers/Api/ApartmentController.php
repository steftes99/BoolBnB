<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Facility;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::with('facilities')->get();

        $facilities = Facility::all();

        $sponsorships = Sponsorship::all();

        return response()->json(compact('apartments','facilities','sponsorships'),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apartment = Apartment::find($id);
        if ( $apartment ) return response()->json($apartment);
        else return response('',404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
       $data = $request->all();
       
       if(array_key_exists('sponsorship', $data)) {
           /* $apartment->sponsorships()->sync($data['sponsorship']); */
           
            $apartment->sponsorships()->detach();

            if($data['sponsorship'] == 1){
                $apartment->sponsorships()->attach($apartment ,[
                    'sponsorship_id' => $data['sponsorship'],
                    'start_date' => Carbon::now(),
                    'end_date' => Carbon::now()->addHours(24),
                ]);
            }elseif($data['sponsorship'] == 2){
                $apartment->sponsorships()->attach($apartment ,[
                    'sponsorship_id' => $data['sponsorship'],
                    'start_date' => Carbon::now(),
                    'end_date' => Carbon::now()->addHours(72),
                ]);
            }elseif($data['sponsorship'] == 3){
                $apartment->sponsorships()->attach($apartment ,[
                    'sponsorship_id' => $data['sponsorship'],
                    'start_date' => Carbon::now(),
                    'end_date' => Carbon::now()->addHours(144),
                ]);
            }
            
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
