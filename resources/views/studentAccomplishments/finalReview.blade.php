@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Final Review</h2>
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
                            Final Review
                        </li>
                    </ol>
                </nav>
            </div>
            
            <form action="{{route('studentAccomplishment.approveSubmission',['accomplishmentUUID' => $accomplishment->accomplishment_uuid,]);}}" method="POST" id="approvedSubmissionForm"
                onsubmit="document.getElementById('success').disabled=true;document.getElementById('decline').disabled=true;">   
            	@csrf
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

                                <hr>

                                {{-- Fund Source --}}
                                <div class="form-group row my-1">
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
                                                data-bs-toggle="popover"
                                                data-bs-container="body" 
                                                data-bs-trigger="hover focus"
                                                data-bs-placement="right"
                                                title="{{$source->fund_source}}" 
                                                data-bs-content="{{$source->helper}}">
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

                                <hr>

                                {{-- Level --}}
                                <div class="form-group row justify-content-center my-1">
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
                                                data-bs-toggle="popover"
                                                data-bs-container="body" 
                                                data-bs-trigger="hover focus"
                                                data-bs-placement="right"
                                                title="{{$level->level}}" 
                                                data-bs-content="{{$level->helper}}">
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

                                <hr>

                                {{-- Related Event --}}
                                <div class="form-group row justify-content-center my-1">
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

                                {{-- Accomplishment Documents --}}
                                <div class="row">
                                    <p class="card-title text-center fw-bold">Uploaded Evidences</p>
                                    @if($accomplishment->accomplishmentFiles->count() > 0)
                                        @php $i = 1;@endphp
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

                                            {{-- Accomplishment Document Type --}}
                                            <div class="row">
                                                {{--select class="form-select" name="documentType{{$i}}">
                                                    @foreach($studentAccomplishmentDocumentTypes as $studentAccomplishmentDocumentType)

                                                        <option value="{{$studentAccomplishmentDocumentType->SA_document_type_id}}"
                                                            @if($studentAccomplishmentDocumentType->SA_document_type_id === $file->SA_document_type_id) selected @endif>
                                                            {{$studentAccomplishmentDocumentType->document_type}}
                                                        </option>
                                                    @endforeach
                                                </select>--}}
                                                <p class="text-center">
                                                    <span class="fw-bold">Document Type:</span>
                                                    {{ $file->documentType->document_type }}
                                                </p>
                                            </div>

                                            {{-- Accomplishment Document Checkbox --}}
                                            <div class="d-flex flex-column align-items-center mb-2">
                                                <label for="{{'evidence' . $i}}" class="@error('evidence'.$i) text-danger @enderror form-check-label">Include this evidence on final?
                                                </label>
                                                <input type="checkbox" 
                                                    class="form-check-input" 
                                                    name="{{'evidence' . $i}}" 
                                                    id="{{'evidence' . $i}}"
                                                    style="top: 1.2rem; width: 1.85rem; height: 1.85rem;" 
                                                    @if($i == 1) checked @endif 
                                                    onchange="atLeastOneCheckboxIsChecked('evidence{{$i}}')">
                                            </div>
                                            @error('evidence'.$i)
                                                <span class="invalid-feedback d-block" role="alert"></span>
                                            @enderror

                                            <hr>
                                        @php $i += 1;@endphp
                                        @endforeach
                                    @else
                                        <p class="text-center card-text">No Files Found</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Remarks and Decision Buttons --}}
                    <div class="col-md-4">
                        <div class="card mb-1 w-100">
                            <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Review Remarks</h5>
                            <small class="text-center">Include comments for possible improvement for this submission.<br>These changes are FINAL.</small>
                            <div class="card-body">
                                <textarea class="form-control" id="remarks" name="remarks" placeholder="Start Review here..." rows="9" required></textarea>
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
                                        <i class="fas fa-check"></i> Finalize Review
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            	</div>
                
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
    {{-- Enable Popovers --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap_related_js/enablePopover.js') }}"></script>
@endsection
