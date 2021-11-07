<form action="{{route('event.update', ['event_slug' => $event->slug])}}" enctype="multipart/form-data" method="PATCH">

@extends('layouts.app')

@section('content')

<div class="container">
    <form action="/e/{{ $event->slug }}" enctype="multipart/form-data" method="POST">
	@csrf
	@method('PATCH')
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
    
    <div class="row">
    	<div class="col" >
			
	        <div class="card mb-3">
	            <div class="card-header text-white bg-maroon">WHAT</div>
	            <div class="card-body">
	                <div class="form-group row">
		                <label for="title" class="col-md-4 col-form-label">Title</label>
		                <input id="title" 
		                type="text" 
		                class="form-control @error('title') is-invalid @enderror" 
		                name="title" 
		                value="{{ $event->title }}" 
		                autofocus>
		                @error('title')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                @enderror
	            	</div>
	            	<div class="form-group row">
		            	<label for="description" class="col-md-4 col-form-label">Description</label>    
		            	<textarea id="description" class="form-control @error('description') is-invalid @enderror" 
		            	name="description">{{ $event->description }}</textarea>
		            	@error('description')
		            	    <span class="invalid-feedback" role="alert">
		            	        <strong>{{ $message }}</strong>
		            	    </span>
		            	@enderror
	            	</div>
	            	<div class="form-group row">
		            	<label for="objective" class="col-md-4 col-form-label">Objective</label>
		            	<textarea id="objective" 
		            	class="form-control 
		            	@error('objective') is-invalid @enderror" 
		            	name="objective">{{ $event->objective }}</textarea>
		            	@error('objective')
		            	    <span class="invalid-feedback" role="alert">
		            	        <strong>{{ $message }}</strong>
		            	    </span>
		            	@enderror
	            	</div>
	        	</div>    
	    	</div> <!-- end of WHAT card-->
	        <div class="card">
                <div class="card-header text-white bg-maroon ">WHERE</div>
                <div class="card-body">
		            <div class="form-group row">
		                <label for="venue" class="col-md-4 col-form-label">Venue</label>
		                <input id="venue" 
		                type="text" 
		                class="form-control @error('venue') is-invalid @enderror" 
		                name="venue" 
		                value="{{ $event->venue }}">
		                @error('venue')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                @enderror
		            </div>
		            <div class="form-group row">
		                <label for="activityType" class="col-md-4 col-form-label">Type of Activity</label>
		                <input id="activityType" 
		                type="text" 
		                class="form-control @error('activityType') is-invalid @enderror" 
		                name="activityType" 
		                value="{{ $event->activity_type }}">
		                @error('activityType')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                @enderror
		            </div>
		            <div class="form-group row">
		                <label for="beneficiaries" class="col-md-4 col-form-label">Event Beneficiaries</label>
		                <input id="beneficiaries" 
		                type="text" 
		                class="form-control @error('beneficiaries') is-invalid @enderror" 
		                name="beneficiaries" 
		                value="{{ $event->beneficiaries }}">
		                @error('beneficiaries')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                @enderror
		            </div>
		            <div class="form-group row">
		                <label for="totalBeneficiary" class="col-md-4 col-form-label">Number of Beneficiaries</label>
		                <input id="totalBeneficiary" 
		                type="text" 
		                class="form-control @error('totalBeneficiary') is-invalid @enderror" 
		                name="totalBeneficiary" 
		                placeholder="Total Number of Beneficiaries. (Ex. 1000)" 
		                value="{{ $event->total_beneficiary }}">
		                @error('totalBeneficiary')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                @enderror
		            </div>
		            <div class="form-group row">
		                <label for="sponsors" class="col-md-4 col-form-label">Sponsors</label>
		                <input id="sponsors" 
		                type="text" 
		                class="form-control @error('sponsors') is-invalid @enderror" 
		                name="sponsors" 
		                value="{{ $event->sponsors }}">
		                @error('sponsors')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                @enderror
		            </div>
		            <div class="form-group row">
		                <label for="budget" class="col-md-4 col-form-label">Event Budget</label>
		                <input id="budget" 
		                type="text" 
		                class="form-control @error('budget') is-invalid @enderror" 
		                name="budget" 
		                value="{{ $event->budget }}">
		                @error('budget')
		                    <span class="invalid-feedback" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                @enderror
                    </div>
                </div>
            </div>
    	</div> <!-- end 1st col -->
    	<div class="col">
    		<div class="card">
                <div class="card-header text-white bg-maroon">WHEN</div>
                <div class=card-body>
	            <div class="form-group row">
	                <div class="col">
	                    <label for="startDate" class="col-md-4 form-label">Start Date</label>
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
	                <div class="col">
	                    <label for="endDate" class="col-md-4 form-label">End Date</label>
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
	            <div class="form-group row">
	                <div class="col form-group">
	                    <label for="startTime" class="col-md-4 col-form-label">Start Time</label>
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
	                <div class="col form-group">
	                    <label for="endTime" class="col-md-4 col-form-label">End Time</label>
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
			<div class="card">
            <div class="card-header text-white bg-maroon">CATEGORY</div>
            <div class="card-body">
				<div class="form-group row">
					<div class="col">
						<label for="radioFundSourceGroup" class="form-label @error('fundSource') text-danger @enderror">What was the Organization's Fund Source for this Event?</label>
					</div>
					<div class="col" id="radioFundSourceGroup">
						@foreach($fundSources as $source)
						<div class="form-check">
							<input type="radio" 
							id="{{$source->fund_source}}" 
							name="fundSource" 
							class="form-check-input" 
							value="{{$source->fund_source_id}}"
							@if($event->fund_source_id == $source->fund_source_id) checked @endif
							>
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
				<hr>
				<div class="form-group row">
					<div class="col">
						<label for="radioEventRoleGroup" class="form-label">What was the Organization's Role in this Event?</label></div>
					<div class="col" id="radioEventRoleGroup">
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
								data-toggle="popover" 
								title="{{$role->event_role}}" 
								data-content="{{$role->helper}}">
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
				<div class="form-group row">
					<div class="col">
						<label for="radioEventCategoryGroup" class="form-label">Event Category</label>
					</div>
					<div class="col" id="radioEventCategoryGroup">
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
								data-toggle="popover" 
								title="{{$category->category}}" 
								data-content="{{$category->helper}}">
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
				<div class="form-group row">
					<div class="col">
						<label for="radioLevelGroup" class="form-label @error('level') text-danger @enderror">Level</label></div>
					<div class="col" id="radioLevelGroup">
						@foreach($levels as $level)
						<div class="form-check">
							<input type="radio" 
							id="{{$level->level}}" 
							name="level" c
							lass="form-check-input" 
							value="{{$level->level_id}}"
							@if($event->level_id  == $level->level_id) checked @endif>
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
				<!--DIV-->
				@error('level')
				<div class="row text-center">
					<span class="d-block invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				</div>
			<!--/div-->
				@enderror
			</div>
		</div>
    	</div>
    </div>
    
	<hr>

    <div class="flex-row my-2 text-center">
    	<button class="btn btn-primary text-white">Finalize Edit</button>
    </div>

	</form>
	<hr>

	<div class="flex-row my-1 text-center">
	    <a href="{{route('event.show', ['event_slug' => $event->slug])}}"
	        class="btn btn-secondary text-white"
	        role="button">
	        Go Home
	    </a>
	</div>

</div> <!--/*end of container*/-->
@endsection
@section('scripts')
    <script type="text/javascript">
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
          return new bootstrap.Popover(popoverTriggerEl)
        })
        $('body').on('click', function (e) {
            $('[data-bs-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
    </script>
@endsection
