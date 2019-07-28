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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="{{ url('css/main.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/multilevelnav.css') }}">
    <style type="text/css">

    </style>
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
                    <img class="pull-left" src="{{asset('images/logo.png')}}" style="height: 50px;">
                    <a class="navbar-brand " href="{{ url('/') }}"><p style="color:black;"><strong> &nbsp {{ $settings_master['CompanyName'] or '' }}</strong></p>
                    </a>
                    <?php
                       // dd(Auth::user()->company_id);
                    ?>
                    <!-- Branding Image -->
                    <!-- <a class="navbar-brand" href="#">User </a> -->
                    @if(!Auth::guest())

                        @if(Auth::user()->role == RoleType::$CUSTOMER)
                             <ul class="nav navbar-nav" style="padding-top: 10px">
                                <li><a href="{{route('viewAllTrip')}}">View All Trips</a></li>
                            </ul>  
                        @else
                          <ul class="nav navbar-nav" style="padding-top: 10px">
                            <!-- <li><a href="{{ route('setting') }}" ><i class="fa fa-cog" aria-hidden="true"></i>Settings  </a></li> -->
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-cog" aria-hidden="true"></i> Settings  <b class="caret"></b></a>
                                <ul class="dropdown-menu multi-level">
                                    <!-- <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">One more separated link</a></li> -->
                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users <!-- <span class="caret"></span> --> </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{route('addAdmin')}}">Add Admin</a></li>
                                            <li><a href="{{route('addUser')}}">Add Customer</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="{{route('viewAllUser')}}">View All User</a></li>
                                            <!--<li class="dropdown-submenu">
                                                  <a href="#" class="dropdown-toggledata-toggle="dropdown">Dropdown</a>
                                                  <ul class="dropdown-menu">
                                                      <li class="dropdown-submenu">
                                                          <a href="#" class="dropdown-toggledata-toggle="dropdown">Dropdown</a>
                                                          <ul class="dropdown-menu">
                                                              <li><a href="#">Action</a></li>
                                                              <li><a href="#">Another action</a></li>
                                                              <li><a href="#">Something else herea></li>
                                                              <li class="divider"></li>
                                                              <li><a href="#">Separated link</a></li>
                                                              <li class="divider"></li>
                                                              <li><a href="#">One more separatelink</a></li>
                                                          </ul>
                                                      </li>
                                                  </ul>
                                            </li> -->
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ship"></i> Ferry </a>
                                        <ul class="dropdown-menu">
                                             <li><a href="{{route('addFerry')}}">Add Ferry</a></li>
                                             <li role="separator" class="divider"></li>
                                             <li><a href="{{route('viewAllFerry')}}">View All Ferry</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users" aria-hidden="true"></i> Passenger Type </a>
                                        <ul class="dropdown-menu">
                                             <li><a href="{{route('addPassengerType')}}">Add Type</a></li>
                                             <li role="separator" class="divider"></li>
                                            <li><a href="{{route('viewAllPassengerType')}}">View All Types</a></li>
                                        </ul>
                                    </li>
                                   <!--  <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-anchor" aria-hidden="true"></i> Port </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{route('addPort')}}">Add Port</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="{{route('viewAllPort')}}">View All Ports</a></li>
                                        </ul>
                                    </li> -->
                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-anchor" aria-hidden="true"></i> Trip </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{route('addTripForm')}}">Add Trip</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="{{route('viewAllTrip')}}">View All Trips</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-road" aria-hidden="true"></i> Route </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{route('addTripForm')}}">Add Trip</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="{{route('viewAllTrip')}}">View All Trips</a></li>
                                        </ul>
                                    </li>
                       

                                </ul>
                            </li>   
                        </ul> 
                        @endif
                      <!--<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('addAdmin')}}">Add Admin</a></li>
                                <li><a href="{{route('addUser')}}">Add Customer</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{route('viewAllUser')}}">View All User</a></li>
                            </ul>
                        </li>-->
                    
                    @endif
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if(Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>          
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
        @yield('content')
    </div>

    <!-- Scripts -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>
    @yield('additionalJS')

</body>
</html>