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
            <div class="sidebar" data-color="black" data-active-color="primary">
                <div class="logo">
                    <a href="#" class="simple-text logo-normal text-center">
                        Purchase Requisition
                    </a>
                </div>
                <div class="sidebar-wrapper">
                    <ul class="nav">
                        <li class="{{ Route::currentRouteNamed('sa-dashboard') ? 'active' : '' }}">
                            <a href="{{route('sa-dashboard')}}">
                                <i class="fas fa-chalkboard"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('sa-pending') ? 'active' : '' }}">
                            <a href="{{route('sa-pending')}}">
                                <i class="fas fa-mug-hot"></i>
                                <p>Pending Accounts</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('sa-admins') ? 'active' : '' }}">
                            <a href="{{route('sa-admins')}}">
                                <i class="fas fa-user-tie"></i>
                                <p>Admins</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('sa-users') ? 'active' : '' }}">
                            <a href="{{route('sa-users')}}">
                                <i class="fas fa-user"></i>
                                <p>Users</p>
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
                            <a class="navbar-brand" href="#">{{Auth::user()->name}}</a>
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
