@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
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
                            Review this Accomplishment
                        </a>
                    </div>
                    @endif
                    @endposition_title
                    <div class="card">
                        <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">{{ $accomplishmentReport->title }}</h5>
                        <div class="card-body">
                        @if($accomplishmentReport->status == 1)
                            <h6 class="text-center text-dark font-weight-bold"><span class="bg-warning rounded">Status: PENDING</span></h6>
                        @elseif ($accomplishmentReport->status == 2)
                            <h6 class="text-center text-white font-weight-bold"><span class="bg-success rounded">Status: APPROVED</span></h6>
                        @elseif ($accomplishmentReport->status == 3)
                            <h6 class="text-center text-white font-weight-bold"><span class="bg-danger rounded">Status: DISAPPROVED</span></h6>
                        @endif

                        <p class="text-center">{{ $accomplishmentReport->description }}</p>
                        <p class="text-center">Inclusive Date<br>{{ date_format(date_create($accomplishmentReport->start_date), 'F d, Y') . ' - ' . date_format(date_create($accomplishmentReport->end_date), 'F d, Y') }}</p>
                        
                        <div class="flex-row text-center mb-2">
                            {{-- Tabular --}}
                            @if($accomplishmentReport->accomplishment_report_type == 1)
                            <p class="text-center">No preview for spreadsheet files, you can download the generated report instead.</p>  
                            <form action="{{route('accomplishmentReport.download',['accomplishmentReportUUID' => $accomplishmentReport->accomplishment_report_uuid])}}" enctype="multipart/form-data">
                                <button class="btn btn-primary text-white" type="submit">
                                    <i class="fas fa-file-excel"></i> Download Spreadsheet
                                </button>
                            </form>

                            {{-- Design --}}
                            @elseif($accomplishmentReport->accomplishment_report_type == 2)
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
                <div class="row justify-content-center pt-1">
                    <a href="{{route('accomplishmentreports.create')}}">
                        <button class="btn btn-primary">Submit Another</button>
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
