@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/n/{{$mn->notice_uuid}}" enctype="multipart/form-data" method="POST" id="MeetingNoticeForm">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-8 offset-2">
                <h2 class="text-center">Edit Meeting Notice</h2>
                <div class="form-group row">
                    <label for="for" class="col-md-4 col-form-label">For</label>    
                    <input type="text" id="for" class="form-control @error('for') is-invalid @enderror" 
                    name="for"
                    value="{{ old('for') ?? $mn->for }}"
                    autofocus="for"></input>
                    @error('for')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="from" class="col-md-4 col-form-label">From</label>    
                    <input type="text" id="from" class="form-control @error('from') is-invalid @enderror" 
                    name="from"
                    value= "{{ old('from') ?? $mn->from }}"
                    autofocus="from"></input>
                    @error('from')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="creation_date" class="col-md-4 col-form-label">Creation Date</label>
                    <input type="date" id="creation_date" class="form-control @error('creation_date') is-invalid @enderror" name="creation_date"
                    value= "{{ old('creation_date') ?? $mn->creation_date}}"
                    autofocus= "creation_date"></input>
                    @error('creation_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- TODO: Add option for multiple dates --}}
            	<div class="form-group row">
                    <label for="meeting_date" class="col-md-4 col-form-label">Meeting date</label>
                    <input id="meeting_date" 
                    type="datetime-local" 
                    class="form-control @error('meeting_date') is-invalid @enderror" 
                    name="meeting_date" 
                    value='{{ old("meeting_date") ?? $mn->meeting_date}}' autofocus="meeting_date">
                    @error('meeting_date')
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
                    value="{{ old('venue') ?? $mn->venue }}" autofocus= "venue">
                    @error('venue')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="objectives" class="col-md-4 col-form-label">Objectives</label>
                    <input id="objectives" 
                    type="text" 
                    class="form-control @error('objectives') is-invalid @enderror" 
                    name="objectives" 
                    value="{{ old('objectives') ?? $mn->objectives }}" autofocus= "objectives">
                    @error('objectives')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row pt-4">
                    <button class="btn btn-primary" type='submit'>Finalize Edit</button>
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
