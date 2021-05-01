@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/e/{{$event->id}}/images/{{$eventImage->id}}" enctype="multipart/form-data" method="POST" id="imageDetails_form">
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
                            <img src="/storage/{{$eventImage->image}}" class="card-img-middle w-100" style="width:500px;">
                            <div class="card-footer text-center align-middle">
                                <div class="display-5">
@if($eventImage->image_type == 0)
                                    Poster
@else
                                    Evidence
@endif
                                </div>
                            </div>
                        </div>  
        		    </div>
                    <div class="col-md-5">
                        <div class="card h-100">
                            <div class="card-header text-center align-middle">
                                <div class="display-5">Image Details</div>
                            </div>
                            <div class="card-body">
                                <label for="caption" class="col-md-4 col-form-label">Caption</label>  
                                <textarea id="caption" name="caption" class="form-control @error('caption') is-invalid @enderror" autocomplete="caption">{{ old('caption') ?? $eventImage->caption }}</textarea>

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
                                        <input class="form-check-input @error('image_type') is-invalid @enderror" type="radio" name="image_type" id="image_type1" value="0" {{ ($eventImage->image_type==0)? "checked" : "" }}>
                                        <label class="form-check-label" for="image_type1">Poster</label>
                                    </div>
                                    <div>
                                        <input class="form-check-input @error('image_type') is-invalid @enderror" type="radio" name="image_type" id="image_type2" value="1" {{ ($eventImage->image_type==1)? "checked" : "" }}>
                                        <label class="form-check-label" for="image_type2">Evidence</label>
                                    </div>
                               </div>
                            </div>
                
                            <div class="card-header text-center align-middle" style="border: 1px;">
                                <div class="display-5">Options</div>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <a href="#">
                                    <button class="btn btn-primary mr-3">Finalize Edit</button>
                                </a>
                            </div>
                        </div>
                    </div>      
        	    </div>	 
            	<hr>
            	<div class="row justify-content-center pt-1">
            		<a href="/e/{{$event->id}}/images/{{$eventImage->id}}">
            			<button class="btn btn-secondary">Go back</button>
            		</a>
            	</div>
            </div>
        </div>
    </form>
</div>
@endsection
