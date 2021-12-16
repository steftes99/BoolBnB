<header>
    <nav class="navbar navbar-expand-md navbar-light d-flex justify-content-between _header-bg">
        <a class=" _logo" href="{{ url('/') }}">BoolBnB</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse my_navbar" id="navbarSupportedContent">
            
           <ul class="navbar-nav ml-auto">

            @guest
                <li class="nav-item">
                    <a class="btn btn-primary _btn-color mx-1" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="btn btn-primary _btn-color" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
            
                @else
                <a class="btn btn-primary _btn-color-2" href="{{ route('admin.home') }}">Il tuo account</a>

                <li class="nav-item dropdown d-flex align-items-center">
                    <a id="navbarDropdown" class=" dropdown-toggle _border-pink p-2 mx-1" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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