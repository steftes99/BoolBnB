@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session("deleted_apartment"))
            <div class="alert alert-warning">
                {{session('alert-message')}}
            </div>
        @endif
    </div>
        <div class="row m-0">
            <div class="col-12 _title d-flex justify-content-center align-items-center">
                <h1 class="text-center"> <strong>I tuoi appartamenti</strong></h1>
            </div>
        </div>
    <div class="container">
        <div class="row py-3 d-flex justify-content-around">
            
            @foreach ($apartments as $apartment)
            
            <div class="col-5 m-1">
                <div class="row my-1 _border _apartment bg-white">
                    <div class="col-5 py-3">
                        @if (!str_starts_with($apartment->image ,'http'))
                             <img src="{{asset('storage/'.$apartment->image)}}" class="img-fluid p-1"  alt="{{$apartment->name}}">
                        @else
                            <img src="{{$apartment->image}}" class="img-fluid" alt="{{$apartment->name}}">
                         @endif 
                    </div>
                    <div class="col-7 py-3">
                        <div class="">
                            <h5 class="text-capitalize">{{ $apartment->title }}</h5>
                            <p class="text-capitalize">{{ $apartment->city }}, {{ $apartment->region }}</p>
                            <p class="text-capitalize">{{ $apartment->address }}</p>
                            <a href="{{ route('admin.apartments.show', $apartment->id) }}" class="btn btn-primary _btn-color">Visualizza</a>
                          </div>
                    </div>
                </div>
            
                                
                
            </div>
            @endforeach
    </div>
    <div class="col-12">
        {{$apartments->links()}}
    </div>
    </div>
        
    
@endsection


