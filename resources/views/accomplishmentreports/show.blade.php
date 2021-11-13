@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Success Alert --}}
                @if (session()->has('success'))
                    <div class="flex-row text-center" id="success_alert">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h4 class="display-5 text-center">Accomplishment Report</h4>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('accomplishmentreports.index')}}" class="text-decoration-none">
                                Accomplishment Reports
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $accomplishmentReport->title }}
                        </li>
                    </ol>
                </nav>
            </div>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-8">
                    @position_title('President')
                    @if($accomplishmentReport->status == 1)
                    <div class="flex-row my-2 text-center">  
                        <a href="{{route('accomplishmentReport.review', ['accomplishmentReportUUID' => $accomplishmentReport->accomplishment_report_uuid])}}"
                            class="btn btn-primary text-white"
                            role="button">
                            <i class="fas fa-clipboard-check"></i> Review this Accomplishment
                        </a>
                    </div>
                    @endif
                    @endposition_title
                    <div class="card">
                        <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">{{ $accomplishmentReport->title }}</h5>
                        <div class="card-body">
                            <h6 class="text-center">
                                @if($accomplishmentReport->status == 1)
                                    <span class="badge bg-warning text-dark rounded-pill fs-6 text-center">Pending</span>
                                @elseif($accomplishmentReport->status == 2 && $accomplishmentReport->accomplishmentReportType->accomplishment_report_type == 'Design')
                                    <span class="badge bg-success text-white rounded-pill fs-6 text-center">Approved</span>
                                @elseif($accomplishmentReport->status == 2 && $accomplishmentReport->accomplishmentReportType->accomplishment_report_type == 'Tabular')
                                    <span class="badge bg-success text-white rounded-pill fs-6 text-center">Automatically Approved</span>
                                @elseif ($accomplishmentReport->status == 3)
                                    <span class="badge bg-danger text-white rounded-pill fs-6 text-center">Disapproved</span>
                                @endif
                            </h6>

                            <p class="text-center"><span class="fw-bold">Description: </span>{{ $accomplishmentReport->description }}</p>
                            <p class="text-center">Inclusive Date<br>{{ date_format(date_create($accomplishmentReport->start_date), 'F d, Y') . ' - ' . date_format(date_create($accomplishmentReport->end_date), 'F d, Y') }}</p>

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
                                @if($accomplishmentReport->accomplishment_report_type_id == 1)
                                <p class="text-center">No preview for spreadsheet files, you can download the generated report instead.</p>  
                                <form action="{{route('accomplishmentReport.download',['accomplishmentReportUUID' => $accomplishmentReport->accomplishment_report_uuid])}}" enctype="multipart/form-data">
                                    <button class="btn btn-primary text-white" type="submit">
                                        <i class="fas fa-file-excel"></i> Download Spreadsheet
                                    </button>
                                </form>

                                {{-- Design --}}
                                @elseif($accomplishmentReport->accomplishment_report_type_id == 2)
                                <iframe src="{{'/storage/'.$accomplishmentReport->file}}#toolbar=0" width="100%" style="height:75vh;">
                                </iframe>
                                @endif
                                
                                <br>
                            </div>

                        </div>
                    </div>
        		</div>
        	</div>
            @if($newAccomplishmentReport)

                <hr>

                <div class="flex-row my-2 text-center">
                    <a href="{{route('accomplishmentreports.create')}}"
                        class="btn btn-primary text-white align-middle"
                        role="button">
                            <i class="fas fa-file-alt"></i> Submit Another
                    </a>
                </div>

            @endif

        	<hr>

            <div class="flex-row my-2 text-center">
                <a href="{{route('accomplishmentreports.index')}}"
                    class="btn btn-secondary text-white align-middle"
                    role="button">
                        <i class="fas fa-arrow-left"></i> Go Back
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
