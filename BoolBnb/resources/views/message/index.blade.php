@extends('layouts.app')

@section('content')
<div class="_message-bg">
  <div class="container">
    <div class="row ">
      @foreach ($apartments as $apartment)
      <div class="container ">
        <h1> {{$apartment->title}}</h1>
      </div>
        @foreach ($apartment->messages as $message)
            <div class="card col m-3 _border-register" style="width: 18rem;">                  
              <div class="card-body">
                <h5> <strong>MITTENTE</strong> </h5>
                <div class="mittente d-flex">
                  <p class="card-title mr-2"><strong>Nome: </strong>{{ $message->name}}</p>
                  <p class="card-title mx-2"><strong>Cognome: </strong>{{ $message->surname }}</p>
                  <p class="card-title"><strong>Email: </strong>{{ $message->email }}</p>
                </div>  
               
                <h5> <strong>MESSAGGIO</strong> </h5> 
                <div class="row">
                  <div class="col-9">
                    <p class="card-text">{{$message->message}}</p>
                  </div>
                  <div class="col-3 d-flex justify-content-center align-items-center">
                    <button class="btn btn-primary _btn-color ">Visualizza il messaggio</button>
                  </div>
                </div>
                

              </div>
          </div>
        @endforeach
      @endforeach
            
    </div>
</div>
</div>
    
@endsection

