<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::all();
        // Apartment::where('user_id', Auth::user()->id);
        $apartments = Apartment::where('user_id', Auth::user()->id)->get();
        // dd($apartments);
        return view('message.index', compact('messages','apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Apartment $apartment)
    {
        // dd($apartment_id);
        return view('message.create', compact('apartment'));
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
            'name' => 'required|string|min:2|max:15',
            'surname' => 'required|string|min:2|max:20',
            'email' => 'required|email|min:5|max:30',
            'message' => 'required|string|min:15|max:255',
      
        ],
        [
            "name.required" => 'Inserisci il nome',
            "name.min" => 'Il nome deve essere lungo almeno 2 caratteri',
            "name.max" => 'Il nome deve essere lungo massimo 15 caratteri',
            "surname.required" => 'Inserisci il cognome',
            "surname.min" => 'Il cognome deve essere lungo almeno 2 caratteri',
            "surname.max" => 'Il cognome deve essere lungo massimo 20 caratteri',
            "email.required" => 'Inserisci la tua email',
            "email.email" => 'Devi inserire una email valida',
            "email.max" => 'L\' email deve essere lungo al massimo 30 caratteri',
            "email.min" => 'L\' email deve essere lungo minimo 5 caratteri',
            "message.required" => 'Inserisci il testo del messaggio',
            "message.min" => 'Il messaggio deve essere lungo almeno 15 caratteri',
            "message.max" => 'Il messaggio deve essere lungo massimo 255 caratteri',
      
        ]);

        $data = $request->all();

        $message = new Message();

        $message->fill($data);

        $message->save();

        $apartment_id = $data['apartment_id'];

        $messageSuccessful = 'Grazie per averci contattato! Riceverà una messaggio di risposta al più presto.';

        return redirect()->route('guest.apartments.show', $apartment_id)->with('messageSuccessful', $messageSuccessful);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
