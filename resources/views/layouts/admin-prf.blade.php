<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
</head>
<body>
    <div id="app">
        <div class="wrapper ">
            <div class="sidebar" data-color="black" data-active-color="danger">
                <div class="logo">
                    <span class="simple-text logo-normal text-center">
                        Purchase Requisition
                    </span>
                    <div class="text-center">   
                        <span class="rounded-circle">
                            <img src="{{asset('images/'.Auth::user()->user_avatar)}}" alt="" class="rounded-circle w-25">
                        </span><BR>
                        <a class="navbar-brand" href="{{route('admin.profile', ['id' => Auth::user()->id, 'name' => Auth::user()->name])}}">{{Auth::user()->name}}</a>
                    </div>
                </div>
                <div class="sidebar-wrapper">
                    <ul class="nav">
                        <li class="{{ Route::currentRouteNamed('admin-dashboard') ? 'active' : '' }}">
                            <a href="{{route('admin-dashboard')}}">
                                <i class="fas fa-chalkboard"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('admin-pending') ? 'active' : '' }}">
                            <a href="{{route('admin-pending')}}">
                                <i class="fas fa-business-time"></i>
                                <p>Pending Request</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('admin-approved') ? 'active' : '' }}">
                            <a href="{{route('admin-approved')}}">
                                <i class="fas fa-thumbs-up"></i>
                                <p>Approved</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('admin-removed') ? 'active' : '' }}">
                            <a href="{{route('admin-removed')}}">
                                <i class="fas fa-thumbs-down"></i>
                                <p>Rejected</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('admin-check') ? 'active' : '' }}">
                            <a href="{{route('admin-check')}}">
                                <i class="fas fa-money-check"></i>
                                <p>Check</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('admin-inbox') ? 'active' : '' }}">
                            <a href="{{route('admin-inbox')}}" id="admin-inbox">
                                <i class="fas fa-inbox"></i>
                                <?php $countMsg =  App\PRForms::where('msg_status_admin', 0)->count();?>
                                <p>Inbox
                                    @if($countMsg != 0)
                                    <span class="numberCircle"><span>{{$countMsg}}</span></span>
                                    @endif
                                </p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('admin-users') ? 'active' : '' }}">
                            <a href="{{route('admin-users')}}">
                                <i class="fas fa-user"></i>
                                <?php $countUser =  App\User::where('user_type', null)->count();?>
                                <p>Accounts
                                    @if($countUser != 0)
                                    <span class="numberCircle"><span style="color: white;">{{$countUser}}</span></span>
                                    @endif
                                </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-panel">
                <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
                    <div class="container-fluid">
                        <div class="navbar-wrapper">
                            <div class="navbar-toggle">
                                <button type="button" class="navbar-toggler">
                                    <span class="navbar-toggler-bar bar1"></span>
                                    <span class="navbar-toggler-bar bar2"></span>
                                    <span class="navbar-toggler-bar bar3"></span>
                                </button>
                            </div>
                        </div>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navigation">
                            @yield('search')
                            <ul class="navbar-nav">
                                <li class="nav-item btn-rotate dropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="content">
                    @yield('content') 
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" type="text/javascript"></script>
    @yield('scripts')
</body>
</html>
