@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h4 class="display-5 text-center">Accomplishment</h4>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('studentAccomplishment.index')}}" class="text-decoration-none">
                                @position_title('Officer')
                                Student Accomplishments
                                @elseposition_title('Member')
                                My Accomplishments
                                @endposition_title
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $accomplishment->title }}
                        </li>
                    </ol>
                </nav>
            </div>
            @position_title('Officer')
                @if($accomplishment->status == 1)
                    <div class="flex-row my-2 text-center">
                        <a href="{{route('studentAccomplishment.review', ['accomplishmentUUID' => $accomplishment->accomplishment_uuid])}}"
                            class="btn btn-primary text-white"
                            role="button">
                                Review this Accomplishment
                        </a>
                    </div>
                @endif
            @endposition_title
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-8">
                    <div class="card">
                        <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">{{ $accomplishment->title }}</h5>
                        <div class="card-body">
                        @if($accomplishment->status == 1)
                            <h6 class="text-center text-dark font-weight-bold"><span class="bg-warning rounded">Status: PENDING</span></h6>
                            <h3 class="card-title text-center"><span style="font-weight: bold;">Accomplishment Details</span>
                            </h3>
                            <h5 class="card-title"><span style="font-weight: bold;">Title:</span>
                                {{ $accomplishment->title }}
                            </h5>
                            <p class="card-text"><span style="font-weight: bold;">Description:</span>
                                {{ $accomplishment->description }}
                            </p>
                            <p class="card-text"><span style="font-weight: bold;">Objective:</span>
                                {{ $accomplishment->objective }}</p>
                            <p class="card-text">
                                <span style="font-weight: bold;">Organizer:</span> 
                                {{ $accomplishment->organizer }}
                            </p>
                            <p class="card-text">
                                <span style="font-weight: bold;">Venue:</span> 
                                {{ $accomplishment->venue }}
                            </p>
                            <p class="card-text">
                                <span style="font-weight: bold;">Date:</span> 
                                @if($accomplishment->start_date == $accomplishment->end_date){{date_format(date_create($accomplishment->start_date), 'F d, Y')}}
                                @else{{date_format(date_create($accomplishment->start_date), 'F d, Y') . ' - ' . date_format(date_create($accomplishment->end_date), 'F d, Y')}}
                                @endif
                            </p>
                            <p class="card-text">
                                <span style="font-weight: bold;">Time:</span>
                                @if($accomplishment->start_time == $accomplishment->end_time){{date_format(date_create($accomplishment->start_time), 'h:i A')}}
                                @else{{date_format(date_create($accomplishment->start_time), 'h:i A') . ' - ' . date_format(date_create($accomplishment->end_time), 'h:i A')}}
                                @endif
                            </p>
                            <hr>
                            <h3 class="card-title text-center"><span style="font-weight: bold;">Student Details</span>
                            </h3>
                            <div>
                                <p><span style="font-weight: bold;">Name:</span>
                                    {{ $accomplishment->student->last_name . ', ' . $accomplishment->student->first_name . ' ' . $accomplishment->student->middle_name }}
                                </p>
                                <p><span style="font-weight: bold;">Student Number:</span>
                                    {{ $accomplishment->student->student_number  }}
                                </p>
                                <p><span style="font-weight: bold;">Email:</span>
                                    {{ $accomplishment->student->email }}
                                </p>
                            </div>
                            <hr>
                            <h6 class="text-center text-dark font-weight-bold">Uploaded Evidences</h6>
                            
                        @elseif ($accomplishment->status == 2)
                            <h6 class="text-center text-white font-weight-bold"><span class="bg-success rounded">Status: APPROVED</span></h6>
                            <h3 class="card-title text-center"><span style="font-weight: bold;">Title:</span>
                                {{ $accomplishment->title }}
                            </h3>
                            <p class="card-text text-center"><span style="font-weight: bold;">Description:</span>
                                {{ $accomplishment->description }}
                            </p>
                            <p class="card-text text-center"><span style="font-weight: bold;">Objective:</span>
                                {{ $accomplishment->objective }}</p>
                            <p class="card-text text-center">
                                <span style="font-weight: bold;">Organizer:</span> {{ $accomplishment->organizer }}
                            </p>
                            <p class="card-text text-center">
                                <span style="font-weight: bold;">Venue:</span> {{ $accomplishment->venue }}
                            </p>
                            <p class="card-text text-center">
                                <span style="font-weight: bold;">Date:</span> 
                                @if($accomplishment->start_date == $accomplishment->end_date){{date_format(date_create($accomplishment->start_date), 'F d, Y')}}
                                @else{{date_format(date_create($accomplishment->start_date), 'F d, Y') . ' - ' . date_format(date_create($accomplishment->end_date), 'F d, Y')}}
                                @endif
                            </p>
                            <p class="card-text text-center">
                                <span style="font-weight: bold;">Time:</span>
                                @if($accomplishment->start_time == $accomplishment->end_time){{date_format(date_create($accomplishment->start_time), 'h:i A')}}
                                @else{{date_format(date_create($accomplishment->start_time), 'h:i A') . ' - ' . date_format(date_create($accomplishment->end_time), 'h:i A')}}
                                @endif
                            </p>
                            <p class="text-center">Level: {{ $accomplishment->level->level ?? 'NONE' }}</p>
                            <p class="text-center">Fund Source: {{ $accomplishment->fundSource->fund_source ?? 'NONE' }}</p>
                            <p class="text-center">Event: {{ $accomplishment->event->title ?? 'NONE' }}</p>
                            <hr>
                            <h3 class="card-title text-center"><span style="font-weight: bold;">Student Details</span>
                            </h3>
                            <div>
                                <p><span style="font-weight: bold;">Name:</span>
                                    {{ $accomplishment->student->last_name . ', ' . $accomplishment->student->first_name . ' ' . $accomplishment->student->middle_name }}
                                </p>
                                <p><span style="font-weight: bold;">Student Number:</span>
                                    {{ $accomplishment->student->student_number  }}
                                </p>
                                <p><span style="font-weight: bold;">Email:</span>
                                    {{ $accomplishment->student->email }}
                                </p>
                            </div>
                            <hr>
                            <h6 class="text-center text-dark font-weight-bold">Evidences</h6>

                        @elseif ($accomplishment->status == 3)
                            <h6 class="text-center text-white font-weight-bold"><span class="bg-danger rounded">Status: DISAPPROVED</span></h6>
                            <h3 class="card-title text-center"><span style="font-weight: bold;">Title:</span>
                                {{ $accomplishment->title }}
                            </h3>
                            <p class="card-text text-center"><span style="font-weight: bold;">Description:</span>
                                {{ $accomplishment->description }}
                            </p>
                            <p class="card-text text-center"><span style="font-weight: bold;">Objective:</span>
                                {{ $accomplishment->objective }}</p>
                            <p class="card-text text-center">
                                <span style="font-weight: bold;">Organizer:</span> {{ $accomplishment->organizer }}
                            </p>
                            <p class="card-text text-center">
                                <span style="font-weight: bold;">Venue:</span> {{ $accomplishment->venue }}
                            </p>
                            <p class="card-text text-center">
                                <span style="font-weight: bold;">Date:</span> 
                                @if($accomplishment->start_date == $accomplishment->end_date){{date_format(date_create($accomplishment->start_date), 'F d, Y')}}
                                @else{{date_format(date_create($accomplishment->start_date), 'F d, Y') . ' - ' . date_format(date_create($accomplishment->end_date), 'F d, Y')}}
                                @endif
                            </p>
                            <p class="card-text text-center">
                                <span style="font-weight: bold;">Time:</span>
                                @if($accomplishment->start_time == $accomplishment->end_time){{date_format(date_create($accomplishment->start_time), 'h:i A')}}
                                @else{{date_format(date_create($accomplishment->start_time), 'h:i A') . ' - ' . date_format(date_create($accomplishment->end_time), 'h:i A')}}
                                @endif
                            </p>
                            <hr>
                            <h3 class="card-title text-center"><span style="font-weight: bold;">Student Details</span>
                            </h3>
                            <div>
                                <p><span style="font-weight: bold;">Name:</span>
                                    {{ $accomplishment->student->last_name . ', ' . $accomplishment->student->first_name . ' ' . $accomplishment->student->middle_name }}
                                </p>
                                <p><span style="font-weight: bold;">Student Number:</span>
                                    {{ $accomplishment->student->student_number  }}
                                </p>
                                <p><span style="font-weight: bold;">Email:</span>
                                    {{ $accomplishment->student->email }}
                                </p>
                            </div>
                            <hr>
                            <p class="text-center">REMARKS</p>
                            <p class="text-center">{{ $accomplishment->remarks }}</p>
                            <hr>
                            <h6 class="text-center text-dark font-weight-bold">Uploaded Evidences</h6>
                            
                        @endif

                        @foreach($accomplishment->accomplishmentFiles as $file)
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
        	</div>
            @isset($newAccomplishment)
                @if($newAccomplishment)
                    <hr>
                    <div class="flex-row my-2 text-center">
                        <a href="{{route('studentAccomplishment.create')}}"
                            class="btn btn-secondary text-white"
                            role="button">
                                Create Another
                        </a>
                    </div>
                @endif
            @endisset

        	<hr>

            <div class="flex-row my-2 text-center">
                <a href="{{route('studentAccomplishment.index')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        Go Back
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
