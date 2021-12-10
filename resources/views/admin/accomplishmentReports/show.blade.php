@extends('layouts.admin-app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Accomplishment Report View</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.accomplishmentReports.index')}}" class="text-decoration-none">Accomplishment Reports</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.accomplishmentReports.organization.index', ['organizationSlug' => $accomplishmentReport->organization->organization_slug])}}" class="text-decoration-none">{{ $accomplishmentReport->organization->organization_acronym }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $accomplishmentReport->title }}
                        </li>
                    </ol>
                </nav>
            </div>
            
        	<div class="row my-2">
                <div class="card">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">{{ $accomplishmentReport->title }}</h5>
                    <div class="card-body">
                        <h6 class="text-center">
                            @if($accomplishmentReport->status == 1)
                                <span class="badge bg-warning text-dark rounded-pill fs-6 text-center">Pending</span>
                            @elseif($accomplishmentReport->status == 2 && $accomplishmentReport->accomplishmentReportType->accomplishment_report_type == 'Design')
                                <span class="badge bg-success text-white rounded-pill fs-6 text-center">Approved</span>
                                <p class="text-center"><span class="fw-bold">By: </span>{{$accomplishmentReport->reviewer->full_name}}</p>
                            @elseif($accomplishmentReport->status == 2 && $accomplishmentReport->accomplishmentReportType->accomplishment_report_type == 'Tabular')
                                <span class="badge bg-success text-white rounded-pill fs-6 text-center">Automatically Approved</span>
                                <p class="text-center"><span class="fw-bold">By: </span>SYSTEM</p>
                            @elseif ($accomplishmentReport->status == 3)
                                <span class="badge bg-danger text-white rounded-pill fs-6 text-center">Disapproved</span>
                                <p class="text-center"><span class="fw-bold">By: </span>{{$accomplishmentReport->reviewer->full_name}}</p>
                            @endif
                        </h6>
                        

                        <p class="text-center"><span class="fw-bold">Description: </span>{{ $accomplishmentReport->description }}</p>
                        <p class="text-center"><span class="fw-bold">Inclusive Date</span><br>{{ date_format(date_create($accomplishmentReport->start_date), 'F d, Y') . ' - ' . date_format(date_create($accomplishmentReport->end_date), 'F d, Y') }}</p>
                        <p class="text-center"><span class="fw-bold">Created By: </span>{{$accomplishmentReport->creator->full_name}} </p>
                        {{-- Download button for Design --}}
                        @if ($accomplishmentReport->status == 2 && $accomplishmentReport->accomplishment_report_type_id == 2)
                        <div class="flex-row text-center my-1">
                            <form action="{{route('accomplishmentReport.download',['accomplishmentReportUUID' => $accomplishmentReport->accomplishment_report_uuid])}}" enctype="multipart/form-data">
                                <button class="btn btn-primary text-white" type="submit">
                                    <i class="fas fa-file-pdf"></i> Download Accomplishment Report
                                </button>
                            </form>
                        </div>
                        @endif

                        {{-- Accomplishment Report File View --}}
                        <div class="flex-row text-center my-1">
                            {{-- Tabular --}}
                            @if($accomplishmentReport->accomplishmentReportType->accomplishment_report_type == 'Tabular')
                            <p class="text-center">No preview for spreadsheet files, you can download the generated report instead.</p>  
                            <form action="{{route('accomplishmentReport.download',['accomplishmentReportUUID' => $accomplishmentReport->accomplishment_report_uuid])}}" enctype="multipart/form-data">
                                <button class="btn btn-primary text-white" type="submit">
                                    <i class="fas fa-file-excel"></i> Download Spreadsheet
                                </button>
                            </form>

                            {{-- Design --}}
                            @elseif($accomplishmentReport->accomplishmentReportType->accomplishment_report_type == 'Design')
                            <iframe src="{{'/storage/'.$accomplishmentReport->file}}#toolbar=0" width="100%" style="height:75vh;">
                            </iframe>
                            @endif
                            
                            <br>
                        </div>

                    </div>
                </div>
        	</div>

            <hr>

            <div class="flex-row my-2 text-center">
                <a href="{{route('admin.accomplishmentReports.organization.index', ['organizationSlug' => $accomplishmentReport->organization->organization_slug])}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-arrow-left"></i> Go back to {{$accomplishmentReport->organization->organization_acronym}} Accomplishment Reports
                </a>
                
                <span>or</span>
                
                <a href="{{route('admin.accomplishmentReports.index')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-arrow-left"></i> Go back to All Accomplishment Reports
                </a>            
            </div>

            

        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Enable Popovers --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap_related_js/enablePopover.js') }}"></script>
@endsection
