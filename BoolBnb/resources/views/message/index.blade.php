@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
          @foreach ($apartments as $apartment)
          <div class="container">
            <h1> {{$apartment->title}}</h1>
          </div>
            @foreach ($apartment->messages as $message)
                <div class="card col m-3" style="width: 18rem;">                  
                  <div class="card-body">
                    <h4> <strong>Mittente</strong> </h4>
                    <div class="mittente d-flex">
                      <p class="card-title mr-2"><strong>Nome:</strong>{{ $message->name}}</p>
                      <p class="card-title"><strong>Cognome:</strong>{{ $message->surname }}</p>
                    </div>  
                    <p class="card-title"><strong>Email:</strong>{{ $message->email }}</p>
                    <h4> <strong>Messaggio</strong> </h4> 
                    <p class="card-text">{{$message->message}}</p>
                  </div>
              </div>
            @endforeach
          @endforeach
                
        </div>
    </div>
@endsection

