@extends('layouts.app')

@section('content')
@csrf
    <div class="container">
        <div class="card mb-3">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="{{$imagePrefix}}" style="width: 100%" alt="{{$apartment->title}} image">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">{{$apartment->title}}</h5>
                  <p class="card-text">{{ $apartment->region}}. <span>{{ $apartment->city}}</span></p>
                  <p class="card-text">{{$apartment->city}}</p>
                  <p class="card-text">{{ $apartment->address }}</p>
                  <p class="card-text"> <strong>Letti: </strong>{{$apartment->beds}}</p>
                  <p class="card-text"><strong>Stanze: </strong>{{$apartment->rooms}}</p>
                  <p class="card-text"><strong>Bagni: </strong>{{$apartment->bathrooms}}</p>
                  <p class="card-text"><strong>Metri quadri: </strong>{{$apartment->square}}</p>
                  
                  <div class="d-flex">
                    
                    @foreach ($apartment->facilities as $facility)
                      <p class="card-text p-1">{{ $facility->name }}</p>
                  @endforeach
                  </div>
  
                  <a href="{{route('admin.apartments.index')}}">Torna indietro</a>

                  @if ( Auth::user()->id == $apartment->user->id)
                      <a class="btn btn-primary" href="{{route('admin.apartments.edit', ['apartment' => $apartment->id])}}">Modifica</a>
                      <form action="{{ route('admin.apartments.destroy', ['apartment' => $apartment->id ]) }}" 
                          method="POST"
                          class="delete-form">
                          @method('DELETE')
                          @csrf
                          <button type="submit" class="btn btn-danger">Elimina</button>
                      </form>
                  @endif
                  
                </div>
              </div>
              @if ( Auth::user()->id == $apartment->user->id)
              {{-- Braintree container --}}
              <div class="col-12 p-5">
                <div id="appBraintree"></div>                     
              </div>
              {{-- Map conatiner --}}
                <div class="col-12 p-5">
                  <div id="dropin-container"></div>
                  <div class="col-12 text-center">
                    <button id="submit-button" class="btn btn-primary">Richiesta metodo di pagamento</button>
                  </div>              
                </div>
              @endif
                

              <div class="col-12 col-md-8" id="maps">
                <div id="map"></div>
              </div>
            </div>
          </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/appBraintree.js') }}"></script>
<script type="text/javascript"> 


let lat = {{$apartment->lat}}
let lon = {{$apartment->long}}

if(( lat != 0) || ( lon != 0)){
  let map = tt.map({
      key: 'CskONgb89uswo1PwlNDOtG4txMKrp1yQ',
      container: 'map',
      center: [
        {{$apartment->long}},
        {{$apartment->lat}}  
      ],
      zoom: 16
  });
  let marker = new tt.Marker()
  .setLngLat([
    {{$apartment->long}},
    {{$apartment->lat}}
  ])
  .addTo(map);
  marker.setPopup(new tt.Popup()
  .setHTML(`
  <h5>{{$apartment->title}}</h5>
  <p>{{$apartment->address}}</p>`
  ));
}



</script>
@endsection