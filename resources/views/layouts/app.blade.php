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
    <script src="{{ asset('js/sidebar.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	
	<!-- Icons -->
    <link href="{{ asset('fontawesome-free-5.15.4/css/all.min.css') }}" rel="stylesheet">
	
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    @stack('scripts')
</head>
<body>
    <div id="app">
                        @guest
                        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
                            <div class="container-fluid">
                                <a class="navbar-brand" href="{{ url('/') }}">
                                    {{ config('app.name', 'Laravel') }}
                                </a>
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <!-- Left Side Of Navbar -->
                                    <ul class="navbar-nav mr-auto">

                                    </ul>

                                    <!-- Right Side Of Navbar -->
                                    <ul class="navbar-nav ml-auto">
                                        <!-- Authentication Links -->
                                        @if (Route::has('login'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>
                                        @endif
                                        
                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif
                                    </ul>
                            </div>
                        </nav>
                        <main class="py-4">
                             @yield('content')
                        </main>
                        @else   
                              
                        <div class="d-flex" id="wrapper">

                        <!-- Sidebar -->
                        <div class="sidebar" id="sidebar-wrapper">
                        <div class="sidebar-heading">
                            <a class="navbar-brand" href="{{ url('/') }}"> {{ config('app.name', 'Laravel') }} </a>
                        </div>
                        @position_title('Officer')  
                        <div class="list-group list-group-flush">
                            <a href="/home" class="list-group-item list-group-item-action">
                                <i class="fas fa-home"></i>
                                {{ __('Home') }}
                            </a>
                            <a href="/e/create" class="list-group-item list-group-item-action">
                                <i class="fas fa-folder-plus"></i>
                                {{ __('Create Event Report') }}
                            </a>
                            <a href="/e" class="list-group-item list-group-item-action">
                                <i class="fas fa-folder-open"></i>
                                {{ __('View Event Reports') }}
                            </a>
                            <a href="/e/reports" class="list-group-item list-group-item-action">
                                <i class="fas fa-clipboard-list"></i>
                                {{ __('Year Summary') }}
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-file-upload"></i>
                                {{ __('Upload Document') }}
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-file-alt"></i>
                                {{ __('View Documents') }}
                            </a>
                            <a href="/s/accomplishments" class="list-group-item list-group-item-action">
                                <i class="fas fa-file-import"></i>
                                {{ __('Submitted Accomplishments') }}
                                <span class="badge badge-pill badge-light">{{$submissionCount ?? "0"}}    
                            </a>
                        </div>
                        </div>
                        @elseposition_title('Member')
                        <div class="list-group list-group-flush">
                            <a href="/home" class="list-group-item list-group-item-action">
                                <i class="fas fa-home"></i>
                                {{ __('Home') }}
                            </a>
                            <a href="/e/create" class="list-group-item list-group-item-action">
                                <i class="fas fa-folder-plus"></i>
                                {{ __('Create Event Report') }}
                            </a>
                            <a href="/e" class="list-group-item list-group-item-action">
                                <i class="fas fa-folder-open"></i>
                                {{ __('View Event Reports') }}
                            </a>
                            <a href="/e/reports" class="list-group-item list-group-item-action">
                                <i class="fas fa-clipboard-list"></i>
                                {{ __('Year Summary') }}
                            </a>
                        </div>
                        </div>
                        @endposition_title
                        <!-- /#sidebar-wrapper -->

                        <!-- Page Content -->
                        <div id="page-content-wrapper">

                        <nav class="navbar navbar-expand-lg " id="navbar-officer">
                            <button class="btn" id="menu-toggle"><span class="navbar-toggler-icon"></span></button>

                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                            </button>
                            
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                               
                            <!--
                                <form class="d-flex ms-auto my-3 my-lg-0">
                                    <div class="input-group mb-1">
                                        <input
                                            class="form-control" 
                                            type="search"
                                            placeholder="Search"
                                            aria-label="Search"
                                            aria-describedby="Search"
                                        >
                                        <div class="input-group-append">
                                            <button class="btn btn-danger" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            -->
                                
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-user"></i>
                                        {{ Auth::user()->first_name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-id-badge"></i>
                                            {{ __('Profile') }}
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-lock"></i>
                                            {{ __('Password') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                            <i class="fas fa-door-open"></i>
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                            </div>
                        </nav>

                        <div class="container-fluid">
                        <main class="py-4">
                            @yield('content')
                        </main>
                        </div>
                        <!-- /#page-content-wrapper -->

                        </div>
                        <!-- /#wrapper -->
                            
                        @endguest
                  

        
    </div>
    @stack('footer-scripts')
    @yield('scripts')
    
    
</body>
</html>
