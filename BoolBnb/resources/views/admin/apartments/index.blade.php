@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            
                @foreach ($apartments as $apartment)
                
                <div class="card col-3 m-3" style="width: 18rem;">
                    <img src="{{$apartment->image}}" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">{{ $apartment->title }}</h5>
                      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      <a href="{{ route('admin.apartments.show', $apartment->id) }}" class="btn btn-primary">Go somewhere</a>
                    </div>
                  </div>
                @endforeach
            
        </div>
        
    </div>
@endsection