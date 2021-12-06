<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
     public function index()
    {
        $apartments = Apartment::all();
        
        
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $facilities = Facility::all();

        return view('admin.apartments.create', compact('facilities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dump($request);

       

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $data['image'] = Storage::put('apartments/images', $data['image']);

        $apartment = new Apartment();

        $apartment->fill($data);

        $apartment->save();

        if(array_key_exists('facilities', $data)) $apartment->facilities()->sync($data['facilities']);

        return redirect()->route('admin.apartments.show', $apartment->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $facilities = Facility::all();

        $imagePrefix = '';
        if(!str_starts_with($apartment->image ,'http')){
            $imagePrefix = asset('storage/'.$apartment->image);
        }else{
            $imagePrefix = $apartment->image;
        }

        return view('admin.apartments.show', compact('apartment', 'facilities', 'imagePrefix'));
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
    public function update(Request $request, $id)
    {
        //
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
