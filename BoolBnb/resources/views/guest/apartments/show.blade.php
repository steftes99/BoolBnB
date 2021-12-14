@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
          @if (session('messageSuccessful'))
                        <div class="my_message">
                            <p>{{session('messageSuccessful')}}</p>
                        </div>
                    @endif
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
                 
                  <a href="{{route('guest.apartments.index')}}">Torna indietro</a>
                  {{-- <a href="{{route('message.create', $apartment->id )}}">Scrivi al proprietario</a> --}}
                  
                </div>
                <div class="col-12 col-md-8" id="maps">
                  <div id="map" style="width: 100%; height: 100%;"></div>
                </div>

                
              </div>
            </div>
            <div class="container pt-5 pb-5">
              
              <h3 class="">Contatta il proprietario</h3>
              @if ($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
              <form action="{{route('message.store', ['apartment_id' => $apartment->id])}}" method="POST" id="create-form">
                  @csrf
                  <div class="form-group">
                      <label for="name">Nome</label>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Inserisci il tuo nome">
                  </div>
                  <div class="form-group">
                      <label for="surname">Cognome</label>
                      <input name="surname" type="text" class="form-control" id="surname" placeholder="Inserisci il tuo cognome">
                  </div>
                  <div class="form-group">
                      <label for="email">Email</label>
                      <input name="email" type="text" class="form-control" id="email" placeholder="Inserisci la tua email">
                  </div>
      
                  <div class="form-group">
                      <label for="message">Messaggio</label>
                      <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                    </div>
      
                  <div class="pt-3"> 
                      <button type="reset" class="btn btn-primary">Resetta</button>
                      <button type="submit" id="button-create" class="btn btn-primary">Invia</button>
                  </div>
                  
                  
                </form>
          </div>
          </div>
          
    </div>
@endsection

@section('scripts')
<script type="text/javascript">

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