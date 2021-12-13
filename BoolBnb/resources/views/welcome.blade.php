@extends('layouts.app')

@section('content')
    <main>
        <div class="jumbotron bg_img d-flex align-items-center justify-content-center">
            <div class="container d-flex flex-column justify-content-center align-items-center">
                <h3>BoolBnB</h3>
                <h1>Prenota il tuo appartamento</h1>
                <div class="input-group">
                   
                    <a type="button" href="{{ route('guest.apartments.index') }}" class="btn btn-primary btn-lg btn-block mx-1">I nostri appartamenti</a>
                </div>
            </div>
            
        </div>
    </main>
@endsection


