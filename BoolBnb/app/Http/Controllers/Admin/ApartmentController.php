<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Facility;
use App\Models\Sponsorship;
use Braintree\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

        // SELECT * FROM 'apartments' WHERE user_id = user_id dell'utente corrente
        $apartments = Apartment::where('user_id', Auth::user()->id)->paginate(6);

        $sponsorshipDate = 0;
        $sponsorshipD = '0000-00-00';
        
        /* foreach($apartments as $apartment ){
            if($apartment->sponsorships){
                foreach($apartment->sponsorships as $sponsorship){
                    $sponsorshipD = $sponsorship->pivot->end_date;
    
                    $timeNow = "2022-01-15";
    
                    if($sponsorshipD !== '0000-00-00'){
                        $sponsorshipDate = date("d-m-Y",strtotime($sponsorshipD));
                        $tn = str_replace('-','',$timeNow);
                        $sn = str_replace('-','',$sponsorshipD);
                        
                        if($tn > $sn){
                            $apartments->sponsorships()->detach();
                        }
                    }else{
                        $sponsorshipDate = 0;
                    }
                }
            }
        } */
        
        
        /* $timeNow = Carbon::now(); */
        


    
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
        $request->validate([
            // la chiave sarò il name corrispondente nel blade.php
            // il valore sarà la lista dei requisiti per la validazione
            'title' => 'required|string|unique:apartments|min:5|max:255',
            'city' => 'required|string|min:2|max:100',
            'region' => 'required|string|min:5|max:100',
            'country' => 'required|string|min:2|max:100',
            'address' => 'required|string|min:5|max:150',
            'image' => "required|image",
            'rooms' => "required|integer|between:1,20",
            'bathrooms' => "required|integer|between:1,20",
            'beds' => "required|integer|between:1,40",
            'square' => "required|integer|between:15,500",
            'facilities' => 'nullable|exists:facilities,id'
        ],
        [
            "title.required" => 'Non è possibile inserire un appartamento senza titolo',
            "title.min" => 'Inserisci almeno 5 caratteri per la descrizione del titolo',
            "title.max" => 'Puoi inserire massimo 255 caratteri per la descrizione del titolo',
            "title.unique" => 'Questa descrizione già esiste',
            "city.required" => 'Inserisci la città',
            "city.min" => 'Inserisci almeno 2 caratteri per il campo città',
            "city.max" => 'Puoi inserire massimo 100 caratteri per il campo città',
            "region.required" => 'Inserisci la regione',
            "region.min" => 'Inserisci almeno 5 caratteri per il campo regione',
            "region.max" => 'Puoi inserire massimo 100 caratteri per il campo regione',
            "country.required" => 'Inserisci lo stato',
            "country.min" => 'Inserisci almeno 2 caratteri per il campo stato',
            "country.max" => 'Puoi inserire massimo 100 caratteri per il campo stato',
            "address.required" => 'Non è possibile inserire un appartamento senza indirizzo',
            "address.min" => 'Inserisci almeno 5 caratteri per l\'indirizzo',
            "address.max" => 'Puoi inserire massimo 150 caratteri per l\'indirizzo',
            "image.required" => 'Non è possibile inserire un appartamento senza immagine',
            "image.image" => 'Devi inserire un file immagine',
            "rooms.required" => 'Inserisci il numero di stanze',
            "rooms.between" => 'Inserisci un numero di stanze compreso tra 1 e 20',
            "rooms.integer" => 'Puoi inserire solo numeri nel campo stanze',
            "bathrooms.required" => 'Inserisci il numero di bagni',
            "bathrooms.between" => 'Inserisci un numero di bagni compreso tra 1 e 20',
            "bathrooms.integer" => 'Puoi inserire solo numeri nel campo bagni',
            "beds.required" => 'Inserisci il numero di posti letto',
            "beds.between" => 'Inserisci un numero di posti letto compreso tra 1 e 40',
            "beds.integer" => 'Puoi inserire solo numeri nel campo posti letto',
            "square.required" => 'Inserisci i metri quadri',
            "square.between" => 'I metri quadri devono essere compresi tra 15 e 500',
            "square.integer" => 'Puoi inserire solo numeri nel campo metri quadri'
        ]);

        
        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $data['image'] = Storage::put('apartments/images', $data['image']);
        $address = str_replace(' ','-',$data['address']);
        $call = file_get_contents('https://api.tomtom.com/search/2/geocode/'.$data['region'].'-'.$data['city'].'-'.$address.'.JSON?key=CskONgb89uswo1PwlNDOtG4txMKrp1yQ');
        
        $response = json_decode($call);

        $data['lat'] = $response->results[0]->position->lat;
        $data['long'] = $response->results[0]->position->lon;

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

        $sponsorships = Sponsorship::all();

        $imagePrefix = '';
        if(!str_starts_with($apartment->image ,'http')){
            $imagePrefix = asset('storage/'.$apartment->image);
        }else{
            $imagePrefix = $apartment->image;
        }

        $sponsorshipDate = 0;
        $sponsorshipD = '0000-00-00';
        
        foreach($apartment->sponsorships as $sponsorship){
            $sponsorshipD = $sponsorship->pivot->end_date;
        }
        
        $timeNow = Carbon::now();
        /* $timeNow = "2022-01-08"; */

        if($sponsorshipD !== '0000-00-00'){
            $sponsorshipDate = date("d-m-Y",strtotime($sponsorshipD));
            $tn = str_replace('-','',$timeNow);
            $sn = str_replace('-','',$sponsorshipD);
            
            if($tn > $sn){
                $apartment->sponsorships()->detach();
            }
        }else{
            $sponsorshipDate = 0;
        }
        

        return view('admin.apartments.show', compact('apartment', 'facilities', 'imagePrefix','sponsorships','sponsorshipDate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $facilities = Facility::all();
        $facility_ids = $apartment->facilities->pluck('id')->toArray();

        $imagePrefix = '';
        if(!str_starts_with($apartment->image ,'http')){
            $imagePrefix = asset('storage/'.$apartment->image);
        }else{
            $imagePrefix = $apartment->image;
        }

        return view('admin.apartments.edit', compact('apartment', 'facilities', 'facility_ids', 'imagePrefix'));
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
        $request->validate([
            // la chiave sarò il name corrispondente nel blade.php
            // il valore sarà la lista dei requisiti per la validazione
            'title' => ['required','string','max:255', 'min:5',
            Rule::unique('apartments')  // questo equivale a unique:apartments
            ->ignore($apartment->id)
            ],
            'city' => 'required|string|min:2|max:100',
            'region' => 'required|string|min:5|max:100',
            'country' => 'required|string|min:2|max:100',
            'address' => 'required|string|min:5|max:150',
            'image' => "required|image",
            'rooms' => "required|integer|between:1,20",
            'bathrooms' => "required|integer|between:1,20",
            'beds' => "required|integer|between:1,40",
            'square' => "required|integer|between:15,500",
            'facilities' => 'nullable|exists:facilities,id'
        ],
        [
            "title.required" => 'Non è possibile inserire un appartamento senza titolo',
            "title.min" => 'Inserisci almeno 5 caratteri per la descrizione del titolo',
            "title.max" => 'Puoi inserire massimo 255 caratteri per la descrizione del titolo',
            "title.unique" => 'Questa descrizione già esiste',
            "city.required" => 'Inserisci la città',
            "city.min" => 'Inserisci almeno 2 caratteri per il campo città',
            "city.max" => 'Puoi inserire massimo 100 caratteri per il campo città',
            "region.required" => 'Inserisci la regione',
            "region.min" => 'Inserisci almeno 5 caratteri per il campo regione',
            "region.max" => 'Puoi inserire massimo 100 caratteri per il campo regione',
            "country.required" => 'Inserisci lo stato',
            "country.min" => 'Inserisci almeno 2 caratteri per il campo stato',
            "country.max" => 'Puoi inserire massimo 100 caratteri per il campo stato',
            "address.required" => 'Non è possibile inserire un appartamento senza indirizzo',
            "address.min" => 'Inserisci almeno 5 caratteri per l\'indirizzo',
            "address.max" => 'Puoi inserire massimo 150 caratteri per l\'indirizzo',
            "image.required" => 'Non è possibile inserire un appartamento senza immagine',
            "image.image" => 'Devi inserire un file immagine',
            "rooms.required" => 'Inserisci il numero di stanze',
            "rooms.between" => 'Inserisci un numero di stanze compreso tra 1 e 20',
            "rooms.integer" => 'Puoi inserire solo numeri nel campo stanze',
            "bathrooms.required" => 'Inserisci il numero di bagni',
            "bathrooms.between" => 'Inserisci un numero di bagni compreso tra 1 e 20',
            "bathrooms.integer" => 'Puoi inserire solo numeri nel campo bagni',
            "beds.required" => 'Inserisci il numero di posti letto',
            "beds.between" => 'Inserisci un numero di posti letto compreso tra 1 e 40',
            "beds.integer" => 'Puoi inserire solo numeri nel campo posti letto',
            "square.required" => 'Inserisci i metri quadri',
            "square.between" => 'I metri quadri devono essere compresi tra 15 e 500',
            "square.integer" => 'Puoi inserire solo numeri nel campo metri quadri'
        ]);

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $data['image'] = Storage::put('apartments/images', $data['image']);

        $apartment->fill($data);

        $apartment->update();

        if(array_key_exists('facilities', $data)) $apartment->facilities()->sync($data['facilities']);

        return redirect()->route('admin.apartments.show', $apartment->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        if ($apartment->facilities) $apartment->facilities()->detach();
        if ($apartment->sponsorships) $apartment->sponsorships()->detach();

        $apartment->delete();

        return redirect()->route('admin.apartments.index')->with("deleted_apartment", $apartment->title )->with('alert-message', "$apartment->title è stato eliminato con successo");
    }
}
