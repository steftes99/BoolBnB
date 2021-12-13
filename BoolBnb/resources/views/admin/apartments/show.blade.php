@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="{{$imagePrefix}}" style="width: 100%" alt="{{$apartment->title}} image">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">{{$apartment->title}}</h5>
                  <p class="card-text">{{ $apartment->region }}</p>
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
                  <a class="btn btn-primary" href="{{route('admin.apartments.edit', ['apartment' => $apartment->id])}}">Modifica</a>
                  <form action="{{ route('admin.apartments.destroy', ['apartment' => $apartment->id ]) }}" 
                    method="POST"
                    class="delete-form">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </div>
              </div>
              <div class="col-12 col-md-8" id="maps">
                <div id="map" style="width: 100%; height: 100%;"></div>
              </div>
            </div>
          </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">


const address = "{{$apartment->address}}"
const region = "{{$apartment->region}}"
const city = "{{$apartment->city}}"

    console.log(address +':'+ city +':'+ region);
    let searchMap = [];

    axios.get(`https://api.tomtom.com/search/2/geocode/${region}-${city}-${address}.JSON?key=CskONgb89uswo1PwlNDOtG4txMKrp1yQ`)
    .then(function (response) {
        console.log(response);
        searchMap = response.data.results;
        console.log(searchMap);

    })
    .catch(function (error){
        // handle error
        console.log(error);
    });

    axios.patch(`https://127.0.0.1:8000/api/api/apartments/{{$apartment->id}}`,{
      lat:searchMap[0].position.lat;
      long:searchMap[0].position.lon;
    })
    .then(function( response ){
        // Handle success
    }.bind(this));



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


</script>
@endsection