@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
    		<h2 class="display-2 text-center">Report Review</h2>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-8">
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
                        @if($accomplishmentReport->for_archive == 1)
                            <p class="text-center">The Documentation Officer recommends this report to be <span style="color:green;font-weight: bold;">Archived.</span></p>
                        @else
                            <p class="text-center">The Documentation Officer recommends this report to be <span style="color:red;font-weight: bold;">Temporary.</span></p>
                        @endif
                        <div class="row justify-content-center mb-2">
                            <iframe src="{{'/storage/'.$accomplishmentReport->file}}#toolbar=0" width="100%" style="height:75vh;">
                            </iframe>
                            <br>
                        </div>

                        </div>
                    </div>
        		</div>
                <div class="col-md-4">
                    <form action="{{route('accomplishmentReport.finalizeReview', ['accomplishmentReportUUID' => $accomplishmentReport->accomplishment_report_uuid])}}" method="POST">
                        <div class="card my-1 w-100">
                            <div class="card-header card-title text-center">Review Remarks</div>
                            <small class="text-center">Include comments for possible changes for this submission to be approved.</small>
                            <div class="card-body">
                                <textarea class="form-control" id="remarks" name="remarks" placeholder="Start Review here..." rows="9" required></textarea>
                                @csrf
                            </div>
                        </div>
                        <div class="card card-body my-1 w-100 text-center">
                        @if($accomplishmentReport->for_archive == 1)
                            <p>The Documentation Officer recommends this report to be <span style="color:green;font-weight: bold;">Archived.</span></p>
                        @else
                            <p>The Documentation Officer recommends this report to be <span style="color:red;font-weight: bold;">Temporary.</span></p>
                        @endif
                            <div class="form-group justify-content-center my-1 row">
                                <div class="form-check">
                                    <input type="checkbox" id="archive" name="archive" class="form-check-input">
                                    <label class="form-check-label" for="archive">Archive this Accomplishment Report?</label>
                                    <a role="button"
                                        data-toggle="popover"
                                        data-placement="top"
                                        title="Archiving Accomplishment Reports" 
                                        data-content="Reports that will be archived are stored permanently. Temporary reports will only last for 30 days. ">
                                        <i class="far fa-question-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card card-body my-1 w-100 text-center">
                            <div class="form-group justify-content-center my-1 row">
                                <div class="form-check">
                                    <input type="checkbox" id="esignature" name="esignature" class="form-check-input">
                                    <label class="form-check-label" for="esignature">Include E-Signature for Signatory Page?</label>
                                    <a role="button"
                                        data-toggle="popover"
                                        data-placement="top"
                                        title="E-Signatures" 
                                        data-content="E-Signature Content">
                                        <i class="far fa-question-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card card-body text-center">
                            <div class="row mb-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-success w-100" type="submit" name="success" value="success">Approve</button>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-danger w-100" type="submit" name="decline" value="decline">Decline</button>
                                </div>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
        	</div>
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
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();   
        });
    </script>
@endsection
