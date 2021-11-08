@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Title and Breadcrumbs --}}
    <div class="row">
        {{-- Title --}}
        <h4 class="display-5 text-center">New Event Report</h4>
        {{-- Breadcrumbs --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item">
                    <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{route('event.index')}}" class="text-decoration-none">Events</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Create
                </li>
            </ol>
        </nav>
    </div>

    {{-- Event Create Form --}}
    <form action="{{route('event.store')}}" enctype="multipart/form-data" method="POST" id="eventForm">
        <div class="row">
            <div class="col">
                {{-- Event "WHAT" --}}
                <div class="card mb-3">
                    <div class="card-header text-white bg-maroon">WHAT</div>
                    <div class="card-body">

                        {{-- Event Title --}}
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label">Title<span style="color:red">*</span></label>
                            <input id="title" 
                            type="text" 
                            class="form-control @error('title') is-invalid @enderror" 
                            name="title"
                            placeholder="Event Title" 
                            value="{{ old('title') }}" 
                            autofocus 
                            required>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Event Description --}}
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label">Description<span style="color:red">*</span></label>    
                            <textarea id="description" 
                            class="form-control @error('description') is-invalid @enderror" 
                            name="description"
                            placeholder="Description" 
                            required>{{ old('description')}}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Event Objective --}}
                        <div class="form-group row">
                            <label for="objective" class="col-md-4 col-form-label">Objective<span style="color:red">*</span></label>
                            <textarea id="objective" 
                            class="form-control @error('objective') is-invalid @enderror" 
                            name="objective" 
                            placeholder="Objective" 
                            required>{{ old('objective') }}</textarea>

                            @error('objective')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>    
                </div>

                    {{-- Event "WHERE" --}}
                    <div class="card">
                        <div class="card-header text-white bg-maroon ">WHERE</div>
                        <div class="card-body">

                            {{-- Event Venue --}}
                            <div class="form-group row">
                                <label for="venue" class="col-md-4 col-form-label">Venue<span style="color:red">*</span></label>
                                <input id="venue" 
                                type="text" 
                                class="form-control @error('venue') is-invalid @enderror" 
                                name="venue"
                                placeholder="Venue (Ex. Zoom or Facebook Live)"  
                                value="{{ old('venue') }}">

                                @error('venue')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Event Activity Type --}}
                            <div class="form-group row">
                                <label for="activityType" class="col-md-4 col-form-label">Type of Activity<span style="color:red">*</span></label>
                                <input id="activityType" 
                                type="text" 
                                class="form-control @error('activityType') is-invalid @enderror" 
                                name="activityType" 
                                placeholder="Type of Activity (Ex. Student Development-Intellectual)" 
                                value="{{ old('activityType') }}">

                                @error('activityType')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Event Beneficiaries --}}
                            <div class="form-group row">
                                    <label for="beneficiaries" class="col-md-4 col-form-label">Event Beneficiaries<span style="color:red">*</span></label>
                                    <input id="beneficiaries" 
                                    type="text" 
                                    class="form-control @error('beneficiaries') is-invalid @enderror" 
                                    name="beneficiaries" 
                                    placeholder="Beneficiaries (Ex. Students of PUP-Taguig Branch)" 
                                    value="{{ old('beneficiaries') }}">

                                    @error('beneficiaries')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            {{-- Total Event Beneficiaries --}}
                            <div class="form-group row">
                                <label for="totalBeneficiary" class="col-md-4 col-form-label">Number of Beneficiaries<span style="color:red">*</span></label>
                                <input id="totalBeneficiary" 
                                type="text" 
                                class="form-control @error('totalBeneficiary') is-invalid @enderror" 
                                name="totalBeneficiary" 
                                placeholder="Total Number of Beneficiaries. (Ex. 1000)" 
                                value="{{ old('totalBeneficiary') }}">

                                @error('totalBeneficiary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Event Sponsors --}}
                            <div class="form-group row">
                                <label for="sponsors" class="col-md-4 col-form-label">Sponsors<span style="color:red">*</span></label>
                                <input id="sponsors" 
                                type="text" 
                                class="form-control @error('sponsors') is-invalid @enderror" 
                                name="sponsors" 
                                placeholder="Sponsors" 
                                value="{{ old('sponsors') }}">

                                @error('sponsors')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>   

                            {{-- Event Budget --}}
                            <div class="form-group row">
                                <label for="budget" class="col-md-4 col-form-label">Event Budget<span style="color:red">*</span></label>
                                <input id="budget" 
                                type="text" 
                                class="form-control @error('budget') is-invalid @enderror" 
                                name="budget" 
                                placeholder="₱" 
                                value="{{ old('budget') }}">

                                @error('budget')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>    
                    </div>
                    {{-- Event "WHEN" --}}
                    <div class="card">
                        <div class="card-header text-white bg-maroon">WHEN</div>
                        <div class=card-body>

                            {{-- Event Date --}}
                            <div class="form-group row">
                                {{-- Start Date --}}
                                <div class="col">
                                    <label for="startDate" class="col-md-4 form-label">Start Date<span style="color:red">*</span></label>
                                    <input id="startDate" 
                                    type="date" 
                                    class="form-control @error('startDate') is-invalid @enderror" 
                                    name="startDate" 
                                    value="{{ old('startDate') }}" 
                                    min="1992-01-01" 
                                    max="{{date('Y-m-d')}}"
                                    required>
                                    @error('startDate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- End Date --}}
                                <div class="col">
                                    <label for="endDate" class="col-md-4 form-label">End Date<span style="color:red">*</span></label>
                                    <input id="endDate" 
                                    type="date" 
                                    class="form-control @error('endDate') is-invalid @enderror" 
                                    name="endDate" 
                                    value="{{ old('endDate') }}"
                                    min="1992-01-01" 
                                    max="{{date('Y-m-d')}}">
                                    @error('endDate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>  
                            </div>

                            {{-- Event Time --}}
                            <div class="form-group row">
                                {{-- Start Time --}}
                                <div class="col">
                                    <label for="startTime" class="col-md-4 col-form-label">Start Time<span style="color:red">*</span></label>
                                    <input id="startTime" 
                                    type="time" 
                                    class="form-control @error('startTime') is-invalid @enderror" 
                                    name="startTime" 
                                    value="{{ old('startTime') }}">
                                    @error('startTime')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- End Time --}}
                                <div class="col">
                                    <label for="endTime" class="col-md-4 col-form-label">End Time<span style="color:red">*</span></label>
                                    <input id="endTime" 
                                    type="time" 
                                    class="form-control @error('endTime') is-invalid @enderror" 
                                    name="endTime" 
                                    value="{{ old('endTime') }}">
                                    @error('endTime')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                    </div> 
                 </div>
            </div>

            <div class="col">
                              {{-- Event Fund Source --}}
                <div class="card">
            <div class="card-header text-white bg-maroon">CATEGORY</div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col">
                        <label for="radioFundSourceGroup" class="form-label @error('fundSource') text-danger @enderror">What was the Organization's Fund Source for this Event?<span style="color:red">*</span></label>
                    </div>
                        <div class="col" id="radioFundSourceGroup">
                            @foreach($fundSources as $source)
                            <div class="form-check">
                                <input type="radio" id="{{$source->fund_source}}" name="fundSource" class="form-check-input" value="{{$source->fund_source_id}}">
                                <label class="form-check-label" for="{{$source->fund_source}}">{{$source->fund_source}}</label>
                                <a role="button"
                                    data-bs-toggle="popover" 
                                    data-bs-container="body"
                                    data-bs-trigger="hover focus"
                                    title="{{$source->fund_source}}" 
                                    data-bs-content="{{$source->helper}}"
                                    data-bs-placement="right">
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

                {{-- Event Role --}}
                <div class="form-group row">
                    <div class="col">
                        <label for="radioEventRoleGroup" class="form-label @error('eventRole') text-danger @enderror">What was the Organization's Role in this Event?<span style="color:red">*</span></label></div>
                    <div class="col" id="radioEventRoleGroup">
                        @foreach($eventRoles as $role)
                        <div class="form-check">
                            <input type="radio" id="{{$role->event_role}}" name="eventRole" class="form-check-input" value="{{$role->event_role_id}}">
                            <label class="form-check-label" for="{{$role->event_role}}">{{$role->event_role}}</label>
                            <a role="button"
                                data-bs-toggle="popover"
                                data-bs-container="body" 
                                data-bs-trigger="hover focus"
                                title="{{$role->event_role}}" 
                                data-bs-content="{{$role->helper}}"
                                data-bs-placement="right">
                                <i class="far fa-question-circle"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @error('eventRole')
                    <div class="row text-center">
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror
                <hr>
                {{-- Event Category --}}
                <div class="form-group row">
                    <div class="col">
                        <label for="radioEventCategoryGroup" class="form-label @error('eventCategory') text-danger @enderror">Event Category<span style="color:red">*</span></label>
                    </div>
                    <div class="col" id="radioEventCategoryGroup">
                        @foreach($eventCategories as $category)
                        <div class="form-check">
                            <input type="radio" id="{{$category->category}}" name="eventCategory" class="form-check-input" value="{{$category->event_category_id}}">
                            <label class="form-check-label" for="{{$category->category}}">{{$category->category}}</label>
                            <a role="button"
                                data-bs-toggle="popover"
                                data-bs-container="body" 
                                data-bs-trigger="hover focus"
                                title="{{$category->category}}" 
                                data-bs-content="{{$category->helper}}"
                                data-bs-placement="right">
                                <i class="far fa-question-circle"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @error('eventCategory')
                    <div class="row text-center">
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror

                <hr>

                {{-- Event Classification --}}
                <div class="form-group row">
                    <div class="col">
                        <label for="radioEventClassificationGroup" class="form-label @error('eventClassification') text-danger @enderror">Event Classification<span style="color:red">*</span></label>
                    </div>
                    <div class="col" id="radioEventClassificationGroup">
                        @foreach($eventClassifications as $classification)
                        <div class="form-check">
                            <input type="radio" id="{{$classification->classification}}" name="eventClassification" class="form-check-input" value="{{$classification->event_classification_id}}">
                            <label class="form-check-label" for="{{$classification->classification}}">{{$classification->classification}}</label>
                            <a role="button"
                                data-bs-toggle="popover"
                                data-bs-container="body" 
                                data-bs-trigger="hover focus"
                                title="{{$classification->classification}}" 
                                data-bs-content="{{$classification->helper}}"
                                data-bs-placement="right">
                                <i class="far fa-question-circle"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @error('eventClassification')
                    <div class="row text-center">
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror

                <hr>

                {{-- Event Natures --}}
                <div class="form-group row">
                    <div class="col">
                        <label for="radioEventNatureGroup" class="form-label @error('eventNature') text-danger @enderror">Event Nature<span style="color:red">*</span></label>
                    </div>
                    <div class="col" id="radioEventNatureGroup">
                        @foreach($eventNatures as $nature)
                        <div class="form-check">
                            <input type="radio" id="{{$nature->nature}}" name="eventNature" class="form-check-input" value="{{$nature->event_nature_id}}">
                            <label class="form-check-label" for="{{$nature->nature}}">{{$nature->nature}}</label>
                            <a role="button"
                                data-bs-toggle="popover"
                                data-bs-container="body" 
                                data-bs-trigger="hover focus"
                                title="{{$nature->nature}}" 
                                data-bs-content="{{$nature->helper}}"
                                data-bs-placement="right">
                                <i class="far fa-question-circle"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @error('eventNature')
                    <div class="row text-center">
                        <span class="d-block invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror

                <hr>

                {{-- Event Level --}}
                <div class="form-group row">
                    <div class="col">
                        <label for="radioLevelGroup" class="form-label @error('level') text-danger @enderror">Level<span style="color:red">*</span></label></div>
                    <div class="col" id="radioLevelGroup">
                        @foreach($levels as $level)
                        <div class="form-check">
                            <input type="radio" id="{{$level->level}}" name="level" class="form-check-input" value="{{$level->level_id}}">
                            <label class="form-check-label" for="{{$level->level}}">{{$level->level}}</label>
                            <a role="button"
                                data-bs-toggle="popover"
                                data-bs-container="body" 
                                data-bs-trigger="hover focus"
                                title="{{$level->level}}" 
                                data-bs-content="{{$level->helper}}"
                                data-bs-placement="right">
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
            </div>
        </div>
           <div class="flex-row my-2 text-center">
            @csrf
            <button class="btn btn-primary text-white col-md-12" type="submit">Add Event</button>
        </div>      
    </form>

    <hr>

    <div class="flex-row my-1 text-center">
        <a href="{{route('home')}}"
            class="btn btn-secondary text-white col-md-12"
            role="button">
            Go Home
        </a>
    </div>

</div>
@endsection

@section('scripts')
    {{-- Enable Popovers --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap_related_js/enablePopover.js') }}"></script>
@endsection
