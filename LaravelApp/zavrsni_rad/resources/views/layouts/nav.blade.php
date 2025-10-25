<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-2">
    <div class="container">

        <a class="navbar-brand text-success font-weight-bold text-uppercase d-flex align-items-center" href="{{ url('/home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo align-middle mr-2" style="height: 2.2em; width: auto; vertical-align: middle;">
            <span>
                Od Njive <br>
                Do Stola
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Ponuda</a>
                    </li>

                    @if (Auth::user()->email === 'admin@admin.com')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('fakturas.index') }}">Fakture</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('paket-korisnikas.index') }}">Paketi Korisnika</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tip-paketas.index') }}">Tipovi Paketa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">Korisnici</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('paket-korisnikas.index') }}">Moji Paketi</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Prijava') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Registracija') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>