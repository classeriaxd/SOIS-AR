@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    {{-- Title --}}
                    <h2 class="display-7 text-left">Dashboard</h2>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    {{-- Breadcrumbs --}}
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item active" aria-current="page">
                                Home
                            </li>
                        </ol>
                    </nav>
                </div>
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
                                    <p class="category"><strong>Documents</strong></p>
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

                    <!-- Table -->
                    <div class="row ">
                        <div class="col-lg-7 col-md-12">
                            <div class="card" style="min-height: 485px">
                                <div class="card-header card-header-text">
                                    <h4 class="card-title">
                                        Accomplished Reports <i class="fas fa-tools"></i>
                                    </h4>
                                    <p class="category">Latest added reports</p>
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
                                            <tr>
                                                <td>1</td>
                                                <td>Borderland: Withstanding Virtual Reality"</td>
                                                <td>Nov. 7, 2021</td>
                                                <td>Sponsor</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>General Assembly - Hacker x Hunter: The Algo Hunting Begins</td>
                                                <td>Oct. 22, 2021</td>
                                                <td>Organizer</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>PUPTALKS - Laboratory Utilization and Management </td>
                                                <td>Oct. 15, 2021</td>
                                                <td>Participant</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Oath Taking Ceremony</td>
                                                <td>Oct. 8, 2021</td>
                                                <td>Participant</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Safe Space Online Classroom for LGBTQIA+ Students</td>
                                                <td>Oct. 8, 2021</td>
                                                <td>Participant</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>Techer's Day</td>
                                                <td>Oct. 5, 2021</td>
                                                <td>Sponsor</td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>Knights of Honor 2021</td>
                                                <td>Sept. 30, 2021</td>
                                                <td>Organizer</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Activities -->
                        <div class="col-lg-5 col-md-12">
                            <div class="card" style="min-height: 485px">
                                <div class="card-header card-header-text">
                                    <h4 class="card-title">
                                        Activity Log <i class="fas fa-tools"></i>
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <div class="streamline">
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">5 mins ago</small>
                                                <p>You approved the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">25 mins ago</small>
                                                <p>You declined the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">40 mins ago</small>
                                                <p>You approved the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">45 minutes ago</small>
                                                <p>You declined the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">55 mins ago</small>
                                                <p>You approved the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">60 minutes ago</small>
                                                <p>You declined the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <a href="{{route('organizationDocuments.index', ['organizationSlug' => $organization->organization_slug])}}">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-info">
                                        <span class="material-icons">source</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong>Documents</strong></p>
                                    <h3 class="card-title">{{ $documentCount ?? 0 }}</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <a href="{{route('organizationDocuments.index', ['organizationSlug' => $organization->organization_slug])}}">More info
                                            <i class="material-icons more-info">arrow_circle_right</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Table -->
                    <div class="row ">
                        <div class="col-lg-7 col-md-12">
                            <div class="card" style="min-height: 485px">
                                <div class="card-header card-header-text">
                                    <h4 class="card-title">
                                        Accomplished Reports <i class="fas fa-tools"></i>
                                    </h4>
                                    <p class="category">Latest added reports</p>
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
                                            <tr>
                                                <td>1</td>
                                                <td>Borderland: Withstanding Virtual Reality"</td>
                                                <td>Nov. 7, 2021</td>
                                                <td>Sponsor</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>General Assembly - Hacker x Hunter: The Algo Hunting Begins</td>
                                                <td>Oct. 22, 2021</td>
                                                <td>Organizer</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>PUPTALKS - Laboratory Utilization and Management </td>
                                                <td>Oct. 15, 2021</td>
                                                <td>Participant</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Oath Taking Ceremony</td>
                                                <td>Oct. 8, 2021</td>
                                                <td>Participant</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Safe Space Online Classroom for LGBTQIA+ Students</td>
                                                <td>Oct. 8, 2021</td>
                                                <td>Participant</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>Techer's Day</td>
                                                <td>Oct. 5, 2021</td>
                                                <td>Sponsor</td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>Knights of Honor 2021</td>
                                                <td>Sept. 30, 2021</td>
                                                <td>Organizer</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Activities -->
                        <div class="col-lg-5 col-md-12">
                            <div class="card" style="min-height: 485px">
                                <div class="card-header card-header-text">
                                    <h4 class="card-title">
                                        Activity Log <i class="fas fa-tools"></i>
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <div class="streamline">
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">5 mins ago</small>
                                                <p>You approved the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">25 mins ago</small>
                                                <p>You declined the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">40 mins ago</small>
                                                <p>You approved the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">45 minutes ago</small>
                                                <p>You declined the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">55 mins ago</small>
                                                <p>You approved the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-activity-log">
                                            <div class="sl-content">
                                                <small class="text-muted">60 minutes ago</small>
                                                <p>You declined the submitted accomplishment report</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole

            {{-- Organization Member / User --}}
            @role('User')
                <div class="row">
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

                    <!-- Activities -->
                    <div class="col-lg-5 col-md-12">
                        <div class="card" style="min-height: 485px">
                            <div class="card-header card-header-text">
                                <h4 class="card-title">
                                    Activity Log <i class="fas fa-tools"></i>
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="streamline">
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">5 mins ago</small>
                                            <p>You submitted an accomplishment entitled "Borderland: Withstanding Virtual Reality"</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">25 mins ago</small>
                                            <p>You submitted an accomplishment entitled "U-Knights Tutorial"</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">40 mins ago</small>
                                            <p>You submitted an accomplishment entitled "OverKnights Got Talent"</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">45 minutes ago</small>
                                            <p>You submitted an accomplishment entitled "White Hackfest"</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">55 mins ago</small>
                                            <p>You submitted an accomplishment entitled "Safe Space Online Classroom for LGBTQIA+ Students"</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">60 minutes ago</small>
                                            <p>You submitted an accomplishment entitled "Mental Health Webinar"</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
