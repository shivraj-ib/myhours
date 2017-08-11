<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>My Hours</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{ asset('/js/custom.js') }}"></script>
        <script src="{{ asset('/js/notify.js') }}"></script>        
        @yield('addition-assets');        
    </head>   
    <body>
        <div class="container-fluid">
            <h1>My Hours</h1>
            <p>Time Management Application</p>
            <div class="row">
                @section('sidebar')
                <div class="col-sm-3" style="background-color:lavender;">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation"><a>Welcome User</a></li>
                        <li role="presentation" class="@if (Route::currentRouteName() == 'home') active @endif">
                            <a href="{{route('home')}}">Home</a>
                        </li>
                        <li role="presentation" class="@if (Route::currentRouteName() == 'profile') active @endif">
                            <a href="{{route('profile')}}">Profile</a>
                        </li>
                        <li role="presentation" class="@if (Route::currentRouteName() == 'hours') active @endif">
                            <a href="{{route('hours')}}">Hours</a>
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
                        <li role="presentation" class="@if (Route::currentRouteName() == 'home') active @endif">
                            <a href="{{route('home')}}">Logout</a>
                        </li>
                    </ul>
                </div>
                @show
                <div class="col-sm-9" style="background-color:lavenderblush;">
                    <div class="main-container">
                        @yield('content')                        
                    </div>    
                </div>
            </div>
        </div>
    </body>
</html>