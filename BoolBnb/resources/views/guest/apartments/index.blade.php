@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session("deleted_apartment"))
            <div class="alert alert-warning">
                {{session('alert-message')}}
            </div>
        @endif
        <div class="row">
                @foreach ($apartments as $apartment)
                
                <div class="card col-3 m-3" style="width: 18rem;">
                
                 @if (!str_starts_with($apartment->image ,'http'))
                    <img src="{{asset('storage/'.$apartment->image)}}" class="card-img-top" alt="{{$apartment->name}}">
                 @else
                    <img src="{{$apartment->image}}" class="card-img-top" alt="{{$apartment->name}}">
                 @endif                    
                    <div class="card-body">
                      <h5 class="card-title">{{ $apartment->title }}</h5>
                      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      <a href="{{ route('guest.apartments.show', $apartment->id) }}" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
                @endforeach
        </div>
        <div class="col-12">
            {{$apartments->links()}}
        </div>
    </div>
@endsection


