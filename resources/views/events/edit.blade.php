@extends('layouts.app')

@section('content')
<div class="container">
	<form action="/e/{{ $event->slug }}" enctype="multipart/form-data" method="POST">
	    @csrf
	    @method('PATCH')
	    <div class="row">
	        <div class="col-8 offset-2">
	            <h2 class="display-3 text-center">Edit Event</h2>
	            <div class="form-group row">
	                <label for="title" class="col-md-4 col-form-label">Title</label>
	                <input id="title" 
	                type="text" 
	                class="form-control @error('title') is-invalid @enderror" 
	                name="title" 
	                value="{{ old('title') ?? $event->title }}" autofocus>
	                @error('title')
	                    <span class="invalid-feedback" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>
	                @enderror
	            </div>
	            <div class="form-group row">
	            	<label for="description" class="col-md-4 col-form-label">Description</label>    
	            	<textarea id="description" class="form-control @error('description') is-invalid @enderror" 
	            	name="description">{{ old('description') ?? $event->description }}</textarea>
	            	@error('description')
	            	    <span class="invalid-feedback" role="alert">
	            	        <strong>{{ $message }}</strong>
	            	    </span>
	            	@enderror
	            </div>
	            <div class="form-group row">
	            	<label for="objective" class="col-md-4 col-form-label">Objective</label>
	            	<textarea id="objective" class="form-control @error('objective') is-invalid @enderror" name="objective">{{ old('objective') ?? $event->objective }}</textarea>
	            	@error('objective')
	            	    <span class="invalid-feedback" role="alert">
	            	        <strong>{{ $message }}</strong>
	            	    </span>
	            	@enderror
	            </div>
	            <div class="form-group row">
	                <div class="col">
	                    <label for="start_date" class="col-md-4 form-label">Start Date</label>
	                    <input id="start_date" 
	                    type="date" 
	                    class="form-control @error('start_date') is-invalid @enderror" 
	                    name="start_date" 
	                    value="{{ old('start_date') ?? $event->start_date }}" 
	                    min="1992-01-01" 
	                    max="{{date('Y-m-d')}}"
	                    required>
	                    @error('start_date')
	                        <span class="invalid-feedback" role="alert">
	                            <strong>{{ $message }}</strong>
	                        </span>
	                    @enderror
	                </div>
	                <div class="col">
	                    <label for="end_date" class="col-md-4 form-label">End Date</label>
	                    <input id="end_date" 
	                    type="date" 
	                    class="form-control @error('end_date') is-invalid @enderror" 
	                    name="end_date" 
	                    value="{{ old('end_date') ?? $event->end_date }}"
	                    min="1992-01-01" 
	                    max="{{date('Y-m-d')}}">
	                    @error('end_date')
	                        <span class="invalid-feedback" role="alert">
	                            <strong>{{ $message }}</strong>
	                        </span>
	                    @enderror
	                </div>  
	            </div>
	            <div class="form-group row">
	                <div class="col form-group">
	                    <label for="start_time" class="col-md-4 col-form-label">Start Time</label>
	                    <input id="start_time" 
	                    type="time" 
	                    class="form-control @error('start_time') is-invalid @enderror" 
	                    name="start_time" 
	                    value="{{ date("H:i",strtotime($event->start_time)) }}">
	                    @error('start_time')
	                        <span class="invalid-feedback" role="alert">
	                            <strong>{{ $message }}</strong>
	                        </span>
	                    @enderror
	                </div>
	                <div class="col form-group">
	                    <label for="end_time" class="col-md-4 col-form-label">End Time</label>
	                    <input id="end_time" 
	                    type="time" 
	                    class="form-control @error('end_time') is-invalid @enderror" 
	                    name="end_time" 
	                    value="{{ date("H:i",strtotime($event->end_time)) }}">
	                    @error('end_time')
	                        <span class="invalid-feedback" role="alert">
	                            <strong>{{ $message }}</strong>
	                        </span>
	                    @enderror
	                </div>
	            </div>
	            <div class="form-group row">
	                <label for="venue" class="col-md-4 col-form-label">Venue</label>
	                <input id="venue" 
	                type="text" 
	                class="form-control @error('venue') is-invalid @enderror" 
	                name="venue" 
	                value="{{ old('venue') ?? $event->venue }}">
	                @error('venue')
	                    <span class="invalid-feedback" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>
	                @enderror
	            </div>
	            <div class="form-group row">
	                <label for="activity_type" class="col-md-4 col-form-label">Type of Activity</label>
	                <input id="activity_type" 
	                type="text" 
	                class="form-control @error('activity_type') is-invalid @enderror" 
	                name="activity_type" 
	                value="{{ old('activity_type') ?? $event->activity_type }}">
	                @error('activity_type')
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
	                value="{{ old('beneficiaries') ?? $event->beneficiaries }}">
	                @error('beneficiaries')
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
	                value="{{ old('sponsors') ?? $event->sponsors }}">
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
	                value="{{ old('budget') ?? $event->budget }}">
	                @error('budget')
	                    <span class="invalid-feedback" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>
	                @enderror
	            </div>
	            <hr>
	            <div class="form-group row">
	                <div class="col">
	                    <label for="radioEventRoleGroup" class="form-label">What was the Organization's Role in this Event?</label></div>
	                <div class="col" id="radioEventRoleGroup">
	                    @foreach($event_roles as $role)
	                    <div class="form-check">
	                        <input type="radio" id="{{$role->event_role}}" name="event_role" class="form-check-input" value="{{$role->event_role_id}}" @if($event->event_role_id  == $role->event_role_id) checked @endif>
	                        <label class="form-check-label" for="{{$role->event_role}}">{{$role->event_role}}</label>
	                    </div>
	                    @endforeach
	                </div>
	            </div>
	            @error('event_role')
	            <div class="row">
	                <span class="invalid-feedback" role="alert">
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
	                    @foreach($event_categories as $category)
	                    <div class="form-check">
	                        <input type="radio" id="{{$category->category}}" name="event_category" class="form-check-input" value="{{$category->event_category_id}}" 
	                        @if($event->event_category_id  == $category->event_category_id) checked @endif>
	                        <label class="form-check-label" for="{{$category->category}}">{{$category->category}}</label>
	                    </div>
	                    @endforeach
	                </div>
	            </div>
	            @error('event_category')
	            <div class="form-group row">
	                <span class="invalid-feedback" role="alert">
	                    <strong>{{ $message }}</strong>
	                </span>
	            </div>
	            @enderror
	            <hr>
	            <div class="row pt-4">
	                <button class="btn btn-primary">Finalize Edit</button>
	            </div>
	        </div>
	    </div>
	</form>
</div>
@endsection
