@extends('layouts.app')

@section('content')
    <main>
        <div class="jumbotron bg_img d-flex align-items-center justify-content-center">
            <div class="container d-flex flex-column justify-content-center">
                <h3>BoolBnB</h3>
                <h1>Prenota il tuo appartamento</h1>
                <div class="input-group">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                    aria-describedby="search-addon" />
                    <button type="button" class="btn btn-primary mx-1">search</button>
                </div>
            </div>
            
        </div>
    </main>
@endsection


