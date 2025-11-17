<nav class="navbar">
    <div class="nav-left">
        <a href="{{ url('/') }}" title="Kezdőlap"><i class="fa fa-home"></i></a>
        <a href="{{ route('counties.index') }}"><button>{{ __('Megyék') }}</button></a>
        <a href="{{ route('cities.index') }}"><button>{{ __('Városok') }}</button></a>
        <a href="{{ route('zipcodes.index') }}"><button>{{ __('Irányítószámok') }}</button></a>
    </div>

    <div class="nav-right">
        @if(session()->has('api_token'))
            <form class="logout" action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit">Kijelentkezés ({{ session('user_name') }})</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
        @endif
    </div>
</nav>