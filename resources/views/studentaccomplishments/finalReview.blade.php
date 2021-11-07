@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h4 class="display-5 text-center">Final Review</h4>
                <p class="text-center">Final edits for the Accomplishment Submission</p>
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
                        <li class="breadcrumb-item">
                            <a href="{{route('studentAccomplishment.show' , ['accomplishmentUUID' => $accomplishment->accomplishment_uuid ])}}" class="text-decoration-none">
                                {{ $accomplishment->title }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Final Review
                        </li>
                    </ol>
                </nav>
            </div>
            
            <form action="{{route('studentAccomplishment.approveSubmission',['accomplishmentUUID' => $accomplishment->accomplishment_uuid,]);}}" method="POST" id="approvedSubmissionForm">   
            	<div class="row justify-content-center pb-1">
                    <div class="col-md-8">
                        <div class="card">
                            <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">{{ $accomplishment->title }}</h5>
                            <div class="card-body">
                            {{-- Accomplishment Details --}}
                                <h6 class="text-center text-dark font-weight-bold"><span class="bg-warning rounded">Accomplishment Details</span></h6>
                                <p class="text-center"><span class="fw-bold">TITLE: </span>{{ $accomplishment->title }}</p>
                                <p class="text-center"><span class="fw-bold">DESCRIPTION: </span>{{ $accomplishment->description }}</p>
                                <p class="text-center"><span class="fw-bold">OBJECTIVE: </span>{{ $accomplishment->objective }}</p>
                                <p class="text-center"><span class="fw-bold">ORGANIZER: </span>{{ $accomplishment->organizer }}</p>
                                <p class="text-center"><span class="fw-bold">VENUE: </span>{{ $accomplishment->venue }}</p>
                                <p class="text-center">
                                    <span class="fw-bold"> DATE: </span>
                                    @if($accomplishment->start_date == $accomplishment->end_date){{date_format(date_create($accomplishment->start_date), 'F d, Y')}}
                                    @else{{date_format(date_create($accomplishment->start_date), 'F d, Y') . ' - ' . date_format(date_create($accomplishment->end_date), 'F d, Y')}}
                                    @endif
                                </p>
                                <p class="text-center">
                                    <span class="fw-bold"> TIME: </span>
                                    @if($accomplishment->start_time == $accomplishment->end_time){{date_format(date_create($accomplishment->start_time), 'h:i A')}}
                                    @else{{date_format(date_create($accomplishment->start_time), 'h:i A') . ' - ' . date_format(date_create($accomplishment->end_time), 'h:i A')}}
                                    @endif
                                </p>

                                <hr>
                            {{-- Student Details --}}
                                <h6 class="text-center text-dark font-weight-bold"><span class="bg-warning rounded">Student Details</span></h6>
                                <div class="text-center">
                                    <p><span class="fw-bold">NAME: </span>{{ $accomplishment->student->last_name . ', ' . $accomplishment->student->first_name . ' ' . $accomplishment->student->middle_name }}</p>
                                    <p><span class="fw-bold">STUDENT NUMBER: </span>{{ $accomplishment->student->student_number  }}</p>
                                    <p><span class="fw-bold">EMAIL: </span>{{ $accomplishment->student->email }}</p>
                                </div>

                                <hr>
                            {{-- Activity Type --}}
                                <div class="form-group row my-1">
                                    <div class="col">
                                        <label for="activityType" class="col-form-label">Activity Type</label>
                                    </div>
                                    <div class="col">
                                        <input id="activityType" 
                                        type="text"
                                        class="form-control @error('activityType') is-invalid @enderror" 
                                        name="activityType"
                                        placeholder="Activity Type"  
                                        required
                                        value="{{ old('activityType') }}">
                                    </div>
                                </div>
                                @error('activityType')
                                <div class="row">
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </div>
                                @enderror
                            {{-- Beneficiaries --}}
                                <div class="form-group row my-1">
                                    <div class="col">
                                        <label for="beneficiaries" class="col-form-label">Beneficiaries</label>
                                    </div>
                                    <div class="col">
                                        <input id="beneficiaries" 
                                        type="text"
                                        class="form-control @error('beneficiaries') is-invalid @enderror" 
                                        name="beneficiaries"
                                        placeholder="Beneficiaries" 
                                        required
                                        value="{{ old('beneficiaries') }}">
                                    </div>
                                </div>
                                @error('beneficiaries')
                                <div class="row">
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </div>
                                @enderror
                            {{-- Budget --}}
                                <div class="form-group row my-1">
                                    <div class="col">
                                        <label for="budget" class="col-form-label">Budget</label>
                                    </div>
                                    <div class="col">
                                        <input id="budget" 
                                        type="number"
                                        min="0" 
                                        class="form-control @error('budget') is-invalid @enderror" 
                                        name="budget"
                                        placeholder="Leave blank if none"  
                                        value="{{ old('budget') }}">
                                    </div>
                                </div>
                                @error('budget')
                                <div class="row">
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </div>
                                @enderror
                            {{-- Fund Source --}}
                                <div class="form-group row my-1 border border-dark">
                                    <div class="col">
                                        <label for="radioFundSourceGroup" class="form-label @error('fundSource') text-danger @enderror">Who funded this Event/Accomplishment?</label>
                                    </div>
                                    <div class="col" id="radioFundSourceGroup">
                                        @foreach($fundSources as $source)
                                        <div class="form-check">
                                            <input type="radio" 
                                            id="{{$source->fund_source}}" 
                                            name="fundSource" 
                                            class="form-check-input" 
                                            value="{{$source->fund_source_id}}"
                                            required>
                                            <label class="form-check-label" for="{{$source->fund_source}}">{{$source->fund_source}}</label>
                                            <a role="button"
                                                data-toggle="popover" 
                                                title="{{$source->fund_source}}" 
                                                data-content="{{$source->helper}}">
                                                <i class="far fa-question-circle"></i>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('fundSource')
                                <div class="row text-center">
                                    <span class="d-block invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </div>
                                @enderror
                            {{-- Level --}}
                                <div class="form-group row justify-content-center my-1 border border-dark">
                                    <div class="col">
                                        <label for="radioLevelGroup" class="form-label @error('level') text-danger @enderror">Accomplishment Level</label>
                                    </div>
                                    <div class="col" id="radioLevelGroup">
                                        @foreach($levels as $level)
                                        <div class="form-check">
                                            <input type="radio" 
                                            id="{{$level->level}}" 
                                            name="level" 
                                            class="form-check-input" 
                                            value="{{$level->level_id}}"
                                            required>
                                            <label class="form-check-label" for="{{$level->level}}">{{$level->level}}</label>
                                            <a role="button"
                                                data-toggle="popover" 
                                                title="{{$level->level}}" 
                                                data-content="{{$level->helper}}">
                                                <i class="far fa-question-circle"></i>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('level')
                                <div class="row text-center">
                                    <span class="d-block invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </div>
                                @enderror
                            {{-- Related Event --}}
                                <div class="form-group row justify-content-center my-1 border border-dark">
                                    <div class="col">
                                        <label for="radioRelatedEventGroup" class="form-label @error('relatedEvent') text-danger @enderror">Related Event</label>
                                        <a role="button"
                                                data-toggle="popover" 
                                                title="Related Events" 
                                                data-content="These are similar Events based on the Accomplishment Title. Select the one that fits this Accomplishment. Leave unchecked if there is none.">
                                            <i class="far fa-question-circle"></i>
                                        </a>
                                    </div>
                                    <div class="col" id="radioRelatedEventGroup">
                                        @if($relatedEvents->count() > 0)
                                        @foreach($relatedEvents as $event)
                                        <div class="form-check">
                                            <input type="radio" 
                                            id="{{$event->title}}" 
                                            name="relatedEvent" 
                                            class="form-check-input" 
                                            value="{{$event->event_id}}">
                                            <label class="form-check-label" for="{{$event->title}}">{{$event->title . ' (' . $event->start_date . ')'}}</label>
                                            <a href="{{route('event.show', ['event_slug' => $event->slug])}}" role="button" target="_blank">(Go to Event)</a>
                                        </div>
                                        @endforeach
                                        @else
                                        <p>No Related Event Found.</p>
                                        @endif
                                    </div>
                                </div>
                                @error('relatedEvent')
                                <div class="row text-center">
                                    <span class="d-block invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </div>
                                @enderror
                                <hr>
                                <h5 class="text-center text-dark font-weight-bold">Uploaded Evidences</h5>
                                <h6 class="text-center">At least one evidence is required</h6>
                                @php $i = 1; @endphp
                                @foreach($accomplishment->accomplishmentFiles as $file)
                                <div class="row">
                                    <div class="form-check col text-center">
                                        <div>
                                            <h6>Evidence {{$i}}</h6>
                                        </div>
                                        @if($file->type == 1)
                                        {{-- IMG --}}
                                        <div>
                                            <img src="{{'/storage/'.$file->file}}" style="max-width:600; max-height:300px;min-width:600; min-height:300px;">
                                            <p class="text-center">CAPTION: {{$file->caption  ?? 'NONE' }}</p>
                                        </div>
                                        @elseif($file->type == 2)
                                        {{-- PDF --}}
                                        <div>
                                            <iframe src="{{'/storage/'.$file->file}}#toolbar=0" width="100%" style="height:25vh;">
                                            </iframe>
                                            <p class="text-center">CAPTION: {{$file->caption  ?? 'NONE' }}</p>
                                        </div>
                                        @endif
                                        <div class="d-flex flex-column align-items-center">
                                            <label for="{{'evidence' . $i}}" class="@error('evidence'.$i) text-danger @enderror form-check-label">Include this evidence on final?
                                            </label>
                                            <input type="checkbox" 
                                            class="form-check-input" 
                                            name="{{'evidence' . $i}}" 
                                            id="{{'evidence' . $i}}"
                                            style="top: 1.2rem; width: 1.85rem; height: 1.85rem;" 
                                            @if($i == 1) checked @endif 
                                            onchange="atLeastOneCheckboxIsChecked('evidence{{$i}}')"
                                            >

                                            @error('evidence'.$i)
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                @php $i += 1;@endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-1 w-100">
                            <div class="card-header card-title text-center bg-maroon text-white fw-bold">Review Remarks</div>
                            <small class="text-center">Include comments for possible improvement for this submission.</small>
                            <div class="card-body">
                                <textarea class="form-control" id="remarks" name="remarks" placeholder="Start Review here..." rows="9" required></textarea>
                            </div>
                        </div>
                        <div class="card card-body text-center">
                            <div class="row mt-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-danger w-100 text-white" type="submit" name="decline" id="decline" value="decline">Decline</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-success w-100 text-white" type="submit" name="success" id="success" value="success">Finalize Review</button>
                                </div>
                            </div>
                        </div>
                    </div>
            	</div>
                @csrf
            </form>
        	<hr>

            <div class="flex-row my-2 text-center">
                <a href="{{ route('studentAccomplishment.index') }}"
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
    <script type="text/javascript">
        function atLeastOneCheckboxIsChecked(checkboxId)
        {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
            console.log(checkboxId);
            if(!checkedOne)
            {
                alert ("Atleast one checkbox should be checked");
                document.getElementById(checkboxId).checked = true;
            }
        }
    </script>
    <script type="text/javascript">
        // Enable Bootstrap Popovers
        document.addEventListener("DOMContentLoaded", function(event) { 
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
              return new bootstrap.Popover(popoverTriggerEl)
            });
        });
    </script>
@endsection
