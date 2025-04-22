@php
    $locale = App::getLocale();
    $margin = $locale === 'en' ? true : false;
@endphp
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand ml-5" href="{{ url('/') }}">
            <span class="s">S</span><span class="ak">Ak</span><span class="nni">nNi</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav {{$margin ? 'mr-auto': 'ml-auto'}}">
                <li class="nav-item {{ Route::currentRouteNamed('add.property') ? 'active' : '' }}">
                    <a class="nav-link"  href="{{ route('add.property') }}">{{ __('navbar.add_property') }}</a>
                </li>
                <li class="nav-item {{ Route::currentRouteNamed('show.all.properties') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('show.all.properties') }}">{{ __('navbar.properties') }}</a>
                </li>
                <li class="nav-item {{ Route::currentRouteNamed('index.search') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('index.search') }}">{{ __('navbar.search') }}</a>
                </li>

                <li class="nav-item {{ Route::currentRouteNamed('about') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('about') }}">{{ __('navbar.about') }}</a>
                </li>

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav {{$margin ? 'ml-auto': 'mr-auto'}}">

                <!-- Authentication Links -->
                @guest
                    <li class="nav-item {{ Route::currentRouteNamed('login') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('navbar.login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item {{ Route::currentRouteNamed('register') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('navbar.register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdown" >
                            <a class="dropdown-item font-weight-bold" href="{{ route('user.index') }}">
                                {{ __('navbar.profile') }}
                            </a>

                            <a class="dropdown-item font-weight-bold" href="{{ route('user.favorite') }}">
                                {{ __('navbar.favorite') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('navbar.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest

                @foreach(config('app.locales') as $key => $value)
                    @if(app()->getLocale() !== $key)
                        <li  class="nav-item mr-lg-3 ml-lg-3" >
                            <a class="nav-link" rel="alternate" hreflang="{{ $key }}" href="{{ route('lang.switch', $key) }}">
                               {{ $value }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
