@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/e" enctype="multipart/form-data" method="POST" id="eventForm">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                <h2 class="text-center">Add New Event</h2>
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Title</label>
                    <input id="title" 
                    type="text" 
                    class="form-control @error('title') is-invalid @enderror" 
                    name="title" 
                    value="{{ old('title') }}" autocomplete="title" autofocus>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label">Description</label>    
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" 
                    name="description" 
                    autocomplete="description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="objective" class="col-md-4 col-form-label">Objective</label>
                    <textarea id="objective" class="form-control @error('objective') is-invalid @enderror" name="objective"autocomplete="objective">{{ old('objective') }}</textarea>
                    @error('objective')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- TODO: Add option for multiple dates --}}
                <div class="form-group row">
                    <label for="date" class="col-md-4 col-form-label">Event Date</label>
                    <input id="date" 
                    type="date" 
                    class="form-control @error('date') is-invalid @enderror" 
                    name="date" 
                    value="{{ old('date') }}" autocomplete="date">
                    @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="start_time" class="col-md-4 col-form-label">Start Time</label>
                    <input id="start_time" 
                    type="time" 
                    class="form-control @error('start_time') is-invalid @enderror" 
                    name="start_time" 
                    value="{{ old('start_time') }}" autocomplete="start_time">
                    @error('start_time')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="end_time" class="col-md-4 col-form-label">End Time</label>
                    <input id="end_time" 
                    type="time" 
                    class="form-control @error('end_time') is-invalid @enderror" 
                    name="end_time" 
                    value="{{ old('end_time') }}" autocomplete="end_time">
                    @error('end_time')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="venue" class="col-md-4 col-form-label">Venue</label>
                    <input id="venue" 
                    type="text" 
                    class="form-control @error('venue') is-invalid @enderror" 
                    name="venue" 
                    value="{{ old('venue') }}" autocomplete="venue">
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
                    value="{{ old('activity_type') }}" autocomplete="activity_type">
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
                    value="{{ old('beneficiaries') }}" autocomplete="beneficiaries">
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
                    value="{{ old('sponsors') }}" autocomplete="sponsors">
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
                    value="{{ old('budget') }}" autocomplete="budget">
                    @error('budget')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
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
