<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- tomtom --}}
    <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/maps/maps.css'>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/maps/maps-web.min.js"></script>
    {{-- axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>
<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-light bg-light d-flex justify-content-between">
            <a class="navbar-brand" href="{{ url('/') }}">BoolBnB</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse my_navbar" id="navbarSupportedContent">
                
               <ul class="navbar-nav ml-auto">
                <li>
                    <a class="btn btn-primary mx-2" href="{{route('guest.apartments.index')}}">Tutti gli appartamenti</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                
                    @else
                    <a class="nav-link" href="{{ route('admin.home') }}">Il tuo account</a>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                <!-- Authentication Links -->
                
            </ul>

                
              
            </div>
          </nav>
    </header>

    <main>
        @yield('content')
    </main>
    <div id="app">
    </div>
   
        <footer class="position-fixed fixed-bottom z-index-10 d-print-none">
            <div class="py-6 bg-light text-muted">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-lg-10">
                            <div class="fw-bold text-uppercase text-dark mb-3">
                                <h6 class="text-uppercase text-dark mb-3">
                                    Lorem
                                </h6>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted text-primary-hover">
                                        <i class="fab fa-twitter">
                                        </i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted text-primary-hover">
                                        <i class="fab fa-facebook">
                                        </i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted text-primary-hover">
                                        <i class="fab fa-instagram">
                                        </i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted text-primary-hover">
                                        <i class="fab fa-pinterest">
                                        </i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted text-primary-hover">
                                        <i class="fab fa-vimeo">
                                        </i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-md-6 mb-5 mb-lg-10">
                            <h6 class="text-uppercase text-dark mb-3">
                                Lorem
                            </h6>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="" class="text-muted">Lorem</a>
                                </li>
                                <li>
                                    <a href="" class="text-muted">Lorem</a>
                                </li>
                                <li>
                                    <a href="" class="text-muted">Lorem</a>
                                </li>
                                <li>
                                    <a href="" class="text-muted">Lorem</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-md-6 mb-5 mb-lg-10">
                            <h6 class="text-uppercase text-dark mb-3">
                                Lorem
                            </h6>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="" class="text-muted">Lorem</a>
                                </li>
                                <li>
                                    <a href="" class="text-muted">Lorem</a>
                                </li>
                                <li>
                                    <a href="" class="text-muted">Lorem</a>
                                </li>
                                <li>
                                    <a href="" class="text-muted">Lorem</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <h6 class="text-uppercase text-dark mb-3">
                                Lorem
                            </h6>
                            <p class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 fw-light bg-dark text-gray-300">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-start">
                            <p class="text-sm mb-md-0 text-light">
                                © 2021, BoolBnB. All rights reserved.
                            </p>
                        </div>
                        <div class="col-md-6">
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </footer>
    @yield('scripts')
</body>
</html>
