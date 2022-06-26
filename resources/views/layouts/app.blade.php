<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"> 

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Meta Tags -->
    <meta name="keywords" content="SOIS-AR, SOIS, SOIS PUP Taguig">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://sois-ar.puptaguigcs.net/">
    <meta property="og:title" content="SOIS|Accomplishment Report">
    <meta property="og:image" content="https://sois-ar.puptaguigcs.net/images/og/og_image.png">
    <meta property="og:description" content="When the university, PUP Taguig, started to operate during the Covid-19 pandemic, face-to-face transactions has been limited inside the university. The School Organizations had been affected by this implemented rule. With this situation, a group of BSIT students developed the Student Organization Information System – Accomplishment Module to help the PUP Taguig Student Organizations transpose their processes to an online platform. This system is an application that will maintain and manage the Accomplishment Reports submitted from each Student Organization.">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="icon" href="{{ url('/images/favicon.ico') }}">
    <link href="{{ asset('fontawesome-free-5.15.4/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">

    @if($loadHomeCSS ?? false)
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    @endif
    
    @stack('scripts')
</head>
<body id="body-pd">
    <div id="app">
        <div class="wrapper">
            <div class="body-overlay"></div>
            <!-- Sidebar  -->
            <nav class="sidebar active" id="sidebar">
                <div class="sidebar-header">
                    <h3><a href="{{route('home')}}"><img src="/images/pupt_logo.png" class="img-fluid"/><span>SOIS-AR</span></a></h3>
                </div>
                <ul class="list-unstyled components">

                    {{-- Hidden Menu on Small Screen --}}
                    <div class="small-screen navbar-display">
                        <li class="dropdown dropdown-menu-end d-lg-none d-md-block d-xl-none d-sm-block">
                            <a href="#homeSubmenu0" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                            <i class="material-icons">notifications</i><span>Notifications {{$notificationCount ?? 0}}</span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    @if($notifications->count() > 0)
                                        @foreach($notifications as $notification)
                                            <read-notification 
                                                :read= "{{ ($notification->read_at == NULL) ? 'false' : 'true' }}"
                                                title= "{{ $notification->title }}"
                                                route="{{route('notification.markAsRead', ['notification_id' => $notification->ar_notification_id])}}"
                                                description= "{{ $notification->description }}"
                                                link= " 
                                                    @if($notification->type == 3)
                                                        {{-- Student Accomplishments --}}
                                                        {{route('studentAccomplishment.show', ['accomplishmentUUID' => $notification->link])}}
                                                    @elseif($notification->type == 4)
                                                        {{-- Accomplishment Reports --}}
                                                        {{route('accomplishmentReport.show', ['accomplishmentReportUUID' => $notification->link])}}
                                                    @else
                                                        {{-- Notifications Index --}}
                                                        {{route('notifications.show')}}
                                                    @endif">
                                            </read-notification>
                                        
                                            @if($loop->index == 4)
                                                @php break; @endphp
                                            @endif
                                        
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

                    <li>
                        <a href="{{route('home')}}" class="dashboard">
                            <i class="material-icons">dashboard</i><span>Dashboard</span>
                        </a>
                    </li>
                    
                    {{-- If User is AR Officer Admin... --}}
                    @role('AR Officer Admin')

                        {{-- Event Reports --}}
                        <li class="dropdown">
                            <a href="#pageSubmenuOfficer1" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="material-icons">summarize</i><span>Event Reports</span>
                            </a>
                            <ul class="collapse list-unstyled menu" id="pageSubmenuOfficer1">
                                <li><a href="{{route('event.create')}}">Create Event</a></li>
                                <li><a href="{{route('event.index')}}">View Events</a></li>
                                <li><a href="{{route('event.gpoa.index')}}">GPOA Events</a></li>
                            </ul>
                        </li>

                        {{-- Accomplishment Reports --}}
                        <li class="dropdown">
                            <a href="#pageSubmenuOfficer2" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="material-icons">pending_actions</i>
                                <span>Accomplishment Reports</span>
                            </a>
                            <ul class="collapse list-unstyled menu" id="pageSubmenuOfficer2">
                                <li><a href="{{route('accomplishmentreports.create')}}">Create AR</a></li>
                                <li><a href="{{route('accomplishmentreports.index')}}">Submissions</a></li>
                            </ul>
                        </li>
                        
                        {{-- Student Accomplishments --}}
                        <li class="dropdown">
                            <a href="#pageSubmenu4" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="material-icons">assignment_ind</i><span>Student Reports</span>
                            </a>

                            <ul class="collapse list-unstyled menu" id="pageSubmenu4">
                                <li><a href="{{route('studentAccomplishment.index')}}">Submissions</a></li>
                            </ul>
                        </li>

                        {{-- Organization Documents --}}
                        <li class="dropdown">
                            <a href="#pageSubmenu5" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="material-icons">picture_as_pdf</i><span>Organization Documents</span>
                            </a>

                            <ul class="collapse list-unstyled menu" id="pageSubmenu5">
                                <li><a href="{{route('organizationDocuments.indexRedirect')}}">All Organization Documents</a></li>
                                <li><a href="{{route('maintenances.organizationDocumentTypes.indexRedirect')}}">Organization Documents Types</a></li>
                            </ul>
                        </li>

                        {{-- Officers --}}
                        <li class="dropdown">
                            <a href="#pageSubmenu6" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="material-icons">person</i><span>Officers</span>
                            </a>

                            <ul class="collapse list-unstyled menu" id="pageSubmenu6">
                                <li><a href="{{route('maintenances.officerSignatures.indexRedirect')}}">Manage Officer Signatures</a></li>
                            </ul>
                        </li>
                    @endrole

                    {{-- If User is a User/Member of Organization --}}
                    @role('User')
                        <li class="dropdown">
                            <a href="#pageSubmenuUser1" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="material-icons">stars</i><span>Accomplishments</span>
                            </a>
                            <ul class="collapse list-unstyled menu" id="pageSubmenuUser1">
                                <li><a href="{{route('studentAccomplishment.index')}}">My Accomplishments</a></li>
                                <li><a href="{{route('studentAccomplishment.create')}}">Submit an Accomplishment</a></li>
                            </ul>
                        </li>
                    @endrole

                    @role('AR President Admin')
                        <li class="dropdown">
                            <a href="#pageSubmenuPresident1" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="material-icons">pending_actions</i><span>Accomplishment Reports</span>
                            </a>
                            <ul class="collapse list-unstyled menu" id="pageSubmenuPresident1">
                                <li><a href="{{route('accomplishmentreports.index')}}">AR Submissions</a></li>
                            </ul>
                        </li>
                    @endrole
                        
                    {{-- Logout Hidden Menu --}}
                    <div class="small-screen navbar-display">
                        <li  class="dropdown d-lg-none d-md-block d-xl-none d-sm-block">
                            <a href="#pageSubmenuLogout1" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <i class="material-icons">settings</i><span>Settings</span>
                            </a>
                            <ul class="collapse list-unstyled menu" id="pageSubmenuLogout1">
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

            {{-- Main Content --}}
            <div id="content" class="active">
                {{-- Top Navbar --}}
                <div class="top-navbar">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            
                            {{-- Sidebar Button --}}
                            <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                                <span class="material-icons">view_headlines</span>
                            </button>
                            
                            <a class="navbar-brand" href="{{route('home')}}"> Welcome {{ Auth::user()->full_name }}! </a>
                            

                            {{-- Notification Bell Icon --}}
                            <button class="d-inline-block d-lg-none ml-auto more-button" 
                                type="button" 
                                data-bs-toggle="collapse"
                                data-bs-target="#navbarNotificationBell" 
                                aria-controls="navbarNotificationBell" 
                                aria-expanded="false" 
                                aria-label="Toggle Notification Bell">
                                <span class="material-icons">more_vert</span>
                            </button>

                            <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none justify-content-end" id="navbarNotificationBell">
                                <ul class="nav navbar-nav ml-auto">   
                                    {{-- Notification Items --}}
                                    <li class="dropdown nav-item active">
                                        <a href="#" class="nav-link active" data-bs-toggle="dropdown">
                                            <span class="material-icons">
                                                notifications
                                            </span>
                                            <span class="notification">
                                                {{$notificationCount ?? 0}}
                                            </span>
                                        </a>
                                        {{-- Notification Items --}}
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                @if($notifications->count() > 0)
                                                    @foreach($notifications as $notification)
                                                        <read-notification 
                                                            :read= "{{ ($notification->read_at == NULL) ? 'false' : 'true' }}"
                                                            title= "{{ $notification->title }}"
                                                            route="{{route('notification.markAsRead', ['notification_id' => $notification->ar_notification_id])}}"
                                                            description= "{{ $notification->description }}"
                                                            link= " 
                                                                @if($notification->type == 3)
                                                                    {{-- Student Accomplishments --}}
                                                                    {{route('studentAccomplishment.show', ['accomplishmentUUID' => $notification->link])}}
                                                                @elseif($notification->type == 4)
                                                                    {{-- Accomplishment Reports --}}
                                                                    {{route('accomplishmentReport.show', ['accomplishmentReportUUID' => $notification->link])}}
                                                                @else
                                                                    {{-- Notifications Index --}}
                                                                    {{route('notifications.show')}}
                                                                @endif">
                                                        </read-notification>
                                                    
                                                        @if($loop->index == 4)
                                                            @php break; @endphp
                                                        @endif
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
                                
                                    {{-- Profile Logout --}}
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
