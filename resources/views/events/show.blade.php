@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
    		<h2 class="display-2 text-center">{{ $event->title }}</h2>
            <h4 class="text-center"><span class="badge badge-{{$event->category_color}}">{{$event->event_category}}</span>  <span class="badge badge-{{$event->role_color}}">{{$event->event_role}}</span></h4>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-5">
        			<div class="card">
        				<div class="card-header text-center align-middle">
        				    <div class="display-5">Event Summary</div>
        				</div>
        				<div class="card-body">
        					<h3 class="card-title">Title: {{ $event->title }}</h3>
        					<p class="card-text">
        						Date: 
                                @if($event->start_date == $event->end_date){{date_format(date_create($event->start_date), 'F d, Y')}}
                                @else{{date_format(date_create($event->start_date), 'F d, Y') . ' - ' . date_format(date_create($event->end_date), 'F d, Y')}}
                                @endif
        					</p>
                            <p class="card-text">
                                Time:
                                @if($event->start_time == $event->end_time){{date_format(date_create($event->start_time), 'h:i A')}}
                                @else{{date_format(date_create($event->start_time), 'h:i A') . ' - ' . date_format(date_create($event->end_time), 'h:i A')}}
                                @endif
                            </p>
        					<p class="card-text">
        						Venue: {{ $event->venue }}
        					</p>
        					<p class="card-text">
        						Type of Activity: {{ $event->activity_type }}
        					</p>
        					<p class="card-text">
        						Sponsors: {{ $event->sponsors }}
        					</p>
        				</div>
        				<div class="card-header text-center align-middle">
        					<div class="display-5">Options</div>
        				</div>
        				<div class="card-body d-flex flex-row justify-content-around">
        					<a href="/e/{{$event->slug}}/edit">
        						<button class="btn btn-primary">Edit Event</button>
        					</a>
        					<form action="{{route('event.destroy', $event->slug)}}" method="POST">
        						@method('DELETE')
        						@csrf
        						<button class="btn btn-danger">Delete Event</button>
        					</form>  
        				</div>
        			</div>
        		</div>
        		 <div class="col-md-5">
        			<div class="card">
        				<div class="card-header text-center align-middle">
        				    <div class="display-5">Event Gallery</div>
        				</div>
        				<div class="card-body">
                            <h3 class="card-title text-center">Posters</h3>
                            <div class="row flex-row flex-nowrap pb-2 pl-1" style="overflow-x:auto;">
@if($eventImages->where('image_type', 0)->count() > 0)

@foreach($eventImages as $eventImage)
    @if($eventImage->image_type == 0)
                                <img src="/storage/{{$eventImage->image}}" class="w-300 pr-3" style="max-width: 200px;">
    @endif
@endforeach
@else
                                <p class="text-center">No Image found. :(</p>
@endif
                            </div>
                            <hr>
                            <h3 class="card-title text-center">Evidences</h3>
                            <div class="row flex-row flex-nowrap pb-2 pl-1" style="overflow-x:auto;">
@if($eventImages->where('image_type', 1)->count() > 0)

@foreach($eventImages as $eventImage)
    @if($eventImage->image_type == 1)
                                <img src="/storage/{{$eventImage->image}}" class="w-300 pr-3" style="max-width: 200px;">
    @endif
@endforeach
@else
                                <p class="text-center">No Image found. :(</p>
@endif        
                            </div>                  
                        </div>
        				<div class="card-header text-center align-middle">
        					<div class="display-5">Options</div>
        				</div>
        				<div class="card-body d-flex flex-row justify-content-around">
                            <a href="/e/{{$event->slug}}/images/create">
                                <button class="btn btn-primary">Add Image</button>
                            </a>
                            <a href="/e/{{$event->slug}}/images">
                                <button class="btn btn-primary">View Event Gallery</button>
                            </a>	
        				</div>
        			</div>
        		</div>
        	</div>
        	<hr>
        	<div class="row justify-content-center pt-1">
        		<a href="/e">
        			<button class="btn btn-secondary">Go back</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection
