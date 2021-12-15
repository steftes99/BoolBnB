@extends('layouts.app')

@section('content')
    <main>
        <div class=" bg_img d-flex align-items-center justify-content-center">
            <div class="container d-flex flex-column justify-content-center align-items-center">
                <h2>BoolBnB</h2>
                <h1>Prenota il tuo appartamento</h1>
                <div class="input-group">
                   
                    <a type="button" href="{{ route('guest.apartments.index') }}" class="btn btn-dark btn-lg btn-block mx-1">Cerca il tuo appartamento</a>
                </div>
            </div>
            
        </div>
    </main>
@endsection


