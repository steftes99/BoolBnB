@extends('layouts.app')

@section('content')
    <div class="home-wrapper">

        <div class="jumbo d-flex justify-content-center align-items-center">
            <h1 class="text-center">Bentornato su BoolBnB!</h1>
        </div>
    
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4 col-md-12 d-flex flex-column align-items-center my-5">
                    <div class="_img-container d-flex justify-content-center align-items-center">
                        {{-- <img class="rounded-circle _roundimg" src="{{ url('/assets/img/Colosseo.jpg') }}" alt=""> --}}
                        <i class="fas fa-house-user fa-8x mb-3"></i>
                    </div>
                    <h3 class="text-center">Visualizza i tuoi appartamenti</h3>
                    <a class="btn btn-dark _btn-color mt-1" href="{{ route('admin.apartments.index') }}">Vai ai tuoi appartamenti</a>
                </div>
                <div class="col-lg-4 col-md-12 d-flex flex-column align-items-center my-5">
                    <div class="_img-container d-flex justify-content-center align-items-center">
                        {{-- <img class="rounded-circle _roundimg" src="{{ url('/assets/img/Colosseo.jpg') }}" alt=""> --}}
                        <i class="fas fa-plus-square fa-8x mb-3"></i>
                    </div>
                    
                    <h3 class="text-center">Aggiungi un appartamento</h3>
                    <a class="btn btn-dark _btn-color mt-1" href="{{ route('admin.apartments.create') }}">Aggiungi</a>
                </div>
                <div class="col-lg-4 col-md-12 d-flex flex-column align-items-center my-5">
                    <div class="_img-container d-flex justify-content-center align-items-center">
                        {{-- <img class="rounded-circle _roundimg" src="{{ url('/assets/img/Colosseo.jpg') }}" alt=""> --}}
                        <i class="fas fa-envelope fa-8x mb-3"></i>
                    </div>
                    <h3 class="text-center">Messaggi ricevuti</h3>
                    <a class="btn btn-dark _btn-color mt-1" href="">Visualizza</a>
                </div>
            </div>
        </div>

    </div>
   

    
        
    
    


    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                   
                </div>
            </div>
            
        </div>
        <div class="col-12 text-center p-5">
            <a class="btn btn-primary" href="{{route('admin.apartments.create')}}">Aggiungi un appartamento</a>
        </div>
    </div> --}}

@endsection
