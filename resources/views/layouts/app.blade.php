<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>        
        <link rel="stylesheet" href="{{ asset('/css/style.css') }}">        
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
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
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                            @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
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
            <div class="container-fluid">
               @if($errors->any())
                <div class="alert alert-danger">              
                    <h4>{{$errors->first()}}</h4>            
                </div>
                @endif
                <div class="row">
                    @if(Auth::check())
                    @section('sidebar')
                    <div class="col-sm-3" style="background-color:lavender;">
                        <ul class="nav nav-pills nav-stacked">                            
                            <li role="presentation" class="@if (Route::currentRouteName() == 'home') active @endif">
                                <a href="{{route('home')}}">Home</a>
                            </li>
                            <li role="presentation" class="@if (Route::currentRouteName() == 'profile') active @endif">
                                <a href="{{route('profile',Auth::user()->id)}}">Profile</a>
                            </li>
                            <li role="presentation" class="@if (Route::currentRouteName() == 'hours') active @endif">
                                <a href="{{route('hours',Auth::user()->id)}}">My Hours</a>
                            </li>                            
                            <li role="presentation" class="@if (Route::currentRouteName() == 'teams') active @endif">
                                <a href="{{route('teams')}}">Manage Teams</a>
                            </li>
                            <li role="presentation" class="@if (Route::currentRouteName() == 'users') active @endif">
                                <a href="{{route('users')}}">Manage Users</a>
                            </li>
                            <li role="presentation" class="@if (Route::currentRouteName() == 'roles') active @endif">
                                <a href="{{route('roles')}}">Manage User Roles</a>
                            </li>
                            <li role="presentation" class="@if (Route::currentRouteName() == 'permissions') active @endif">
                                <a href="{{route('permissions')}}">Manage Permissions</a>
                            </li>                            
                        </ul>
                    </div>
                    @show
                    @endif
                    <div class="col-sm-9" style="background-color:lavenderblush;">
                        <div class="main-container">
                            @yield('content')                      
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>        
        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
        <script src="http://malsup.github.io/jquery.form.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="{{ asset('/js/custom.js') }}"></script>
        <script src="{{ asset('/js/notify.js') }}"></script>
    </body>
</html>
