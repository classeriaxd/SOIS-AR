@extends('layouts.app')

@section('content')
<div class="container-fluid">
	{{-- Title and Breadcrumbs --}}
    <div class="row">
    	{{-- Title --}}
    	<h4 class="display-5 text-center">Edit Event</h4>
    	<p class="text-center">{{ $event->title }}</p>
    	{{-- Breadcrumbs --}}
	    <nav aria-label="breadcrumb">
	        <ol class="breadcrumb justify-content-center">
	            <li class="breadcrumb-item">
	                <a href="{{route('home')}}" class="text-decoration-none">Home</a>
	            </li>
	            <li class="breadcrumb-item">
	                <a href="{{route('event.index')}}" class="text-decoration-none">Events</a>
	            </li>
	            <li class="breadcrumb-item">
	                <a href="{{route('event.show', ['event_slug' => $event->slug])}}" class="text-decoration-none">{{ $event->title }}</a>
	            </li>
	            <li class="breadcrumb-item active" aria-current="page">
	                Edit
	            </li>
	        </ol>
	    </nav>
    </div>
    <form action="{{route('event.update', ['event_slug' => $event->slug])}}" enctype="multipart/form-data" method="POST" id="eventUpdateForm">
		@csrf
		@method('PATCH')
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
                            value="{{ $event->title }}" 
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
                            required>{{ $event->objective }}</textarea>

                            @error('objective')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>    
                </div>

                    {{-- Event "WHERE" --}}
                    <div class="card mb-3">
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
                                value="{{ $event->venue }}">

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
                                value="{{ $event->activityType }}">

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
                                    value="{{ $event->beneficiaries }}">

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
                                value="{{ $event->totalBeneficiary }}">

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
                                value="{{ $event->sponsors }}">

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
                                value="{{ $event->budget }}">

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
                                    value="{{ $event->start_date }}" 
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
                                    value="{{ $event->end_date }}"
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
                                    value="{{ date("H:i",strtotime($event->start_time)) }}">
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
                                    value="{{ date("H:i",strtotime($event->end_time)) }}">
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
            {{-- Event Radio Buttons --}}
            <div class="col">
                              {{-- Event Fund Source --}}
                <div class="card">
            <div class="card-header text-white bg-maroon">CATEGORY</div>
            <div class="card-body">
            {{-- Event Fund Source Radio Buttons --}}
                <div class="form-group row">
                    <div class="col">
                        <label for="radioFundSourceGroup" class="form-label @error('fundSource') text-danger @enderror">What was the Organization's Fund Source for this Event?<span style="color:red">*</span></label>
                    </div>
                        <div class="col" id="radioFundSourceGroup">
                        @if($event->eventFundSource->deleted_at === NULL)
		                    @foreach($fundSources as $fundSource)
			                    <div class="form-check">
			                        <input type="radio" 
			                        id="{{$fundSource->fund_source}}" 
			                        name="fundSource" 
			                        class="form-check-input" 
			                        value="{{$fundSource->fund_source_id}}" 
			                        @if($event->fund_source_id == $fundSource->fund_source_id) checked @endif>
			                        <label class="form-check-label" for="{{$fundSource->fund_source}}">{{$fundSource->fund_source}}</label>
			                        <a role="button"
			                            data-bs-toggle="popover"
			                            data-bs-container="body" 
			                            data-bs-trigger="hover focus"
			                            title="{{$fundSource->fund_source}}" 
			                            data-bs-content="{{$fundSource->helper}}"
			                            data-bs-placement="right">
			                            <i class="far fa-question-circle"></i>
			                        </a>
			                    </div>
		                    @endforeach

		                {{-- Show Deleted and Other Event Fund Sources --}}
	                    @else
		                	{{-- Show Deleted Fund Source --}}
		                    <div class="form-check text-danger">
		                    	<input type="radio" 
		                    	id="{{$event->eventFundSource->fund_source}}" 
		                    	name="fundSource" 
		                    	class="form-check-input" 
		                    	value="{{$event->fund_source_id}}" 
		                    	checked>
		                    	<label class="form-check-label blink" for="{{$event->eventFundSource->fund_source}}">{{$event->eventFundSource->fund_source}}</label>
		                    	<a role="button"
	                    	        data-bs-toggle="popover"
		                            data-bs-container="body" 
		                            data-bs-trigger="hover focus"
		                    	    title="{{$event->eventFundSource->fund_source}}" 
		                    	    data-bs-content="{{$event->eventFundSource->helper . '.' . ' <b>This fund source has been deleted since ' . date_format(date_create($event->eventFundSource->deleted_at), 'F d, Y') . '.</b>'}}"
		                    	    data-bs-html="true"
		                    	    data-bs-placement="right">
		                    	    <i class="far fa-question-circle"></i>
		                    	</a>
		                    </div>

		                	{{-- Show Other Fund Sources --}}
		                    @foreach($fundSources as $fundSource)
			                    <div class="form-check">
			                        <input type="radio" 
			                        id="{{$fundSource->fund_source}}" 
			                        name="fundSource" 
			                        class="form-check-input" 
			                        value="{{$fundSource->fund_source_id}}">
			                        <label class="form-check-label" for="{{$fundSource->fund_source}}">{{$fundSource->fund_source}}</label>
			                        <a role="button"
			                            data-bs-toggle="popover"
			                            data-bs-container="body" 
			                            data-bs-trigger="hover focus"
			                            title="{{$fundSource->fund_source}}" 
			                            data-bs-content="{{$fundSource->helper}}"
			                            data-bs-placement="right">
			                            <i class="far fa-question-circle"></i>
			                        </a>
			                    </div>
		                    @endforeach

	                    @endif
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

				{{-- Event Role Radio Buttons --}}
	            <div class="form-group row">
	                <div class="col">
	                    <label for="radioEventRoleGroup" class="form-label">What was the Organization's Role in this Event?</label></div>
	                <div class="col" id="radioEventRoleGroup">
	                	{{-- Show Event Roles --}}
	                	@if($event->eventRole->deleted_at === NULL)
		                    @foreach($eventRoles as $role)

		                    <div class="form-check">
		                        <input type="radio" 
		                        id="{{$role->event_role}}" 
		                        name="eventRole" 
		                        class="form-check-input" 
		                        value="{{$role->event_role_id}}" 
		                        @if($event->event_role_id  == $role->event_role_id) checked @endif>
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

		                {{-- Show Deleted and Other Event Roles --}}
	                    @else
		                    {{-- Show Deleted Event Role --}}
		                    <div class="form-check text-danger">
		                    	<input type="radio" 
		                    	id="{{$event->eventRole->event_role}}" 
		                    	name="eventRole" 
		                    	class="form-check-input" 
		                    	value="{{$event->event_role_id}}" 
		                    	checked>
		                    	<label class="form-check-label blink" for="{{$event->eventRole->event_role}}">{{$event->eventRole->event_role}}</label>
		                    	<a role="button"
	                    	        data-bs-toggle="popover"
		                            data-bs-container="body"  
		                            data-bs-trigger="hover focus"
		                    	    title="{{$event->eventRole->event_role}}" 
		                    	    data-bs-content="{{$event->eventRole->helper . '.' . ' <b>This role has been deleted since ' . date_format(date_create($event->eventRole->deleted_at), 'F d, Y') . '.</b>'}}"
		                    	    data-bs-html="true"
		                    	    data-bs-placement="right">
		                    	    <i class="far fa-question-circle"></i>
		                    	</a>
		                    </div>

		                    {{-- Show Other Event Roles --}}
		                    @foreach($eventRoles as $role)
			                    <div class="form-check">
			                        <input type="radio" 
			                        id="{{$role->event_role}}" 
			                        name="eventRole" 
			                        class="form-check-input" 
			                        value="{{$role->event_role_id}}">
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

	                    @endif                    
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

				{{-- Event Category Radio Buttons --}}
	            <div class="form-group row">
	                <div class="col">
	                    <label for="radioEventCategoryGroup" class="form-label">Event Category</label>
	                </div>
	                <div class="col" id="radioEventCategoryGroup">

	                	{{-- Show Event Categories --}}
	                	@if($event->eventCategory->deleted_at === NULL)
		                    @foreach($eventCategories as $category)
			                    <div class="form-check">
			                        <input type="radio" 
			                        id="{{$category->category}}" 
			                        name="eventCategory" 
			                        class="form-check-input" 
			                        value="{{$category->event_category_id}}" 
			                        @if($event->event_category_id  == $category->event_category_id) checked @endif>
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

		                {{-- Show Deleted and Other Event Categories --}}
	                    @else
		                    {{-- Show Deleted Category --}}
		                    <div class="form-check text-danger">
		                    	<input type="radio" 
		                    	id="{{$event->eventCategory->category}}" 
		                    	name="eventCategory" 
		                    	class="form-check-input" 
		                    	value="{{$event->event_category_id}}" 
		                    	checked>
		                    	<label class="form-check-label blink" for="{{$event->eventCategory->category}}">{{$event->eventCategory->category}}</label>
		                    	<a role="button"
	                    	        data-bs-toggle="popover"
		                            data-bs-container="body"  
		                            data-bs-trigger="hover focus"
		                    	    title="{{$event->eventCategory->category}}" 
		                    	    data-bs-content="{{$event->eventCategory->helper . '.' . ' <b>This category has been deleted since ' . date_format(date_create($event->eventCategory->deleted_at), 'F d, Y') . '.</b>'}}"
		                    	    data-bs-html="true"
		                    	    data-bs-placement="right">
		                    	    <i class="far fa-question-circle"></i>
		                    	</a>
		                    </div>

		                    {{-- Show Other Categories --}}
		                    @foreach($eventCategories as $category)
			                    <div class="form-check">
			                        <input type="radio" 
			                        id="{{$category->category}}" 
			                        name="eventCategory" 
			                        class="form-check-input" 
			                        value="{{$category->event_category_id}}">
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

	                    @endif
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

				{{-- Event Classification Radio Buttons --}}
	            <div class="form-group row">
	                <div class="col">
	                    <label for="radioEventClassificationGroup" class="form-label">Event Classification</label>
	                </div>
	                <div class="col" id="radioEventClassificationGroup">

	                	{{-- Show Event Classifications --}}
	                	@if($event->eventClassification->deleted_at === NULL)
		                    @foreach($eventClassifications as $classification)
			                    <div class="form-check">
			                        <input type="radio" 
			                        id="{{$classification->classification}}" 
			                        name="eventClassification" 
			                        class="form-check-input" 
			                        value="{{$classification->event_classification_id}}" 
			                        @if($event->event_classification_id  == $classification->event_classification_id) checked @endif>
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

		                {{-- Show Deleted and Other Event Classifications --}}
	                    @else
		                    {{-- Show Deleted Classification --}}
		                    <div class="form-check text-danger">
		                    	<input type="radio" 
		                    	id="{{$event->eventClassification->classification}}" 
		                    	name="eventClassification" 
		                    	class="form-check-input" 
		                    	value="{{$event->event_classification_id}}" 
		                    	checked>
		                    	<label class="form-check-label blink" for="{{$event->eventClassification->classification}}">{{$event->eventClassification->classification}}</label>
		                    	<a role="button"
	                    	        data-bs-toggle="popover"
		                            data-bs-container="body"  
		                            data-bs-trigger="hover focus"
		                    	    title="{{$event->eventClassification->classification}}" 
		                    	    data-bs-content="{{$event->eventClassification->helper . '.' . ' <b>This classification has been deleted since ' . date_format(date_create($event->eventClassification->deleted_at), 'F d, Y') . '.</b>'}}"
		                    	    data-bs-html="true"
		                    	    data-bs-placement="right">
		                    	    <i class="far fa-question-circle"></i>
		                    	</a>
		                    </div>

		                    {{-- Show Other Classifications --}}
		                    @foreach($eventClassifications as $classification)
			                    <div class="form-check">
			                        <input type="radio" 
			                        id="{{$classification->classification}}" 
			                        name="eventClassification" 
			                        class="form-check-input" 
			                        value="{{$classification->event_classification_id}}">
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

	                    @endif
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

				{{-- Event Nature Radio Buttons --}}
	            <div class="form-group row">
	                <div class="col">
	                    <label for="radioEventNatureGroup" class="form-label">Event Nature</label>
	                </div>
	                <div class="col" id="radioEventNatureGroup">

	                	{{-- Show Event Natures --}}
	                	@if($event->eventNature->deleted_at === NULL)
		                    @foreach($eventNatures as $nature)
			                    <div class="form-check">
			                        <input type="radio" 
			                        id="{{$nature->nature}}" 
			                        name="eventNature" 
			                        class="form-check-input" 
			                        value="{{$nature->event_nature_id}}" 
			                        @if($event->event_nature_id  == $nature->event_nature_id) checked @endif>
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

		                {{-- Show Deleted and Other Event Natures --}}
	                    @else
		                    {{-- Show Deleted Nature --}}
		                    <div class="form-check text-danger">
		                    	<input type="radio" 
		                    	id="{{$event->eventNature->nature}}" 
		                    	name="eventNature" 
		                    	class="form-check-input" 
		                    	value="{{$event->event_nature_id}}" 
		                    	checked>
		                    	<label class="form-check-label blink" for="{{$event->eventNature->nature}}">{{$event->eventNature->nature}}</label>
		                    	<a role="button"
	                    	        data-bs-toggle="popover"
		                            data-bs-container="body"  
		                            data-bs-trigger="hover focus"
		                    	    title="{{$event->eventNature->nature}}" 
		                    	    data-bs-content="{{$event->eventNature->helper . '.' . ' <b>This nature has been deleted since ' . date_format(date_create($event->eventNature->deleted_at), 'F d, Y') . '.</b>'}}"
		                    	    data-bs-html="true"
		                    	    data-bs-placement="right">
		                    	    <i class="far fa-question-circle"></i>
		                    	</a>
		                    </div>

		                    {{-- Show Other Natures --}}
		                    @foreach($eventNatures as $nature)
			                    <div class="form-check">
			                        <input type="radio" 
			                        id="{{$nature->nature}}" 
			                        name="eventNature" 
			                        class="form-check-input" 
			                        value="{{$nature->event_nature_id}}">
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

	                    @endif
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

	            {{-- Event Level Radio Buttons --}}
	            <div class="form-group row">
	                <div class="col">
	                    <label for="radioLevelGroup" class="form-label @error('level') text-danger @enderror">Level</label></div>
	                <div class="col" id="radioLevelGroup">

	                	{{-- Show Levels --}}
	                	@if($event->eventLevel->deleted_at === NULL)
		                    @foreach($levels as $level)
			                    <div class="form-check">
			                        <input type="radio" 
			                        id="{{$level->level}}" 
			                        name="level" 
			                        class="form-check-input" 
			                        value="{{$level->level_id}}" 
			                        @if($event->level_id  == $level->level_id) checked @endif>
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

		                {{-- Show Deleted and Other Event Levels --}}
	                    @else
		                	{{-- Show Deleted Level --}}
		                    <div class="form-check text-danger">
		                    	<input type="radio" 
		                    	id="{{$event->eventLevel->level}}" 
		                    	name="level" 
		                    	class="form-check-input" 
		                    	value="{{$event->level_id}}" 
		                    	checked>
		                    	<label class="form-check-label blink" for="{{$event->eventLevel->level}}">{{$event->eventLevel->level}}</label>
		                    	<a role="button"
	                    	        data-bs-toggle="popover"
		                            data-bs-container="body" 
		                            data-bs-trigger="hover focus"
		                    	    title="{{$event->eventLevel->level}}" 
		                    	    data-bs-content="{{$event->eventLevel->helper . '.' . ' <b>This level has been deleted since ' . date_format(date_create($event->eventLevel->deleted_at), 'F d, Y') . '.</b>'}}"
		                    	    data-bs-html="true"
		                    	    data-bs-placement="right">
		                    	    <i class="far fa-question-circle"></i>
		                    	</a>
		                    </div>

		                	{{-- Show Other Levels --}}
		                    @foreach($levels as $level)
			                    <div class="form-check">
			                        <input type="radio" 
			                        id="{{$level->level}}" 
			                        name="level" 
			                        class="form-check-input" 
			                        value="{{$level->level_id}}">
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

	                    @endif
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
	    	<button class="btn btn-primary text-white col-md-12">Finalize Edit</button>
	    </div>
</form>
	    <div class="flex-row my-2 text-center">
	    <a href="{{route('event.show', ['event_slug' => $event->slug])}}"
	        class="btn btn-secondary text-white col-md-12"
	        role="button">
	        Go Back
	    </a>
	</div>
</div>
@endsection

@section('scripts')
    {{-- Enable Popovers --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap_related_js/enablePopover.js') }}"></script>

    <style type="text/css">
    	/* For Blinking */
    	.blink {
    	  animation: blinker 1s linear infinite;
    	}

    	@keyframes blinker {
    	  50% { 
    	  	opacity: 0;
    	  }
    	}
    </style>
@endsection
