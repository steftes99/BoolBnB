@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Invia il tuo messaggio</h1>
        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <form action="{{route('message.store', ['apartment_id'])}}" method="POST" id="create-form">
            @csrf
            <p>{{$apartment->id}}</p>
            <div class="form-group">
                <label for="name">Nome</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Inserisci il tuo nome">
            </div>
            <div class="form-group">
                <label for="surname">Cognome</label>
                <input name="surname" type="text" class="form-control" id="surname" placeholder="Inserisci il tuo cognome">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input name="email" type="text" class="form-control" id="email" placeholder="Inserisci la tua email">
            </div>

            <div class="form-group">
                <label for="message">Messaggio</label>
                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
              </div>

            <div class="pt-3"> 
                <button type="reset" class="btn btn-primary">Resetta</button>
                <button type="submit" id="button-create" class="btn btn-primary">Invia</button>
            </div>
            
            
          </form>
    </div>
@endsection