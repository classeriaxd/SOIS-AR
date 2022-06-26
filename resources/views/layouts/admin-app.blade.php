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
                    <h3><a href="{{route('admin.home')}}"><img src="/images/pupt_logo.png" class="img-fluid"/><span>SOIS-AR</span></a></h3>
                </div>
                <ul class="list-unstyled components">
                    <!-- Hidden Menu -->
                    <div class="small-screen navbar-display">
                        <li class="dropdown dropdown-menu-end d-lg-none d-md-block d-xl-none d-sm-block">
                            <a href="#homeSubmenu0" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                                <i class="material-icons">notifications</i><span>Notifications {{$notificationCount ?? 0}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    @if($notifications->count() > 0)
                                        {{-- Loop through all Notifications --}}
                                        @foreach($notifications as $notification)
                                            <admin-read-notification 
                                                v-bind:read= "{{ ($notification->read_at == NULL) ? 'false' : 'true' }}"
                                                title= "{{ $notification->title }}"
                                                description= "{{ $notification->description }}"
                                                route= "{{route('admin.notifications.markAsRead', ['notification_id' => $notification->ar_notification_id])}}"
                                                link= " 
                                                    @if($notification->type == 4)
                                                        {{-- Accomplishment Reports --}}
                                                        {{route('admin.accomplishmentReports.redirectFromNotification', ['accomplishmentReportUUID' => $notification->link])}}
                                                    @endif">
                                            </admin-read-notification>
                                            
                                            {{-- Max of 5 Notifications --}}
                                            @if($loop->index == 4):
                                                @php break; @endphp
                                            @endif;
                                        @endforeach
                                    
                                    @else
                                        <p class="dropdown-item">No Notifications found!</p>
                                    @endif

                                    <div class="row">
                                        <div class="col text-center">
                                            <a class="dropdown-item" href="{{route('admin.notifications.index')}}">See All Notifications</a>  
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </div>
                    <!-- End Hidden Menu -->
                    <li>
                        <a href="{{route('admin.home')}}" class="dashboard">
                            <i class="material-icons">dashboard</i><span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.events.index')}}" class="dashboard">
                            <i class="material-icons">description</i><span>Event Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.accomplishmentReports.index')}}" class="dashboard">
                            <i class="material-icons">task</i><span>Accomplishment Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.organizations.index')}}" class="dashboard">
                            <i class="material-icons">groups</i><span>Organizations</span>
                        </a>
                    </li>

                    <div class="sidebar-category">
                        <h5><span>Maintenance Tools</span></h5>
                    </div>

                    {{-- Event Maintenance --}}
                    <li class="dropdown">
                        <a href="#eventSubMenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="material-icons">build</i><span>Event Maintenance</span>
                        </a>
                        <ul class="collapse list-unstyled menu" id="eventSubMenu">
                            <li><a href="{{ route('admin.maintenance.eventRoles.index') }}">Event Roles</a></li>
                            <li><a href="{{ route('admin.maintenance.eventCategories.index') }}">Event Categories</a></li>
                            <li><a href="{{ route('admin.maintenance.eventClassifications.index') }}">Event Classifications</a></li>
                            <li><a href="{{ route('admin.maintenance.eventNatures.index') }}">Event Natures</a></li>
                            <li><a href="{{ route('admin.maintenance.fundSources.index') }}">Fund Sources</a></li>
                            <li><a href="{{ route('admin.maintenance.levels.index') }}">Levels</a></li>
                            <li><a href="{{ route('admin.maintenance.eventDocumentTypes.index') }}">Event Document Types</a></li>
                        </ul>
                    </li>

                    {{-- Accomplishment Report Maintenance --}}
                    <li class="dropdown">
                        <a href="#accomplishmentReportSubMenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="material-icons">task</i><span>AR Maintenance</span>
                        </a>
                        <ul class="collapse list-unstyled menu" id="accomplishmentReportSubMenu">
                            <li><a href="{{ route('admin.maintenance.tabularTables.index') }}">Tabular AR Tables</a></li>
                            <li><a href="{{ route('admin.maintenance.schoolYears.index') }}">School Years</a></li>
                        </ul>
                    </li>

                    {{-- If User is Super Admin... --}}
                    @role('Super Admin')
                    {{-- User Maintenance --}}
                    <li class="dropdown">
                        <a href="#userMaintenanceSubMenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="material-icons">person</i><span>User Maintenance</span>
                        </a>
                        <ul class="collapse list-unstyled menu" id="userMaintenanceSubMenu">
                            <li><a href="{{ route('admin.maintenance.roles.index') }}">Manage Roles</a></li>
                            <li><a href="{{ route('admin.activityLogs.index') }}">Activity Logs</a></li>
                        </ul>
                    </li>
                    @endrole

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
                            
                            <a class="navbar-brand" href="{{route('admin.home')}}"> Welcome {{ Auth::user()->first_name }}! </a>

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
                                                    {{-- Notification Loop --}}
                                                    @foreach($notifications as $notification)
                                                        <admin-read-notification 
                                                            v-bind:read= "{{ ($notification->read_at == NULL) ? 'false' : 'true' }}"
                                                            title= "{{ $notification->title }}"
                                                            description= "{{ $notification->description }}"
                                                            route= "{{route('admin.notifications.markAsRead', ['notification_id' => $notification->ar_notification_id])}}"
                                                            link= " 
                                                                @if($notification->type == 4)
                                                                    {{-- Accomplishment Reports --}}
                                                                    {{route('admin.accomplishmentReports.redirectFromNotification', ['accomplishmentReportUUID' => $notification->link])}}
                                                                @endif">
                                                        </admin-read-notification>
                                                        
                                                        {{-- Max of 4 Notifications --}}
                                                        @if($loop->index == 4):
                                                            @php break; @endphp
                                                        @endif;
                                                    @endforeach
                                                
                                                @else
                                                    <p class="dropdown-item">No Notifications found!</p>
                                                @endif

                                                <div class="row">
                                                    <div class="col text-center">
                                                        <a class="dropdown-item" href="{{route('admin.notifications.index')}}">See All Notifications</a>  
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
                                            <a href="{{route('admin.home')}}">Home </a>
                                        </li>
                                        <li>
                                            <a href="#">About Us</a>
                                        </li>
                                        <li>
                                            <a href="#"> How to</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-md-6">
                                <p class="copyright d-flex justify-content-end">
                                    <a href="#">&copy {{date('Y')}} SOIS - Accomplishment Report Module</a>
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
