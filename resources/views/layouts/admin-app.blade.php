<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'SOIS-AR' }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icons -->
    <link href="{{ asset('fontawesome-free-5.15.4/css/all.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

    @stack('scripts')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm bg-maroon">
            <div class="container" >
                {{-- Brand --}}
                <a class="navbar-brand text-light" href="{{ url('/home') }}">
                    {{ 'SOIS | Accomplishment Report' }}
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
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- Notifications --}}
                            <li class="nav-item dropdown">                             
                                <a id="navbarDropdown" class="nav-link dropdown-toggle align-middle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="far fa-bell fa-lg"></i>
                                    <span class="badge badge-pill badge-primary align-top"><small>{{$notificationCount ?? 0}}</small></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right text-light" aria-labelledby="navbarDropdown">
                                    @if($notifications->count() > 0)
                                    @foreach($notifications as $notification)
                                    <read-notification 
                                    v-bind:notification_id= "{{$notification->notification_id}}" 
                                    :read= "{{ ($notification->read_at == NULL) ? 'false' : 'true' }}"
                                    title= "{{ $notification->title }}"
                                    description= "{{ $notification->description }}"
                                    link= " 
                                        @if($notification->type == 3)
                                            {{-- Student Accomplishments --}}
                                            {{route('studentAccomplishment.show', ['accomplishmentUUID' => $notification->link])}}
                                        @elseif($notification->type == 4)
                                            {{-- Accomplishment Reports --}}
                                            {{route('accomplishmentReport.show', ['accomplishmentReportUUID' => $notification->link])}}
                                        @endif
                                     "
                                    >
                                    </read-notification>
                                    @php
                                        if($loop->index == 4):
                                            break;
                                        endif;
                                    @endphp
                                    @endforeach
                                    
                                    @else
                                    <p class="dropdown-item">No Notifications found!</p>
                                    @endif
                                    <div class="row">
                                        <div class="col text-center">
                                            <a class="dropdown-item" href="{{route('notifications.show')}}">See All Notifications</a>  
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{-- Profile -> Logout --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>       
    </div>

    {{-- Javascript Imports --}}
    @if($loadJSWithoutDefer ?? false)
        <script src="{{ asset('js/app.js') }}"></script>
    @else
        <script src="{{ asset('js/app.js') }}" defer></script>
    @endif

    <script src="{{ asset('fontawesome-free-5.15.4/js/all.min.js') }}" defer></script>

    @stack('footer-scripts')
    @yield('scripts')
    
</body>
</html>