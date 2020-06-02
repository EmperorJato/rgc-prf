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
                        <a style="color: #ef5757" class="navbar-brand" href="{{route('user.profile', ['id' => Auth::user()->id, 'name' => Auth::user()->name])}}">{{Auth::user()->name}}</a>
                    </div>
                </div>
                <div class="sidebar-wrapper">
                    <ul class="nav">
                        <li class="{{ Route::currentRouteNamed('user-dashboard') ? 'active' : '' }}">
                            <a href="{{route('user-dashboard')}}">
                                <i class="fas fa-chalkboard"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('user-form') ? 'active' : '' }}">
                            <a href="{{route('user-form')}}" id="user-form" data-content="Add Request / Make a PRF" rel="popover" data-placement="bottom">
                                <i class="fas fa-sticky-note"></i>
                                <p>PR Form</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('user-request') ? 'active' : '' }}">
                            <a href="{{route('user-request')}}" id="user-request" data-content="PRF(s) that have not sent yet" rel="popover" data-placement="bottom">
                                <i class="fas fa-list-ul"></i>
                                <p>Request</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('user-requested') ? 'active' : '' }}">
                            <a href="{{route('user-requested')}}" id="user-requested" data-content="Pending PRF(s) for approval" rel="popover" data-placement="bottom">
                                <i class="fas fa-tasks"></i>
                                <p>Requested/Pending PR</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('user-approved') ? 'active' : '' }}">
                            <a href="{{route('user-approved')}}" id="user-approved" data-content="Your approved PRF(s)" rel="popover" data-placement="bottom">
                                <i class="fas fa-thumbs-up"></i>
                                <p>Approved PR</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('user-rejected') ? 'active' : '' }}">
                            <a href="{{route('user-rejected')}}" id="user-rejected" data-content="Your rejected PRF(s)" rel="popover" data-placement="bottom">
                                <i class="fas fa-thumbs-down"></i>
                                <p>Rejected PR</p>
                            </a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('user-inbox') ? 'active' : '' }}">
                            <a href="{{route('user-inbox')}}" id="user-inbox">
                                <i class="fas fa-inbox"></i>
                                <?php $countMsg =  App\PRForms::where('user_id', Auth::user()->id)->where('msg_status', 0)->count();?>
                                <p>Inbox
                                    @if($countMsg != 0)
                                    <span class="numberCircle"><span>{{$countMsg}}</span></span>
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
    <script type="text/javascript">
        $('#user-form').popover({trigger : "hover focus"});
        $('#user-request').popover({trigger : "hover focus"});
        $('#user-requested').popover({trigger : "hover focus"});
        $('#user-approved').popover({trigger : "hover focus"});
        $('#user-rejected').popover({trigger : "hover focus"});
    </script>
    @yield('scripts')
</body>
</html>
