@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('event.image.update', ['event_slug' => $event->slug, 'eventImage_slug' => $event->eventImage->slug])}}" enctype="multipart/form-data" method="POST" id="eventImageUpdateForm"
        onsubmit="document.getElementById('submitButton').disabled=true;">
        @csrf
        @method('PATCH')
    	<div class="row justify-content-center">
            <div class="col-md-10">
        		<h2 class="display-2 text-center">Event Image</h2>
                
            	<div class="row justify-content-center pb-1">
            		<div class="col-md-5">
            			<div class="card h-100">
                            <div class="card-header text-center align-middle">
                                <div class="display-5">Image</div>
                            </div>
                            <br>
                            <img src="/storage/{{$event->eventImage->image}}" class="rounded mx-auto d-block" style="max-width: 200px; height: 200px;">
                        </div>  
        		    </div>
                    <div class="col-md-5">
                        <div class="card h-100">
                            <div class="card-header text-center align-middle">
                                <div class="display-5">Image Details</div>
                            </div>
                            <div class="card-body">
                                <label for="caption" class="col-md-4 col-form-label">Caption</label>  
                                <textarea id="caption" name="caption" class="form-control @error('caption') is-invalid @enderror" autocomplete="caption">{{ old('caption') ?? $event->eventImage->caption }}</textarea>

                                <label class="col-md-4 col-form-label">Image Type</label>
                                <br>  
                                @error('image_type')
                                    <div>
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    </div>
                                @enderror
                                <div class="form-check justify-content-between" id="form-image_type">
                                   
                                    <div>
                                        <input class="form-check-input @error('image_type') is-invalid @enderror" type="radio" name="image_type" id="image_type1" value="0" {{ ($event->eventImage->image_type==0)? "checked" : "" }}>
                                        <label class="form-check-label" for="image_type1">Poster</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input @error('image_type') is-invalid @enderror" type="radio" name="image_type" id="image_type2" value="1" {{ ($event->eventImage->image_type==1)? "checked" : "" }}>
                                        <label class="form-check-label" for="image_type2">Evidence</label>
                                    </div>
                               </div>
                            </div>
                
                          
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <button id="submitButton" class="btn btn-primary text-white me-3" type="submit">Finalize Edit</button>
                            </div>
                        </div>
                    </div>      
        	    </div>	 
            	<hr>

                <div class="flex-row my-2 text-center">
                    <a href="{{route('event.image.show', ['event_slug' => $event->slug, 'eventImage_slug' => $event->eventImage->slug])}}"
                        class="btn btn-secondary text-white"
                        role="button">
                            Go Back
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
