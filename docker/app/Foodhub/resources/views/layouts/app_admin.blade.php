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

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/b49a5bc963.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
  <?php
    use App\Models\AdminNotification;
  ?>
    <div id="app">
    </div>
      <header>
        <nav class="navbar navbar-expand navbar-light bg-white shadow-sm">
          <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
              <img src="/storage/logo.jpg" width="300" height="50" >
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
                @if (Route::has('admin.login'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                  </li>
                @endif

              @else
                  <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle h3" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      {{ __('Admin') }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('admin.home') }}">
                        {{ __('Stores') }}
                      </a>

                      <a class="dropdown-item" href="{{ route('admin.logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                      </form>
                    </div>
                  </li>
              @endguest
              </ul>
            </div>
          @auth
            <div class="notifications row my-2">
              <?php
                $bell_count = AdminNotification::where('checked', 0)->count();
              ?>

              @unless ($bell_count == 0)
              <div class="bell">
                <label class="unchecked_store text-white text-center">
                  {{$bell_count}}
                </label>
                <a href="/admin/notification/index">
                  <i class="far fa-bell fa-3x" style="color: #747a80;"></i>
                </a>
              </div>
              @else
              <div class="bell col-2 offset-3">
                <a href="/admin/notification/index">
                  <i class="far fa-bell fa-3x" style="color: #747a80;"></i>
                </a>
              </div>
              @endif
            </div>
          @endauth
          </div>
        </nav>
      </header>


        <main class="py-4">
            @yield('content')
        </main>
</body>
</html>
