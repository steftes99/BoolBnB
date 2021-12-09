@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
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

                    <a href="{{route('admin.apartments.index')}}">Vai ai tuoi appartamenti</a>
                </div>
            </div>
            
        </div>
        <div class="col-12 text-center p-5">
            <a class="btn btn-primary" href="{{route('admin.apartments.create')}}">Aggiungi un appartamento</a>
        </div>
    </div>
</div>
@endsection
