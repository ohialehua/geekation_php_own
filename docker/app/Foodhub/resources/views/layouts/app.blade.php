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
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        {{ __('Mypage') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        {{ __('Users') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        {{ __('Stores') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        {{ __('Items') }}
                                    </a>

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
                    </ul>
                </div>
            </div>
        </nav>

        <main class="mb-auto py-4">
          @if (session('msg_success'))
            <div class="col-8 mx-auto mb-2 text-center px-4 py-3 border rounded bg-success" role="alert">
              <p class="my-auto text-white">{{ session('msg_success') }}</p>
            </div>
          @elseif (session('msg_danger'))
            <div class="col-8 mx-auto mb-2 text-center px-4 py-3 border rounded bg-danger" role="alert">
              <p class="my-auto">{{ session('msg_danger') }}</p>
            </div>
          @elseif (session('msg_info'))
            <div class="col-8 mx-auto mb-2 text-center px-4 py-3 border rounded bg-info" role="alert">
              <p class="my-auto">{{ session('msg_info') }}</p>
            </div>
          @elseif (session('msg_warning'))
            <div class="col-8 mx-auto mb-2 text-center px-4 py-3 border rounded bg-warning" role="alert">
              <p class="my-auto">{{ session('msg_warning') }}</p>
            </div>
          @elseif (session('msg_secondary'))
            <div class="col-8 mx-auto mb-2 text-center px-4 py-3 border rounded bg-secondary" role="alert">
              <p class="my-auto text-white">{{ session('msg_secondary') }}</p>
            </div>
          @endif
            @yield('content')
        </main>
    </div>
    <footer class="py-3">
      <div class="container text-center text-black">
        <p>© Copyright 2022 Foodhub All rights reserved.</p>
      </div>
    </footer>
</body>
</html>
