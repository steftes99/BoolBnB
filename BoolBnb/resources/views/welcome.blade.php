@extends('layouts.app')

@section('content')
    <main>
        <div class=" bg_img d-flex align-items-center justify-content-center">
            <div class="container d-flex flex-column justify-content-center align-items-center">
                <h1>BoolBnB</h1>
                <h1>Inizia la ricerca</h1>
                <div class="input-group">
                   
                    <a type="button" href="{{ route('guest.apartments.index') }}" class="btn btn-dark btn-lg btn-block mx-1 _hover-welcome">Cerca il tuo appartamento</a>
                </div>
            </div>
            
        </div>
        <div class="container p-3">
            <div class="row p-3">
                <div class="col-12 my-3">
                    <h1 class="dark-title">Destinazioni per le vacanze 2021</h1>
                </div>
            </div>

            <div class="row my-2">
                <div class="col-lg-3 col-sm-12 mb-5">
                    <div class="card bg-light">
                        <div class="img-container _napoli">
                            
                        </div>
                        
                            <div class="card-body _bg-card">
                                <h2>Napoli</h2>
                                <a href="{{ route('guest.apartments.index') }}" class="btn btn-primary my-2">Scopri di più</a>
                            </div>
                     </div>
                </div>
                <div class="col-lg-3 col-sm-12 mb-5">
                    
                    <div class="card bg-light">
                            <div class="img-container _mare">
                                
                            </div>
                        
                        
                            <div class="card-body _bg-card">
                                <h2>Sardegna</h2>
                                <a href="{{ route('guest.apartments.index') }}" class="btn btn-primary my-2">Scopri di più</a>
                            </div>
                     </div>
                </div>
                <div class="col-lg-3 col-sm-12 mb-5">
                    <div class="card bg-light _border-radius">
                        <div class="img-container _neve">

                        </div>
                            <div class="card-body _bg-card">
                                <h2>Cortina</h2>
                                <a href="{{ route('guest.apartments.index') }}" class="btn btn-primary my-2">Scopri di più</a>
                            </div>
                     </div>
                </div>
                <div class="col-lg-3 col-sm-12 mb-5">
                    <div class="card bg-light rounded-lg">
                        <div class="img-container _trapani">

                        </div>
                            <div class="card-body _bg-card">
                                <h2>Trapani</h2>
                                <a href="{{ route('guest.apartments.index') }}" class="btn btn-primary my-2">Scopri di più</a>
                            </div>
                     </div>
                </div>
            </div>
                
                
            
        </div>
    </main>
@endsection


