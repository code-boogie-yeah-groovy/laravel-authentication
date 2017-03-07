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
    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>
    <div id="app">
      <div id="overlay">
        <nav class="navbar navbar-default navbar-static-top">
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
                        <li><a role="presentation" class="active" href="#">Popular</a></li>
                        <li><a role="presentation" href="#">Trending</a></li>
                        <li><a role="presentation"href="#">New</a></li>
                        <li role="presentation" class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            Categories<span class="caret"></span>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a href="#">Dogs</a></li>
                            <li><a href="#">Cats</a></li>
                            <li><a href="#">Birds</a></li>
                            <li><a href="#">Fishes</a></li>
                            <li><a href="#">Exotic</a></li>
                          </ul>
                        </li>
                        <li><a role="presentation"href="#">Forum</a></li>
                        <li><a role="presentation"href="#">Trading</a></li>
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
                              <form class="navbar-form" role="search">
                                <div class="input-group add-on">
                                  <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
                                  <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                  </div>
                                </div>
                              </form>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->fullname() }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                      <!--Needs routing -->
                                      <a href="#" data-toggle="modal" data-target="#createModal">Add Post</a>
                                      <a href="#">View Profile</a>
                                      <a href="#">Edit Profile</a>
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
