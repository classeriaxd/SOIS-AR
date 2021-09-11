@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
    		<h2 class="display-2 text-center">Initial Review</h2>
        	<div class="row justify-content-center pb-1">
                <div class="col-md-8">
                    <div class="card">
                        <h5 class="card-header card-title text-center">{{ $accomplishment->title }}</h5>
                        <div class="card-body">
                            <h6 class="text-center text-dark font-weight-bold"><span class="bg-warning rounded">Student Details</span></h6>
                            <div class="text-center">
                                <p>NAME: {{ $student->name ?? 'NONE' }}</p>
                                <p>STUDENT NUMBER: {{$student->student_number ?? 'NONE' }}</p>
                                <p>EMAIL: {{$student->email ?? 'NONE' }}</p>
                            </div>
                            <hr>
                            <h6 class="text-center text-dark font-weight-bold"><span class="bg-warning rounded">Accomplishment Details</span></h6>
                            <p class="text-center">TITLE: {{ $accomplishment->title  ?? 'NONE' }}</p>
                            <p class="text-center">DESCRIPTION: {{ $accomplishment->description  ?? 'NONE' }}</p>
                            <p class="text-center">DATE AWARDED: {{ date_format(date_create($accomplishment->date_awarded), 'F d, Y')  ?? 'NONE' }}</p>
                            <hr>
                            <h6 class="text-center text-dark font-weight-bold">Uploaded Evidences</h6>
                            @foreach($accomplishmentFiles as $file)
                            @if($file->type == 1)
                            {{-- IMG --}}
                            <div class="row justify-content-center mb-2">
                                <img src="{{'/storage/'.$file->file}}" style="max-width:600px; max-height:300px;min-width:600px; min-height:300px;">
                                <br>
                            </div>
                            @elseif($file->type == 2)
                            {{-- PDF --}}
                            <div class="row justify-content-center mb-2">
                                <iframe src="{{'/storage/'.$file->file}}#toolbar=0" width="100%" style="height:25vh;">
                                </iframe>
                                <br>
                            </div>
                            @endif
                            <div class="row justify-content-center">
                                <p class="text-center">{{$file->caption}}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <form action="{{route('student_accomplishment.submissionDecision',['accomplishment_uuid' => $accomplishment->accomplishment_uuid,]);}}" method="POST">
                        <div class="card mb-1 w-100">
                            <div class="card-header card-title text-center">Review Remarks</div>
                            <small class="text-center">Include comments for possible changes for this submission to be approved.</small>
                            <div class="card-body">
                                <textarea class="form-control" id="remarks" name="remarks" placeholder="Start Review here..." rows="9" required></textarea>
                                @csrf
                            </div>
                        </div>
                        <div class="card card-body text-center">
                            <div class="row mt-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-danger w-100" type="submit" name="decline" id="decline" value="decline">Decline</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-success w-100" type="submit" name="success" id="success" value="success">Approve for further Review</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
        	</div>
        	<hr>
        	<div class="row justify-content-center pt-1">
        		<a href="/s/accomplishments">
        			<button class="btn btn-secondary">Go back</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection