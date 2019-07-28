<?php 
    use App\Enumeration\RoleType;
?>

<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ferry Ticketing System') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    @yield('additionalCSS')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
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
                        <img class="nav-logo" alt="Brand" src="{{ asset('images/logo.png') }}" height="25px"> 
                    </a>
                </div>

                
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if(Auth::check() && Auth::user()->role == RoleType::$ADMIN)
                            <li><a href="{{route('view_all_company')}}"><i class="fa fa-building" aria-hidden="true"></i> Company</a></li>

                            <li><a href="{{route('view_all_user')}}"><i class="fa fa-users" aria-hidden="true"></i> Users</a></li>

                            <li><a href="{{route('view_all_port')}}"><i class="fa fa-anchor" aria-hidden="true"></i> Port</a></li>

                            <li><a href="{{route('view_all_passenger_type')}}"><i class="fa fa-street-view" aria-hidden="true"></i> Passenger Type</a></li>

                            <li><a href="{{route('view_all_ferry')}}"><i class="fa fa-ship" aria-hidden="true"></i> Ferry</a></li>

                            <li><a href="{{route('view_all_trip')}}"><i class="fa fa-plane" aria-hidden="true"></i> Trip</a></li>
                            <li><a href="{{route('all_order')}}"><i class="fa fa-first-order" aria-hidden="true"></i> Order</a></li>

                            <li><a href="{{route('all_ticket')}}"><i class="fa fa-ticket" aria-hidden="true"></i> Ticket</a></li>
                        @endif

                        @if(Auth::check() && Auth::user()->role == RoleType::$COMPANY_USER)
                            <li><a href="{{route('view_all_user')}}"><i class="fa fa-users" aria-hidden="true"></i> Users</a></li>

                            <li><a href="{{route('view_all_ferry')}}"><i class="fa fa-ship" aria-hidden="true"></i> Ferry</a></li>

                            <li><a href="{{route('view_all_trip')}}"><i class="fa fa-plane" aria-hidden="true"></i> Trip</a></li>
                                <li><a href="{{route('all_order')}}"><i class="fa fa-first-order" aria-hidden="true"></i> Order</a></li>
                            <li><a href="{{route('all_ticket')}}"><i class="fa fa-ticket" aria-hidden="true"></i> Ticket</a></li>

                            <li><a href="{{route('edit_company', ['company' => Auth::user()->company_id])}}"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a></li>
                        @endif

                        @if(Auth::check() && Auth::user()->role == RoleType::$COMPANY_STAFF)
                            <li><a href="{{route('view_all_trip')}}"><i class="fa fa-plane" aria-hidden="true"></i> Trip</a></li>
                        @endif
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
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>


                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Edit Profile</a></li>
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

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>
    @yield('additionalJS')

</body>
</html>
