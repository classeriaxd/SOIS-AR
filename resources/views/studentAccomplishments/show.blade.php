@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Success Alert --}}
                @if (session()->has('success'))
                    <div class="flex-row text-center" id="success_alert">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            {{-- Error Alert --}}
                @if (session()->has('error'))
                    <div class="flex-row text-center" id="success_alert">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Student Accomplishments</h2>
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
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $accomplishment->title }}
                        </li>
                    </ol>
                </nav>
            </div>
            @role('AR Officer Admin')
                @if($accomplishment->status == 1)
                    <div class="flex-row my-2 text-center">
                        <a href="{{route('studentAccomplishment.review', ['accomplishmentUUID' => $accomplishment->accomplishment_uuid])}}"
                            class="btn btn-primary text-white"
                            role="button">
                                Review this Accomplishment
                        </a>
                    </div>
                @endif
            @endrole
        	<div class="row justify-content-center pb-1">
        		<div class="col">
                    <div class="card">
                        <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Accomplishment Details</h5>
                        <div class="card-body">

                            {{-- Title --}}
                            <h3 class="card-title text-center fw-bold">
                                {{ $accomplishment->title }}
                            </h3>

                            {{-- Status --}}
                            <div class="text-center my-1">
                                @if($accomplishment->status == 1)
                                    <span class="badge rounded-pill fs-6 bg-warning text-dark">Pending</span>
                                @elseif($accomplishment->status == 2)
                                    <span class="badge rounded-pill fs-6 bg-success text-white">Approved</span>
                                    <br>
                                    By: {{ $accomplishment->reviewer->full_name '(' . date_format(date_create($accomplishment->reviewed_at), 'F d, Y') . ')'}}
                                @elseif($accomplishment->status == 3)
                                    <span class="badge rounded-pill fs-6 bg-danger text-white">Disapproved</span>
                                    <br>
                                    By: {{ $accomplishment->reviewer->full_name . '(' . date_format(date_create($accomplishment->reviewed_at), 'F d, Y') . ')'}}
                                @endif
                            </div>
                            
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

                                    {{-- Additional Information if Approved --}}
                                    @if($accomplishment->status == 2)
                                        <p class="text-center">
                                            <span class="fw-bold">Level</span>
                                            {{ $accomplishment->level->level }}
                                        </p>
                                        <p class="text-center">
                                            <span class="fw-bold">Funding:</span>
                                            {{ $accomplishment->budget ?? ''}} 
                                            {{ $accomplishment->fundSource->fund_source }}
                                        </p>
                                        @if($accomplishment->event_id !== NULL)
                                            <p class="text-center">
                                                <span class="fw-bold">Event:</span>
                                                {{ $accomplishment->event->title }}
                                            </p>
                                        @endif
                                    @endif
                                </div>

                                {{-- Student Details Column --}}
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

                            {{-- Show Remarks if Disapproved --}}
                            @if($accomplishment->status == 3)
                                <hr>

                                <div class="row">
                                    <div class="col">
                                        <p class="card-title text-center fw-bold">REMARKS</p>
                                        <p class="text-center">{{ $accomplishment->remarks }}</p>
                                    </div>
                                </div>
                            @endif

                            {{-- Accomplishment Documents --}}
                            @if($accomplishment->accomplishmentFiles->count() > 0)
                                <hr>

                                <div class="row">
                                    @foreach($accomplishment->accomplishmentFiles as $file)
                                        
                                        {{-- If the file is an IMG... --}}
                                        @if($file->type == 1)
                                        
                                            <div class="row justify-content-center mb-2">
                                                <img src="{{'/storage/'.$file->file}}" style="max-width:600px; max-height:300px;min-width:600px; min-height:300px;" class="border border-dark">
                                                {{-- Document Type and File Caption --}}
                                                <div class="row justify-content-center">
                                                    <p class="text-center fw-bold">{{$file->documentType->document_type}}</p>
                                                    <p class="text-center">{{$file->caption}}</p>
                                                </div>
                                            </div>

                                        {{-- If the file is a PDF... --}}
                                        @elseif($file->type == 2)
                                            <div class="row justify-content-center mb-2">
                                                <iframe src="{{'/storage/'.$file->file}}#toolbar=0" width="100%" style="height:25vh;" class="border border-dark">
                                                </iframe>
                                                {{-- Document Type and File Caption --}}
                                                <div class="row justify-content-center">
                                                    <p class="text-center fw-bold">{{$file->documentType->document_type}}</p>
                                                    <p class="text-center">{{$file->caption}}</p>
                                                </div>
                                            </div>
                                        @endif

                                        
                                    @endforeach
                                </div>
                            @endif
                       
                        </div>
                    </div>
        		</div>
        	</div>

        	<hr>

            <div class="flex-row my-2 text-center">
                <a href="{{route('studentAccomplishment.index')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-arrow-left"></i> Go Back
                </a>

                @if($newAccomplishment)
                    <span>or</span>

                    <a href="{{route('studentAccomplishment.create')}}"
                        class="btn btn-primary text-white"
                        role="button">
                            <i class="fas fa-award"></i> Submit Another Accomplishment
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
