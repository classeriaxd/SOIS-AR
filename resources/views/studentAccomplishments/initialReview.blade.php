@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Initial Review</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('studentAccomplishment.index')}}" class="text-decoration-none">
                                Student Accomplishments
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('studentAccomplishment.show' , ['accomplishmentUUID' => $accomplishment->accomplishment_uuid ])}}" class="text-decoration-none">
                                {{ $accomplishment->title }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Initial Review
                        </li>
                    </ol>
                </nav>
            </div>

        	<div class="row justify-content-center pb-1">

                {{-- Accomplishment Details --}}
                <div class="col-md-8">
                    <div class="card">
                        <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Accomplishment Details</h5>
                        <div class="card-body">

                            {{-- Title --}}
                            <h3 class="card-title text-center fw-bold">
                                {{ $accomplishment->title }}
                            </h3>

                            {{-- Accomplishment Details --}}
                            <div class="row">
                                {{-- Description and Objective Column --}}
                                <div class="col">
                                    <p class="card-title text-center fw-bold">Description and Objective:</p>
                                    <p class="text-center">
                                        <span class="fw-bold">Description</span>
                                        {{ $accomplishment->description }}
                                    </p>
                                    <p class="text-center">
                                        <span class="fw-bold">Objective</span>
                                        {{ $accomplishment->objective }}
                                    </p>
                                </div>

                                {{-- Details Column --}}
                                <div class="col">
                                    <p class="card-title text-center fw-bold">Details:</p>
                                    <p class="text-center">
                                        <span class="fw-bold">Organizer:</span>
                                        {{ $accomplishment->organizer }}
                                    </p>
                                    <p class="text-center">
                                        <span class="fw-bold">Venue:</span>
                                        {{ $accomplishment->venue }}
                                    </p>
                                    <p class="text-center">
                                        <span class="fw-bold">Date and Time:</span>
                                        @if($accomplishment->start_date == $accomplishment->end_date){{date_format(date_create($accomplishment->start_date), 'F d, Y')}}
                                        @else{{date_format(date_create($accomplishment->start_date), 'F d, Y') . ' - ' . date_format(date_create($accomplishment->end_date), 'F d, Y')}}
                                        @endif
                                         - 
                                        @if($accomplishment->start_time == $accomplishment->end_time){{date_format(date_create($accomplishment->start_time), 'h:i A')}}
                                        @else{{date_format(date_create($accomplishment->start_time), 'h:i A') . ' - ' . date_format(date_create($accomplishment->end_time), 'h:i A')}}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <hr>

                            {{-- Student Details --}}
                            <div class="row">
                                <div class="col">
                                    <p class="card-title text-center fw-bold">Student Details:</p>
                                    <p class="text-center">
                                        <span class="fw-bold">Full Name:</span>
                                        {{ $accomplishment->student->full_name }}
                                    </p>
                                    <p class="text-center">
                                        <span class="fw-bold">Student Number:</span>
                                        {{ $accomplishment->student->student_number }}
                                    </p>
                                    <p class="text-center">
                                        <span class="fw-bold">Email:</span>
                                        {{ $accomplishment->student->email }}
                                    </p>
                                </div>
                            </div>
                            
                            <hr>

                            {{-- Accomplishment Documents --}}
                            <div class="row">
                                <p class="card-title text-center fw-bold">Uploaded Evidences</p>
                                @if($accomplishment->accomplishmentFiles->count() > 0)
                                    @foreach($accomplishment->accomplishmentFiles as $file)
                                        {{-- If the file is an IMG... --}}
                                        @if($file->type === 1)
                                            <div class="row justify-content-center mb-3">
                                                <img class="border border-dark" src="{{'/storage/'.$file->file}}" style="max-width:600px; max-height:300px;min-width:600px; min-height:300px;">
                                                {{-- File Caption --}}
                                                <div class="row justify-content-center">
                                                    <p class="card-text text-center">{{$file->caption}}</p>
                                                </div>
                                            </div>

                                        {{-- If the file is a PDF... --}}
                                        @elseif($file->type === 2)
                                            <div class="row justify-content-center mb-3">
                                                <iframe src="{{'/storage/'. $file->file}}#toolbar=0" width="100%" style="height:25vh;">
                                                </iframe>
                                                {{-- File Caption --}}
                                                <div class="row justify-content-center">
                                                    <p class="card-text text-center">{{$file->caption}}</p>
                                                </div>
                                            </div>
                                        @endif

                                        
                                    @endforeach
                                @else
                                    <p class="text-center card-text">No Files Found</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Remarks and Decision Buttons --}}
                <div class="col-4">
                    <form action="{{route('studentAccomplishment.submissionDecision',['accomplishmentUUID' => $accomplishment->accomplishment_uuid,]);}}" method="POST">
                        {{-- Remarks Card --}}
                        <div class="card mb-1 w-100">
                            <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Review Remarks</h5>
                            <small class="text-center">Include comments for possible changes for this submission to be approved.</small>
                            <div class="card-body">
                                <textarea class="form-control" id="remarks" name="remarks" placeholder="Start Review here..." rows="9" required></textarea>
                                @csrf
                            </div>
                        </div>

                        {{-- Decision Buttons --}}
                        <div class="card card-body text-center">
                            <div class="row mt-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-danger w-100 text-white" type="submit" name="decline" id="decline" value="decline">
                                        <i class="fas fa-times"></i> Decline
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-success w-100 text-white" type="submit" name="success" id="success" value="success">
                                        <i class="fas fa-check"></i> Approve for further Review
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
        	</div>

        	<hr>

            <div class="flex-row my-2 text-center">
                <a href="{{ route('studentAccomplishment.index') }}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-arrow-left"></i> Go Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
