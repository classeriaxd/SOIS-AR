<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"> 

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'SOIS-AR' }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="{{ asset('fontawesome-free-5.15.4/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">

    @stack('scripts')
</head>
<body id="body-pd">
    <div id="app">
        @guest
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
        @else
            @position_title('Officer')
                <div class="wrapper">
                    <div class="body-overlay"></div>
                    <!-- Sidebar  -->
                    <nav class="sidebar active" id="sidebar">
                        <div class="sidebar-header">
                            <h3><img src="/images/pupt_logo.png" class="img-fluid"/><span>SOIS-AR</span></h3>
                        </div>
                        <ul class="list-unstyled components">
                            <!-- Hidden Menu -->
                            <div class="small-screen navbar-display">
                                <li class="dropdown dropdown-menu-end d-lg-none d-md-block d-xl-none d-sm-block">
                                    <a href="#homeSubmenu0" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                                    <i class="material-icons">notifications</i><span>Notifications {{$notificationCount ?? 0}}</span></a>
                                    <ul class="dropdown-menu">
                                        <li>
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
                                        </li>
                                    </ul>
                                </li>
                            </div>
                            <!-- End Hidden Menu -->
                            <li>
                                <a href="{{route('home')}}" class="dashboard">
                                    <i class="material-icons">dashboard</i><span>Dashboard</span>
                                </a>
                            </li>

                            <li class="dropdown">
                                <a href="#pageSubmenu1" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                    <i class="material-icons">summarize</i><span>Event Reports</span>
                                </a>
                                <ul class="collapse list-unstyled menu" id="pageSubmenu1">
                                    <li><a href="{{route('event.create')}}">Create Report</a></li>
                                    <li><a href="{{route('event.index')}}">View Report</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{route('accomplishmentreports.create')}}">
                                    <i class="material-icons">event_note</i><span>Year Summary</span>
                                </a>
                            </li>

                            <li class="dropdown">
                                <a href="#pageSubmenu2" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                    <i class="material-icons">pending_actions</i><span>Accomplishment Report</span>
                                </a>
                                <ul class="collapse list-unstyled menu" id="pageSubmenu2">
                                    <li><a href="{{route('accomplishmentreports.index')}}">Submissions</a></li>
                                </ul>
                            </li>
                            
                            <li class="dropdown">
                                <a href="#pageSubmenu3" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                    <i class="material-icons">picture_as_pdf</i><span>Documents</span>
                                </a>
                                <ul class="collapse list-unstyled menu" id="pageSubmenu3">
                                    <li><a href="#">Upload Document</a></li>
                                    <li><a href="#">View Document</a></li>
                                </ul>
                            </li>
                            
                            <li class="dropdown">
                                <a href="#pageSubmenu4" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                    <i class="material-icons">people</i><span>Students/Members</span>
                                </a>

                                <ul class="collapse list-unstyled menu" id="pageSubmenu4">
                                    <li><a href="/s/accomplishments">Submissions</a></li>
                                </ul>
                            </li>
                            
                            <!-- Hidden Menu -->
                            <div class="small-screen navbar-display">
                                <li  class="dropdown d-lg-none d-md-block d-xl-none d-sm-block">
                                    <a href="#pageSubmenu5" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                        <i class="material-icons">settings</i><span>Settings</span>
                                    </a>
                                    <ul class="collapse list-unstyled menu" id="pageSubmenu5">
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </div>
 
                        </ul> 
                    </nav>

                    <div id="content" class="active">
                        <!-- Top Navbar -->
                        <div class="top-navbar">
                            <nav class="navbar navbar-expand-lg">
                                <div class="container-fluid">
                                    
                                    <!-- Sidebar Button -->
                                    <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                                        <span class="material-icons">view_headlines</span>
                                    </button>
                                    
                                    <a class="navbar-brand" href="{{route('home')}}"> Welcome {{ Auth::user()->first_name }}! </a>
                                    

                                    <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-bs-toggle="collapse"
                                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="material-icons">more_vert</span>
                                    </button>

                                    <!-- Notification -->
                                    <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none justify-content-end" id="navbarSupportedContent">
                                        <ul class="nav navbar-nav ml-auto">   
                                            <li class="dropdown nav-item active">
                                                <a href="#" class="nav-link active" data-bs-toggle="dropdown">
                                                    <span class="material-icons">notifications</span>
                                                    <span class="notification">{{$notificationCount ?? 0}}</span>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
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
                                                    </li>
                                                </ul>
                                            </li>
                                        
                                            <!-- Profile Logout -->
                                            <li class="dropdown nav-item active">
                                                <a id="navbarDropdown" class="nav-link text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    <span class="material-icons">settings</span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                         <span class="material-icons">logout </span>{{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>

                        <!-- Main Content -->
                        <div class="main-content">			
                            <main class="py-4">
                                @yield('content')
                            </main> 
                        </div>

                        <!-- Footer -->
                        <footer class="footer">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <nav class="d-flex">
                                            <ul class="m-0 p-0">
                                                <li>
                                                    <a href="{{route('home')}}">Home </a>
                                                </li>
                                                <li>
                                                    <a href="#">About Us</a>
                                                </li>
                                                <li>
                                                    <a href="#"> How to</a>
                                                </li>
                                                <li>
                                                    <a href="#"> Help</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="copyright d-flex justify-content-end">
                                            <a href="#">&copy 2021 SOIS - Accomplishment Report Module</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </footer>

                    </div>
                </div>

            @elseposition_title('Member')
                <div class="wrapper">
                    <div class="body-overlay"></div>
                    <!-- Sidebar  -->
                    <nav class="sidebar" id="sidebar">
                        <div class="sidebar-header">
                            <h3><img src="/images/pupt_logo.png" class="img-fluid"/><span>SOIS-AR</span></h3>
                        </div>
                        <ul class="list-unstyled components">
                            <!-- Hidden Menu -->
                            <div class="small-screen navbar-display">
                                <li class="dropdown dropdown-menu-end d-lg-none d-md-block d-xl-none d-sm-block">
                                    <a href="#homeSubmenu0" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                                    <i class="material-icons">notifications</i><span>Notifications {{$notificationCount ?? 0}}</span></a>
                                    <ul class="dropdown-menu">
                                        <li>
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
                                        </li>
                                    </ul>
                                </li>
                            </div>
                            <!-- End Hidden Menu -->
                            <li>
                                <a href="{{route('home')}}" class="dashboard">
                                    <i class="material-icons">dashboard</i><span>Dashboard</span>
                                </a>
                            </li>

                            <li class="dropdown">
                                <a href="#pageSubmenu1" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                    <i class="material-icons">stars</i><span>My Accomplishments</span>
                                </a>
                                <ul class="collapse list-unstyled menu" id="pageSubmenu1">
                                    <li><a href="{{route('studentAccomplishment.create')}}">Submit</a></li>
                                    <li><a href="{{route('studentAccomplishment.index')}}">View List</a></li>
                                </ul>
                            </li>
                            
                            <!-- Hidden Menu -->
                            <div class="small-screen navbar-display">
                                <li  class="dropdown d-lg-none d-md-block d-xl-none d-sm-block">
                                    <a href="#pageSubmenu5" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                        <i class="material-icons">settings</i><span>Settings</span>
                                    </a>
                                    <ul class="collapse list-unstyled menu" id="pageSubmenu5">
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </div>
 
                        </ul> 
                    </nav>

                    <div id="content">
                        <!-- Top Navbar -->
                        <div class="top-navbar">
                            <nav class="navbar navbar-expand-lg">
                                <div class="container-fluid">
                                    
                                    <!-- Sidebar Button -->
                                    <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                                        <span class="material-icons">view_headlines</span>
                                    </button>
                                    
                                    <a class="navbar-brand" href="{{route('home')}}"> Welcome {{ Auth::user()->first_name }}! </a>
                                    

                                    <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-bs-toggle="collapse"
                                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="material-icons">more_vert</span>
                                    </button>

                                    <!-- Notification -->
                                    <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none justify-content-end" id="navbarSupportedContent">
                                        <ul class="nav navbar-nav ml-auto">   
                                            <li class="dropdown nav-item active">
                                                <a href="#" class="nav-link active" data-bs-toggle="dropdown">
                                                    <span class="material-icons">notifications</span>
                                                    <span class="notification">{{$notificationCount ?? 0}}</span>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
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
                                                    </li>
                                                </ul>
                                            </li>
                                        
                                            <!-- Profile Logout -->
                                            <li class="dropdown nav-item active">
                                                <a id="navbarDropdown" class="nav-link text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    <span class="material-icons">settings</span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                         <span class="material-icons">logout </span>{{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>

                        <!-- Main Content -->
                        <div class="main-content">			
                            <main class="py-4">
                                @yield('content')
                            </main> 
                        </div>

                        <!-- Footer -->
                        <footer class="footer">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <nav class="d-flex">
                                            <ul class="m-0 p-0">
                                                <li>
                                                    <a href="{{route('home')}}">Home </a>
                                                </li>
                                                <li>
                                                    <a href="#">About Us</a>
                                                </li>
                                                <li>
                                                    <a href="#"> How to</a>
                                                </li>
                                                <li>
                                                    <a href="#"> Help</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    
                                    </div>
                                    <div class="col-md-6">
                                        <p class="copyright d-flex justify-content-end">
                                            <a href="#">&copy 2021 SOIS - Accomplishment Report Module</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </footer>

                    </div>
                </div>

            @elseposition_title('President')
                <div class="wrapper">
                    <div class="body-overlay"></div>
                    <!-- Sidebar  -->
                    <nav class="sidebar active" id="sidebar">
                        <div class="sidebar-header">
                            <h3><img src="/images/pupt_logo.png" class="img-fluid"/><span>SOIS-AR</span></h3>
                        </div>
                        <ul class="list-unstyled components">
                            <!-- Hidden Menu -->
                            <div class="small-screen navbar-display">
                                <li class="dropdown dropdown-menu-end d-lg-none d-md-block d-xl-none d-sm-block">
                                    <a href="#homeSubmenu0" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                                    <i class="material-icons">notifications</i><span>Notifications {{$notificationCount ?? 0}}</span></a>
                                    <ul class="dropdown-menu">
                                        <li>
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
                                        </li>
                                    </ul>
                                </li>
                            </div>
                            <!-- End Hidden Menu -->
                            <li>
                                <a href="{{route('home')}}" class="dashboard">
                                    <i class="material-icons">dashboard</i><span>Dashboard</span>
                                </a>
                            </li>

                            <li class="dropdown">
                                <a href="#pageSubmenu2" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                    <i class="material-icons">pending_actions</i><span>Accomplishment Report</span>
                                </a>
                                <ul class="collapse list-unstyled menu" id="pageSubmenu2">
                                    <li><a href="{{route('accomplishmentreports.index')}}">Submissions</a></li>
                                </ul>
                            </li>
                            
                            <!-- Hidden Menu -->
                            <div class="small-screen navbar-display">
                                <li  class="dropdown d-lg-none d-md-block d-xl-none d-sm-block">
                                    <a href="#pageSubmenu5" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                        <i class="material-icons">settings</i><span>Settings</span>
                                    </a>
                                    <ul class="collapse list-unstyled menu" id="pageSubmenu5">
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </div>

                        </ul> 
                    </nav>

                    <div id="content" class="active">
                        <!-- Top Navbar -->
                        <div class="top-navbar">
                            <nav class="navbar navbar-expand-lg">
                                <div class="container-fluid">
                                    
                                    <!-- Sidebar Button -->
                                    <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                                        <span class="material-icons">view_headlines</span>
                                    </button>
                                    
                                    <a class="navbar-brand" href="{{route('home')}}"> Welcome {{ Auth::user()->first_name }}! </a>
                                    

                                    <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-bs-toggle="collapse"
                                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="material-icons">more_vert</span>
                                    </button>

                                    <!-- Notification -->
                                    <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none justify-content-end" id="navbarSupportedContent">
                                        <ul class="nav navbar-nav ml-auto">   
                                            <li class="dropdown nav-item active">
                                                <a href="#" class="nav-link active" data-bs-toggle="dropdown">
                                                    <span class="material-icons">notifications</span>
                                                    <span class="notification">{{$notificationCount ?? 0}}</span>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
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
                                                    </li>
                                                </ul>
                                            </li>
                                        
                                            <!-- Profile Logout -->
                                            <li class="dropdown nav-item active">
                                                <a id="navbarDropdown" class="nav-link text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    <span class="material-icons">settings</span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                            <span class="material-icons">logout </span>{{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>

                        <!-- Main Content -->
                        <div class="main-content">			
                            <main class="py-4">
                                @yield('content')
                            </main> 
                        </div>

                        <!-- Footer -->
                        <footer class="footer">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <nav class="d-flex">
                                            <ul class="m-0 p-0">
                                                <li>
                                                    <a href="{{route('home')}}">Home </a>
                                                </li>
                                                <li>
                                                    <a href="#">About Us</a>
                                                </li>
                                                <li>
                                                    <a href="#"> How to</a>
                                                </li>
                                                <li>
                                                    <a href="#"> Help</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    
                                    </div>
                                    <div class="col-md-6">
                                        <p class="copyright d-flex justify-content-end">
                                            <a href="#">&copy 2021 SOIS - Accomplishment Report Module</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </footer>

                    </div>
                </div>
            @endposition_title
        @endguest     
    </div>

    {{-- Javascript Imports --}}
    @if($loadJSWithoutDefer ?? false)
        <script src="{{ asset('js/app.js') }}"></script>
    @else
        <script src="{{ asset('js/app.js') }}" defer></script>
    @endif

    <script src="{{ asset('fontawesome-free-5.15.4/js/all.min.js') }}" defer></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>

    @stack('footer-scripts')
    @yield('scripts')
    
</body>
</html>
