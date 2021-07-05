@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/e/{{$event->slug}}/images" enctype="multipart/form-data" method="POST" id="eventForm">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                <h1 class="text-center display-4">Add new Event Image</h1>
                <h1 class="text-center display-5">{{$event->title}}</h1>
                <div class="row">  
                    <label for="poster" class="col-md-4 col-form-label">Poster</label>
                    <input type="file" class="form-control-file @error('poster') is-invalid @enderror" id="poster" name="poster">
                    @error('poster')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="poster_caption" class="col-md-4 col-form-label">Poster Caption</label>
                    <input id="poster_caption" 
                    type="text" 
                    class="form-control @error('poster_caption') is-invalid @enderror" 
                    name="poster_caption" 
                    value="{{ old('poster_caption') }}" autocomplete="poster_caption">
                    @error('poster_caption')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">  
                    <label for="evidence" class="col-md-4 col-form-label">Evidence</label>
                    <input type="file" class="form-control-file @error('evidence') is-invalid @enderror" id="evidence" name="evidence">
                    @error('evidence')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="evidence_caption" class="col-md-4 col-form-label">Caption</label>
                    <input id="evidence_caption" 
                    type="text" 
                    class="form-control @error('evidence_caption') is-invalid @enderror" 
                    name="evidence_caption" 
                    value="{{ old('evidence_caption') }}" autocomplete="evidence_caption">
                    @error('evidence_caption')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row pt-4 justify-content-center">
                    <button class="btn btn-primary">Add Images</button>
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
