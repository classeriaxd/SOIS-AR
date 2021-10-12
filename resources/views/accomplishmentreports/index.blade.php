@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
    		<h2 class="display-2 text-center">Accomplishment Report</h2>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-8">
                    <div class="card my-1">
                        <h4 class="card-title card-header text-white bg-maroon">Approved Reports</h4>
                        <div class="card-body">
                        @if($approvedAccomplishmentReports->isNotEmpty())
                            @foreach($approvedAccomplishmentReports as $report)
                            <a href="{{route('accomplishmentReport.show', ['accomplishmentReportUUID' => $report->accomplishment_report_uuid])}}" class="text-dark ">
                                <div class="row m-2 p-1 border border-dark">
                                    <div class="col">
                                        <h5 class="text-center font-weight-bold">{{$report->title}}</h5>
                                        <p class="text-center">{{$report->description}}</p>
                                        <p class="text-center">Inclusive Date<br>{{ date_format(date_create($report->start_date), 'F d, Y') . ' - ' . date_format(date_create($report->end_date), 'F d, Y') }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            <div class="row justify-content-center">
                                {{ $approvedAccomplishmentReports->appends([
                                    'pending' => $pendingAccomplishmentReports->currentPage(),
                                    'declined' => $declinedAccomplishmentReports->currentPage(),
                                ])->links() }}
                            </div>
                        @else
                            <p class="text-center">No Approved Report found. :(</p>
                        @endif
                        </div>
                    </div>

                    <div class="card my-1">
                        <h4 class="card-title card-header text-white bg-maroon">Pending Reports</h4>
                        <div class="card-body">
                        @if($pendingAccomplishmentReports->isNotEmpty())
                            @foreach($pendingAccomplishmentReports as $report)
                            <a href="{{route('accomplishmentReport.show', ['accomplishmentReportUUID' => $report->accomplishment_report_uuid])}}" class="text-dark ">
                                <div class="row m-2 p-1 border border-dark">
                                    <div class="col">
                                        <h5 class="text-center font-weight-bold">{{$report->title}}</h5>
                                        <p class="text-center">{{$report->description}}</p>
                                        <p class="text-center">Inclusive Date<br>{{ date_format(date_create($report->start_date), 'F d, Y') . ' - ' . date_format(date_create($report->end_date), 'F d, Y') }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            <div class="row justify-content-center">
                                {{ $pendingAccomplishmentReports->appends([
                                    'approved' => $approvedAccomplishmentReports->currentPage(),
                                    'declined' => $declinedAccomplishmentReports->currentPage(),
                                ])->links() }}
                            </div>
                        @else
                            <p class="text-center">No Pending Report found. :(</p>
                        @endif
                        </div>
                    </div>

                    <div class="card my-1">
                        <h4 class="card-title card-header text-white bg-maroon">Declined Reports</h4>
                        <div class="card-body">
                        @if($declinedAccomplishmentReports->isNotEmpty())
                            @foreach($declinedAccomplishmentReports as $report)
                            <a href="{{route('accomplishmentReport.show', ['accomplishmentReportUUID' => $report->accomplishment_report_uuid])}}" class="text-dark ">
                                <div class="row m-2 p-1 border border-dark">
                                    <div class="col">
                                        <h5 class="text-center font-weight-bold">{{$report->title}}</h5>
                                        <p class="text-center">{{$report->description}}</p>
                                        <p class="text-center">Inclusive Date<br>{{ date_format(date_create($report->start_date), 'F d, Y') . ' - ' . date_format(date_create($report->end_date), 'F d, Y') }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            <div class="row justify-content-center">
                                {{ $declinedAccomplishmentReports->appends([
                                    'approved' => $approvedAccomplishmentReports->currentPage(),
                                    'pending' => $pendingAccomplishmentReports->currentPage(),
                                ])->links() }}
                            </div>
                        @else
                            <p class="text-center">No Declined Report found. :)</p>
                        @endif
                        </div>
                    </div>

        		</div>
        	</div>

        	<hr>
        	<div class="justify-content-center d-flex flex-row">
        		<a href="/home">
        			<button class="btn btn-secondary">Home</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection
