@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
    		<h2 class="display-2 text-center">Accomplishment Report</h2>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-8">
                    @position_title('President')
                    @if($accomplishmentReport->status == 1)
                    <div class="row justify-content-center my-1">  
                        <a href="{{route('accomplishmentReport.review', ['accomplishmentReportUUID' => $accomplishmentReport->accomplishment_report_uuid])}}">
                            <button class="btn btn-primary">Review this Accomplishment</button>
                        </a>
                    </div>
                    @endif
                    @endposition_title
                    <div class="card">
                        <h5 class="card-header card-title text-center">{{ $accomplishmentReport->title }}</h5>
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
                        <p class="text-center">
                        @if($accomplishmentReport->for_archive)
                            <span style="color:green;">This Report will be Archived</span>
                        @else
                            <span style="color:red;">This Report will not be Archived</span>
                        @endif
                        </p>
                        <div class="row justify-content-center mb-2">
                            <iframe src="{{'/storage/'.$accomplishmentReport->file}}#toolbar=0" width="100%" style="height:75vh;">
                            </iframe>
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
        	<div class="row justify-content-center pt-1">
        		<a href="{{route('accomplishmentreports.index')}}">
        			<button class="btn btn-secondary">Go Back</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection
