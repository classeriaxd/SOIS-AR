@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Dashboard</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item active" aria-current="page">
                            Home
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Accomplishment Report President --}}
            @role('AR President Admin')
                <div class="row">
                    {{-- Event Count Card --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="#">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-warning">
                                    <span class="material-icons">article</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Event Reports</strong></p>
                                    <h3 class="card-title">{{ $eventCount ?? 0 }}</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <a href="#">More info
                                            <i class="material-icons more-info">arrow_circle_right</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Student Accomplishment Count Card --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="#">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-success">
                                        <span class="material-icons">assignment_ind</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Student Reports</strong></p>
                                    <h3 class="card-title">{{ $studentAccomplishmentCount ?? 0 }}</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <a href="#">More info
                                            <i class="material-icons more-info">arrow_circle_right</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Accomplishment Report Count Card --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ route('accomplishmentreports.index') }}">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-rose">
                                    <span class="material-icons">inventory_2</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Accomplishment Reports</strong></p>
                                    <h3 class="card-title">{{ $accomplishmentReportCount ?? 0 }}</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <a href="{{ route('accomplishmentreports.index') }}">More info
                                            <i class="material-icons more-info">arrow_circle_right</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    {{-- Document Count Card --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="#">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-info">
                                        <span class="material-icons">source</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Organization Documents</strong></p>
                                    <h3 class="card-title">{{ $documentCount ?? 0 }}</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <a href="#">More info
                                            <i class="material-icons more-info">arrow_circle_right</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Table and Activity Logs --}}
                    <div class="row justify-content-center">
                        {{-- Table --}}
                        <div class="col-lg-7 col-md-12">
                            <div class="card" style="min-height: 485px">
                                <div class="card-header card-header-text">
                                    <h4 class="card-title">
                                        Event Reports
                                    </h4>
                                    <p class="category">Latest added event reports</p>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($latestEvents->isNotEmpty())
                                                @php $i = 1 @endphp
                                                @foreach($latestEvents as $latestEvent)
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$latestEvent->title}}</td>
                                                    <td>
                                                        @if($latestEvent->start_date == $latestEvent->end_date)
                                                            {{date_format(date_create($latestEvent->start_date), 'F d, Y')}}
                                                        @else
                                                            {{date_format(date_create($latestEvent->start_date), 'F d, Y') . ' - ' . date_format(date_create($latestEvent->end_date), 'F d, Y')}}
                                                        @endif
                                                    </td>
                                                    <td>{{$latestEvent->eventRole->event_role}}</td>
                                                </tr>
                                                    @php $i += 1 @endphp
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4">No Event Found!</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Activity Logs --}}
                        @if($showActivityLog)
                        <div class="col-lg-5 col-md-12">
                            <div class="card" style="min-height: 485px">
                                <div class="card-header card-header-text">
                                    <h4 class="card-title">
                                        Activity Log
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <div class="streamline">
                                        @if($activityLogs->isNotEmpty())
                                            @foreach($activityLogs as $log)
                                            <div class="sl-item sl-activity-log">
                                                <div class="sl-content">
                                                    <small class="text-muted">{{ $log->elapsed_time }}</small>
                                                    <p>{{ $log->details }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="sl-item sl-activity-log">
                                                <div class="sl-content">
                                                    <small class="text-muted">now</small>
                                                    <p>No Logs Found!</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $showActivityLog = false; @endphp
                        @endif
                    </div>
                </div>
            @endrole

            {{-- Accomplishment Report Officer --}}
            @role('AR Officer Admin')
                <div class="row">
                    {{-- Event Count Card --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{route('event.index')}}">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-warning">
                                    <span class="material-icons">article</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Event Reports</strong></p>
                                    <h3 class="card-title">{{ $eventCount ?? 0 }}</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <a href="{{route('event.index')}}">More info
                                            <i class="material-icons more-info">arrow_circle_right</i>
                                        </a>
                                    </div>
                                </div>
                                {{-- GPOA Alert Badge --}}
                                @if($accomplishedEventsCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{$accomplishedEventsCount}}
                                        <span class="visually-hidden">GPOA Alert</span>
                                    </span>
                                @endif
                            </div>
                        </a>
                    </div>

                    {{-- Student Accomplishment Count Card --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{route('studentAccomplishment.index')}}">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-success">
                                        <span class="material-icons">assignment_ind</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Student Reports</strong></p>
                                    <h3 class="card-title">{{ $studentAccomplishmentCount ?? 0 }}</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <a href="{{route('studentAccomplishment.index')}}">More info
                                            <i class="material-icons more-info">arrow_circle_right</i>
                                        </a>
                                    </div>
                                </div>
                                {{-- Student Accomplishment Pending Submission Badge --}}
                                @if($pendingStudentAccomplishmentCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{$pendingStudentAccomplishmentCount}}
                                        <span class="visually-hidden">Student Accomplishment Pending Submission Alert</span>
                                    </span>
                                @endif
                            </div>
                        </a>
                    </div>
                    
                    {{-- Accomplishment Report Count Card --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ route('accomplishmentreports.index') }}">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-rose">
                                    <span class="material-icons">inventory_2</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Accomplishment Reports</strong></p>
                                    <h3 class="card-title">{{ $accomplishmentReportCount ?? 0 }}</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <a href="{{ route('accomplishmentreports.index') }}">More info
                                            <i class="material-icons more-info">arrow_circle_right</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    {{-- Document Count Card --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{route('organizationDocuments.indexRedirect')}}">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-info">
                                        <span class="material-icons">source</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Organization Documents</strong></p>
                                    <h3 class="card-title">{{ $documentCount ?? 0 }}</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <a href="{{route('organizationDocuments.indexRedirect')}}">More info
                                            <i class="material-icons more-info">arrow_circle_right</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    
                    <div class="row justify-content-center">
                        {{-- Table --}}
                        <div class="col-lg-7 col-md-12">
                            <div class="card" style="min-height: 485px">
                                <div class="card-header card-header-text">
                                    <h4 class="card-title">
                                        Event Reports
                                    </h4>
                                    <p class="category">Latest added event reports</p>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($latestEvents->isNotEmpty())
                                                @php $i = 1 @endphp
                                                @foreach($latestEvents as $latestEvent)
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$latestEvent->title}}</td>
                                                    <td>
                                                        @if($latestEvent->start_date == $latestEvent->end_date)
                                                            {{date_format(date_create($latestEvent->start_date), 'F d, Y')}}
                                                        @else
                                                            {{date_format(date_create($latestEvent->start_date), 'F d, Y') . ' - ' . date_format(date_create($latestEvent->end_date), 'F d, Y')}}
                                                        @endif
                                                    </td>
                                                    <td>{{$latestEvent->eventRole->event_role}}</td>
                                                </tr>
                                                    @php $i += 1 @endphp
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4">No Event Found!</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Activity Logs --}}
                        @if($showActivityLog)
                        <div class="col-lg-5 col-md-12">
                            
                            <div class="card" style="min-height: 485px">
                                <div class="card-header card-header-text">
                                    <h4 class="card-title">
                                        Activity Log
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <div class="streamline">
                                         @if($activityLogs->isNotEmpty())
                                            @foreach($activityLogs as $log)
                                            <div class="sl-item sl-activity-log">
                                                <div class="sl-content">
                                                    <small class="text-muted">{{ $log->elapsed_time }}</small>
                                                    <p>{{ $log->details }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="sl-item sl-activity-log">
                                                <div class="sl-content">
                                                    <small class="text-muted">now</small>
                                                    <p>No Logs Found!</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $showActivityLog = false; @endphp
                        @endif
                    </div>
                </div>
            @endrole
            
            {{-- Organization Member / User --}}
            @role('User')
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-content trophy-icon icon icon-warning">
                                <h3 class="card-title trophy-icon"><span class="material-icons trophy-icon">emoji_events</span>{{$approvedAccomplishmentCount ?? "0"}}</h3>
                            </div>
                            <div class="card-footer trophy-icon">
                                <div class="stats trophy-icon">
                                    <a href="{{route('studentAccomplishment.index')}}"><strong>My Accomplishments</strong>
                                        <i class="material-icons more-info">arrow_circle_right</i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header">
                                        <div class="icon icon-info">
                                        <span class="material-icons">pending_actions</span>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <p class="category"><strong>Pending Submissions</strong></p>
                                        <h3 class="card-title">{{$pendingAccomplishmentCount ?? "0"}}</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <a href="{{route('studentAccomplishment.index')}}">More info
                                                <i class="material-icons more-info">arrow_circle_right</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header">
                                        <div class="icon icon-rose">
                                            <span class="material-icons">thumb_down_alt</span>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <p class="category"><strong>Declined Submissions</strong></p>
                                        <h3 class="card-title">{{$disapprovedAccomplishmentCount ?? "0"}}</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <a href="{{route('studentAccomplishment.index')}}">More info
                                                <i class="material-icons more-info">arrow_circle_right</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Activity Logs --}}
                    @if($showActivityLog)
                    <div class="col-lg-5 col-md-12">
                        
                        <div class="card" style="min-height: 485px">
                            <div class="card-header card-header-text">
                                <h4 class="card-title">
                                    Activity Log
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="streamline">
                                    @if($activityLogs->isNotEmpty())
                                            @foreach($activityLogs as $log)
                                            <div class="sl-item sl-activity-log">
                                                <div class="sl-content">
                                                    <small class="text-muted">{{ $log->elapsed_time }}</small>
                                                    <p>{{ $log->details }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="sl-item sl-activity-log">
                                                <div class="sl-content">
                                                    <small class="text-muted">now</small>
                                                    <p>No Logs Found!</p>
                                                </div>
                                            </div>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $showActivityLog = false; @endphp
                    @endif
                </div>
            @endrole
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        {{-- LOGIN ALERT TIMEOUT --}}
        window.setTimeout(function() {
            $("#login_alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 3000);
    </script>
@endsection
