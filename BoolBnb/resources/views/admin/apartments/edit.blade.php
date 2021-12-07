@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Inserisci un nuovo appartamento</h1>
        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
        <form action="{{route('admin.apartments.update', ['apartment' => $apartment->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="title">Titolo</label>
                <input value="{{old('title', $apartment->title)}}" name="title" type="text" class="form-control" id="title" placeholder="Inserisci una breve descrizione">
            </div>
            <div class="form-group">
                <label for="city">Città</label>
                <input value="{{old('city', $apartment->city)}}" name="city" type="text" class="form-control" id="city" placeholder="Inserisci la città">
            </div>
            <div class="form-group">
                <label for="region">Regione</label>
                <input value="{{old('region', $apartment->region)}}" name="region" type="text" class="form-control" id="region" placeholder="Inserisci la regione">
            </div>
            <div class="form-group">
                <label for="country">Stato</label>
                <input value="{{old('country', $apartment->country)}}" name="country" type="text" class="form-control" id="country" placeholder="Inserisci lo stato">
            </div>
            <div class="form-group">
                <label for="address">Indirizzo</label>
                <input value="{{old('address', $apartment->address)}}" name="address" type="text" class="form-control" id="address" placeholder="Inserisci l'indirizzo">
            </div>
            <div class="row py-3">
                <div class="col-2">
                    <img class="img-fluid" src="{{$imagePrefix}}" alt="">
                </div>
                <div class="form-group col-10">
                    <label for="image">Inserisci l'immagine</label>
                    <input file="{{old('image', $imagePrefix)}}" name="image" type="file" class="form-control-file" id="image">
                  </div>
            </div>
            <div class="form-group">
                <label for="rooms">Stanze</label>
                <input value="{{old('rooms', $apartment->rooms)}}" name="rooms" type="text" class="form-control" id="rooms" placeholder="Inserisci il numero di stanze">
            </div>
            <div class="form-group">
                <label for="beds">Letti</label>
                <input value="{{old('beds', $apartment->beds)}}" name="beds" type="text" class="form-control" id="beds" placeholder="Inserisci il numero di letti">
            </div>
            <div class="form-group">
                <label for="bathrooms">Bagni</label>
                <input value="{{old('bathrooms', $apartment->bathrooms)}}" name="bathrooms" type="text" class="form-control" id="bathrooms" placeholder="Inserisci il numero di bagni">
            </div>
            <div class="form-group">
                <label for="square">Metri Quadri</label>
                <input value="{{old('square', $apartment->square)}}" name="square" type="text" class="form-control" id="square" placeholder="Inserisci imetri quadri">
            </div>
            <div>
                <h3>servizi</h3>
                @foreach ($facilities as $facility)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="facility-{{$facility->id}}" name="facilities[]" value="{{$facility->id}}"
                     @if (in_array( $facility->id, $facility_ids )) checked @endif >
                    
                    <label class="form-check-label" for="facility-{{$facility->id}}">{{ $facility->name}}</label>
                  </div>
                @endforeach
            </div>
            <div class="pt-3 text-center"> 
                <button type="reset" class="btn btn-primary">Resetta</button>
                <button type="submit" class="btn btn-primary">Crea</button>
            </div>
          </form>
    </div>
@endsection