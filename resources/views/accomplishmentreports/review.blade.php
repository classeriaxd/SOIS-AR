@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h4 class="display-5 text-center">Report Review</h4>
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
                        <li class="breadcrumb-item">
                            <a href="{{route('accomplishmentReport.show', ['accomplishmentReportUUID' => $accomplishmentReport->accomplishment_report_uuid])}}" class="text-decoration-none">
                                {{ $accomplishmentReport->title }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Review
                        </li>
                    </ol>
                </nav>
            </div>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-8">
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
                        <div class="card mB-1 w-100">
                            <div class="card-header card-title text-center bg-maroon text-white fw-bold">Review Remarks</div>
                            <small class="text-center">Include comments for possible changes for this submission to be approved.</small>
                            <div class="card-body">
                                <textarea class="form-control" id="remarks" name="remarks" placeholder="Start Review here..." rows="9" required></textarea>
                                @csrf
                            </div>
                        </div>
                        <div class="card card-body my-1 w-100 text-center">
                            <div class="form-group justify-content-center my-1 row">
                                <div class="form-check">
                                    <input type="checkbox" id="esignature" name="esignature" class="form-check-input">
                                    <label class="form-check-label" for="esignature">Include E-Signature for Signatory Page?</label>
                                    <a role="button"
                                        data-bs-toggle="popover"
                                        data-bs-container="body"
                                        title="E-Signatures" 
                                        data-bs-content="If theres an e-signature included in the system, include that above the names of the signatories."
                                        data-bs-trigger="hover focus"
                                        data-bs-placement="right">
                                        <i class="far fa-question-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card card-body text-center">
                            <div class="row mb-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-success text-white w-100" type="submit" name="success" value="success">Approve</button>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-danger text-white w-100" type="submit" name="decline" value="decline">Decline</button>
                                </div>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
        	</div>
        	<hr>

            <div class="flex-row my-2 text-center">
                <a href="{{route('accomplishmentreports.index')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        Go Back
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
