@extends('layouts.app')

@section('content')
  <div class="background">
    @csrf
    <div class="container p-5">
        <div class="card mb-3">
            <div class="row no-gutters">
              <div class="col-md-5">
                <img src="{{$imagePrefix}}" style="width: 100%" alt="{{$apartment->title}} image">
              </div>
              <div class="col-md-6">
                <div class="card-body">
                  <h5 class="card-title text-capitalize">{{$apartment->title}}</h5>
                  <p class="card-text">{{ $apartment->city}}, <span>{{ $apartment->region}}</span></p>
                  <p class="card-text">{{ $apartment->address }}</p>
                  <span class="card-text"> <strong>Letti: </strong>{{$apartment->beds}}, </span>
                  <span class="card-text"><strong>Stanze: </strong>{{$apartment->rooms}}</span>
                  <p class="card-text mt-2"><strong>Bagni: </strong>{{$apartment->bathrooms}}</p>
                  <p class="card-text"><strong>Metri quadri: </strong>{{$apartment->square}}</p>
                  
                  <div class="d-flex align-items-center">
  
                    @foreach ($apartment->facilities as $facility)
                      
                        <p class="mr-1 text-capitalize">{{ $facility->name }}, </p>
    
                  
                    @endforeach
                    </div>
  
                  

                  @if ( Auth::user()->id == $apartment->user->id)
                  <div class=" d-flex justify-content-start">
                    <a class="btn btn-primary _btn-color mr-1" href="{{route('admin.apartments.edit', ['apartment' => $apartment->id])}}">Modifica</a>
                      <form action="{{ route('admin.apartments.destroy', ['apartment' => $apartment->id ]) }}" 
                          method="POST"
                          class="delete-form">
                          @method('DELETE')
                          @csrf
                          <button type="submit" class="btn btn-danger _btn-color-2">Elimina</button>
                      </form>
                  </div>
                      
                  @endif
                  
                </div>
               
              </div>
              <div class="col-md-1 pr-3 pt-3">
                <a href="{{route('admin.apartments.index')}}" class="_link-pink">Torna indietro</a>
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
                

              <div class="col-12"  id="maps">
                <div id="map" style="width: 100%; height:100%;"></div>
              </div>
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