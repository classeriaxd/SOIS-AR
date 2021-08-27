@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/e" enctype="multipart/form-data" method="POST" id="eventForm">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                <h2 class="text-center">New Event Report</h2>
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Title</label>
                    <input id="title" 
                    type="text" 
                    class="form-control @error('title') is-invalid @enderror" 
                    name="title"
                    placeholder="Event Title" 
                    value="{{ old('title') }}" autofocus required>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label">Description</label>    
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
                <div class="form-group row">
                    <label for="objective" class="col-md-4 col-form-label">Objective</label>
                    <textarea id="objective" 
                    class="form-control @error('objective') is-invalid @enderror" name="objective" 
                    placeholder="Objective" 
                    required>{{ old('objective') }}</textarea>
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
                        value="{{ old('start_date') }}" 
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
                        value="{{ old('end_date') }}"
                        min="1992-01-01" 
                        max="{{date('Y-m-d')}}">
                        @error('end_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>  
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="start_time" class="col-md-4 col-form-label">Start Time</label>
                        <input id="start_time" 
                        type="time" 
                        class="form-control @error('start_time') is-invalid @enderror" 
                        name="start_time" 
                        value="{{ old('start_time') }}">
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
                        value="{{ old('end_time') }}">
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
                    placeholder="Venue ex. (Zoom or Facebook Live)"  
                    value="{{ old('venue') }}">
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
                    placeholder="Type of Activity ex. (Student Development-Intellectual)" 
                    value="{{ old('activity_type') }}">
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
                    placeholder="Beneficiaries ex. (Students of PUP-Taguig Branch)" 
                    value="{{ old('beneficiaries') }}">
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
                    placeholder="Sponsors" 
                    value="{{ old('sponsors') }}">
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
                    placeholder="Budget" 
                    value="{{ old('budget') }}">
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
                            <input type="radio" id="{{$role->event_role}}" name="event_role" class="form-check-input" value="{{$role->event_role_id}}">
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
                            <input type="radio" id="{{$category->category}}" name="event_category" class="form-check-input" value="{{$category->event_category_id}}">
                            <label class="form-check-label" for="{{$category->category}}">{{$category->category}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @error('event_category')
                <div class="row">
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
                @enderror
                <hr>
                <div class="row pt-4">
                    <button class="btn btn-primary">Add Event</button>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <div class="row justify-content-center">
        <a href="/home">
            <button class="btn btn-secondary">Go back</button>
        </a>
    </div>
</div>
@endsection
