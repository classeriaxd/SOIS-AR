@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @position_title('Officer')
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
            
            <!-- <div class="card my-2 border border-dark">
                <h4 class="card-header card-text text-center align-middle bg-maroon text-white fw-bold">
                    Events
                </h4>
                <div class="card-body">
                    <div class="flex-row d-flex justify-content-center">
                        <a href="{{route('event.create')}}" 
                        class="btn btn-primary m-1 text-white" 
                        role="button">
                            Add Event
                        </a>
                        <a href="{{route('event.index')}}" 
                        class="btn btn-primary m-1 text-white" 
                        role="button">
                            View Events
                        </a>
                        
                    </div>
                </div>
            </div>

            <div class="card my-2 border border-dark">
                <h4 class="card-header card-text text-center align-middle bg-maroon text-white fw-bold">
                    Accomplishment Reports
                </h4>
                <div class="card-body">
                    <div class="flex-row d-flex justify-content-center">
                        <a href="{{route('accomplishmentreports.create')}}" 
                        class="btn btn-primary m-1 text-white" 
                        role="button">
                            Create Accomplishment Report
                        </a>
                        <a href="{{route('accomplishmentreports.index')}}" 
                        class="btn btn-primary m-1 text-white"
                        role="button">
                            Report Submissions
                            <span class="badge rounded-pill bg-warning text-dark">
                                {{$pendingARSubmissionCount ?? "0"}}
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card my-2 border border-dark">
                <h4 class="card-header card-text text-center align-middle bg-maroon text-white fw-bold">
                    Student Accomplishments
                </h4>
                <div class="card-body">
                    <div class="flex-row d-flex justify-content-center">
                        <a href="{{route('studentAccomplishment.index')}}"
                        class="btn btn-primary text-white"
                        role="button">
                            Accomplishment Submissions
                            <span class="badge rounded-pill bg-light text-dark">
                                {{$submissionCount ?? "0"}}
                            </span>
                        </a>
                    </div>
                </div>
            </div> -->

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-warning">
                            <span class="material-icons">article</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Event Reports</strong></p>
                            <h3 class="card-title">70,340</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="#pablo">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-rose">
                            <span class="material-icons">inventory_2</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Archived Reports</strong></p>
                            <h3 class="card-title">102</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="#pablo">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-success">
                                <span class="material-icons">assignment_ind</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Student's Reports</strong></p>
                            <h3 class="card-title">23,100</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="#pablo">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-info">
                                <span class="material-icons">source</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Other Documents</strong></p>
                            <h3 class="card-title">245</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="#pablo">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="row ">
                    <div class="col-lg-7 col-md-12">
                        <div class="card" style="min-height: 485px">
                            <div class="card-header card-header-text">
                                <h4 class="card-title">Accomplished Reports</h4>
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
                                <h4 class="card-title">Activity Log</h4>
                            </div>
                            <div class="card-content">
                                <div class="streamline">
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">5 mins ago</small>
                                            <p>You created a report entitled "General Assembly 2021"</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">25 mins ago</small>
                                            <p>You submitted an accomplishment report</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">40 mins ago</small>
                                            <p>You deleted a report entitled "U-Knights Tutorial"</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">45 minutes ago</small>
                                            <p>You updated a report entilted "Knights of Honor"</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">55 mins ago</small>
                                            <p>You approved a member's report entitled "Recognition"</p>
                                        </div>
                                    </div>
                                    <div class="sl-item sl-activity-log">
                                        <div class="sl-content">
                                            <small class="text-muted">60 minutes ago</small>
                                            <p>You declined a member's report entitled "Stock Markert"</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @elseposition_title('Member')
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
            <!-- <div class="pb-2">
                <div class="card my-2 border border-dark">
                    <h4 class="card-header card-text text-center align-middle bg-maroon text-white fw-bold">
                        Accomplishments
                    </h4>
                    <div class="card-body">
                        <div class="flex-row d-flex justify-content-center">
                            <a href="{{route('studentAccomplishment.index')}}" class="btn btn-primary text-white" role="button">
                                My Accomplishments 
                                <span class="badge rounded-pill bg-success text-white">{{$approvedAccomplishmentCount ?? "0"}}</span> 
                                <span class="badge rounded-pill bg-warning text-dark">{{$pendingAccomplishmentCount ?? "0"}}</span> 
                                <span class="badge rounded-pill bg-danger text-white">{{$disapprovedAccomplishmentCount ?? "0"}}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div> -->
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
                                <h4 class="card-title">Activity Log</h4>
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
        @elseposition_title('President')
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
            <!-- <div class="card my-2 border border-dark">
                <h4 class="card-header card-text text-center align-middle bg-maroon text-white fw-bold">
                    Accomplishment Reports
                </h4>
                <div class="card-body">
                    <div class="flex-row d-flex justify-content-center">
                        <a href="{{route('accomplishmentreports.index')}}"
                        class="btn btn-primary m-1 text-white"
                        role="button">
                            View Pending Accomplishment Reports 
                            <span class="badge rounded-pill bg-warning text-dark">
                                {{ $pendingARSubmissionCount ?? "0" }}
                            </span>
                        </a>
                    </div>
                </div>
            </div> -->

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-warning">
                            <span class="material-icons">article</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Event Reports</strong></p>
                            <h3 class="card-title">70,340</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="#pablo">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-rose">
                            <span class="material-icons">inventory_2</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Archived Reports</strong></p>
                            <h3 class="card-title">102</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="#pablo">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-success">
                                <span class="material-icons">assignment_ind</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Student's Reports</strong></p>
                            <h3 class="card-title">23,100</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="#pablo">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-info">
                                <span class="material-icons">source</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Other Documents</strong></p>
                            <h3 class="card-title">245</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="#pablo">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="row ">
                    <div class="col-lg-7 col-md-12">
                        <div class="card" style="min-height: 485px">
                            <div class="card-header card-header-text">
                                <h4 class="card-title">Accomplished Reports</h4>
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
                                <h4 class="card-title">Activity Log</h4>
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
        @endposition_title
        </div>
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
    {{-- <div class="card my-1">
        <div class="card-header text-center align-middle">
            <div class="display-5">Organization Documents</div>
        </div>
        <div class="card-body">
            <div class="row justify-content-center mb-2">
                <a href="/o/documents/create">
                    <button class="btn btn-primary mr-2" disabled>Add Organization Documents</button>
                </a>
                <a href="o/documents">
                    <button class="btn btn-primary mr-2" disabled>View Organization Documents</button>
                </a>
            </div>
        </div>
    </div> --}}