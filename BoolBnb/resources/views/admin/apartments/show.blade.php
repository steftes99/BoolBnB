@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="{{$imagePrefix}}" style="width: 100%" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">{{$apartment->title}}</h5>
                  <p class="card-text">{{ $apartment->region }}</p>
                  <p class="card-text">{{$apartment->city}}</p>
                  <p class="card-text">{{ $apartment->address }}</p>
                  <p class="card-text"> <strong>Letti: </strong>{{$apartment->beds}}</p>
                  <p class="card-text"><strong>Stanze: </strong>{{$apartment->rooms}}</p>
                  <p class="card-text"><strong>Bagni: </strong>{{$apartment->bathrooms}}</p>
                  <p class="card-text"><strong>Metri quadri: </strong>{{$apartment->square}}</p>
                  
                  <div class="d-flex">
                    
                    @foreach ($apartment->facilities as $facility)
                    
                      <p class="card-text p-1">{{ $facility->name }}</p>
  
                
                  @endforeach
                  </div>
                 
                  <a href="{{route('admin.apartments.index')}}">Torna indietro</a>
                  <a class="btn btn-primary" href="{{route('admin.apartments.edit', ['apartment' => $apartment->id])}}">Modifica</a>
                  <form action="{{ route('admin.apartments.destroy', ['apartment' => $apartment->id ]) }}" 
                    method="POST"
                    class="delete-form">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection