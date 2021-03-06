<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Petbuddies') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/bootstrap-social.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="/js/jquery-3.1.1.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>
    <div id="app">
      <div id="overlay">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container container-fluid">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Pet') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    @if (Auth::guest())
                      <ul class="nav navbar-nav">
                          &nbsp;
                        </ul>
                    @else
                      <!--Needs routing-->
                      <ul class="nav navbar-nav nav-pills" role="navigation">
                        <li><a role="presentation" class="active" href="{{ route('home') }}">Popular</a></li>
                        <li><a role="presentation" href="{{ route('trending') }}">Trending</a></li>
                        <li><a role="presentation"href="{{ route('new') }}">New</a></li>
                        <li role="presentation" class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            Categories<span class="caret"></span>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a href="{{ route('tag', 1) }}">Dogs</a></li>
                            <li><a href="{{ route('tag', 2) }}">Cats</a></li>
                            <li><a href="{{ route('tag', 3) }}">Birds</a></li>
                            <li><a href="{{ route('tag', 4) }}">Fishes</a></li>
                            <li><a href="{{ route('tag', 5) }}">Exotic</a></li>
                            <li><a href="{{ route('tag', 6) }}">Others</a></li>
                          </ul>
                        </li>
                        <li>
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            Forum<span class="caret"></span>
                          </a>
                            <ul class="dropdown-menu">
                              <li><a role="presentation"href="{{ route('tag', 8) }}">Help</a></li>
                              <li><a role="presentation"href="{{ route('tag', 9) }}">Tutorial</a></li>
                            </ul>
                        </li>
                        <li><a role="presentation"href="{{ route('tag', 7) }}">Trading</a></li>
                      </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li>
                              <form action="/search" method="POST" class="navbar-form" role="search">
                                <div class="input-group add-on">
                                  <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
                                  <div class="input-group-btn">
                                    <input type="hidden" value="{{ Session::token() }}" name="_token">
                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                  </div>
                                </div>
                              </form>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                  <img src="{{ Auth::user()->avatar }}" class="avatar img-fluid img-rounded">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                      <a href="#" data-toggle="modal" data-target="#createModal">Add Post</a>
                                      <a href="{{ route('account', ['user_id' => Auth::user()->id]) }}">View Profile</a>
                                      <a href="{{ route('account.edit') }}">Edit Profile</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Modal -->
    <div id="createModal" class="modal fade" role="dialog">
      @include('post')
    </div>

    <!-- Scripts -->

    <script src="{{ URL::to('js/app.js') }}"></script>
</body>
</html>
