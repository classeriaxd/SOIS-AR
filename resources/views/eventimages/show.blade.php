@extends('layouts.app')

@section('content')
<div class="container">
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
                            <div class="display-5">Caption</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                {{$eventImage->caption}}
                            </p>
                        </div>
                        <div class="card-header text-center align-middle" style="border: 1px;">
                            <div class="display-5">Options</div>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <a href="/e/{{$event->id}}/images/{{$eventImage->id}}/edit">
                                <button class="btn btn-primary mr-3">Edit</button>
                            </a>
                            <form action="{{route('eventImage.destroy', [$event->id, $eventImage->id])}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger">Delete Image</button>
                            </form>  
                        </div>
                    </div>
                </div>
        	</div>	 
        	<hr>
        	<div class="row justify-content-center pt-1">
        		<a href="/e/{{$event->id}}/images">
        			<button class="btn btn-secondary">Go back</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection
