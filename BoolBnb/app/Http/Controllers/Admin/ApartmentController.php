<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Facility;
use Illuminate\Http\Request;
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
    public function destroy($id)
    {
        //
    }
}
