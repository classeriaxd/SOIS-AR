@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Login Alert --}}
                @if ($loginAlert != NULL)
                    <div id="login_alert" style="position:fixed; top:0; right:0; width:20%;">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $loginAlert }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
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
            <!-- <div class="row">
                <a href="{{ route('admin.events.index') }}">
                    <p class="text-primary border border-dark">Accomplished Event Count: {{ $eventCount ?? 0 }}</p>
                </a>
                <a href="{{ route('admin.organizations.index') }}">
                    <p class="text-primary border border-dark">Organization Count: {{ $organizationCount ?? 0 }}</p>
                </a>
                <a href="{{ route('admin.accomplishmentReports.index') }}">
                    <p class="text-primary border border-dark">AR Count: {{ $accomplishmentReportCount ?? 0 }}</p>
                </a>
            </div> -->
            
            
            
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-success">
                                <span class="material-icons">groups</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>School Organizations</strong></p>
                            <h3 class="card-title">{{ $organizationCount ?? 0 }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="{{ route('admin.organizations.index') }}">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-info">
                                <span class="material-icons">task</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Accomplishment Reports</strong></p>
                            <h3 class="card-title">{{ $accomplishmentReportCount ?? 0 }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="{{ route('admin.accomplishmentReports.index') }}">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-rose">
                            <span class="material-icons">description</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Event Reports</strong></p>
                            <h3 class="card-title">{{ $eventCount ?? 0 }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="{{ route('admin.events.index') }}">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <!-- <div class="row ">
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
                    </div> -->

                    <!-- Activities -->
                    <!-- <div class="col-lg-5 col-md-12">
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
                    </div> -->
                </div>

            </div>

            <div class="card w-100">
            <h5 class="card-header card-title text-center bg-maroon text-black fw-bold">Send an Announcement</h5>
            <div class="card-body text-center">
                <p>(Announcement Form)</p>
            </div>
            </div>
            
            <!-- <div class="card w-100">
                <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Maintenance</h5>
                <div class="card-body">
                    <div class="flex-row text-center my-1">
                        <a href="{{ route('admin.maintenance.eventCategories.index') }}"
                        role="button"
                        class="btn btn-primary text-white">
                            Event Categories
                        </a>
                        <a href="{{ route('admin.maintenance.eventRoles.index') }}"
                        role="button"
                        class="btn btn-primary text-white">
                            Event Roles
                        </a>
                        <a href="{{ route('admin.maintenance.eventNatures.index') }}"
                        role="button"
                        class="btn btn-primary text-white">
                            Event Natures
                        </a>
                        <a href="{{ route('admin.maintenance.eventClassifications.index') }}"
                        role="button"
                        class="btn btn-primary text-white">
                            Event Classifications
                        </a>
                        <a href="{{ route('admin.maintenance.eventDocumentTypes.index') }}"
                        role="button"
                        class="btn btn-primary text-white">
                            Event Document Types
                        </a>
                    </div>
                    <div class="flex-row text-center my-1">
                        <a href="{{ route('admin.maintenance.levels.index') }}"
                        role="button"
                        class="btn btn-primary text-white">
                            Levels
                        </a>
                        <a href="{{ route('admin.maintenance.fundSources.index') }}"
                        role="button"
                        class="btn btn-primary text-white">
                            Fund Sources
                        </a>
                        <a href="#"
                        role="button"
                        class="btn btn-primary text-white disabled">
                            School Years
                        </a>
                        <a href="#"
                        role="button"
                        class="btn btn-primary text-white disabled">
                            Organization Document Types
                        </a>
                    </div>
                    <div class="flex-row text-center my-1">
                        <a href="{{ route('admin.maintenance.tabularTables.index') }}"
                        role="button"
                        class="btn btn-primary text-white">
                            Tabular AR Tables
                        </a>
                    </div>
                    
                </div>
            </div> -->
            

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
