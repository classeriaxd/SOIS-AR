@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
    		<h2 class="display-2 text-center">{{ $event->title }}</h2>
            <h4 class="text-center"><span class="badge badge-{{$event->category_color}}">{{$event->eventCategory->category}}</span>  <span class="badge badge-{{$event->role_color}}">{{$event->eventRole->event_role}}</span></h4>
        	<div class="row justify-content-center mb-1">
        		<div class="col-md-5">
        			<div class="card">
        				<h4 class="card-header card-title text-center">Event Summary</h4>
        				<div class="card-body">
        					<h3 class="card-title text-center">Title: {{ $event->title }}</h3>
        					<p class="card-text">
        						<span style="font-weight: bold;">Date:</span> 
                                @if($event->start_date == $event->end_date){{date_format(date_create($event->start_date), 'F d, Y')}}
                                @else{{date_format(date_create($event->start_date), 'F d, Y') . ' - ' . date_format(date_create($event->end_date), 'F d, Y')}}
                                @endif
        					</p>
                            <p class="card-text">
                                <span style="font-weight: bold;">Time:</span>
                                @if($event->start_time == $event->end_time){{date_format(date_create($event->start_time), 'h:i A')}}
                                @else{{date_format(date_create($event->start_time), 'h:i A') . ' - ' . date_format(date_create($event->end_time), 'h:i A')}}
                                @endif
                            </p>
        					<p class="card-text">
        						<span style="font-weight: bold;">Venue:</span> {{ $event->venue }}
        					</p>
        					<p class="card-text">
        						<span style="font-weight: bold;">Type of Activity:</span> 
                                {{ $event->activity_type }}
        					</p>
        					<p class="card-text">
        						<span style="font-weight: bold;">Sponsors:</span> 
                                {{ $event->sponsors }}
        					</p>
                            <p class="card-text">
                                <span style="font-weight: bold;">Budget:</span> 
                                {{ $event->budget }} - {{ $event->eventFundSource->fund_source }}
                            </p>
                            <p class="card-text">
                                <span style="font-weight: bold;">Level:</span>
                                {{ $event->eventLevel->level }}
                            </p>
        				</div>
                        <h5 class="card-header card-text text-center border-top">Options</h5>
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
    				    <h4 class="card-header card-title text-center">Event Gallery</h4>
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
                        <h5 class="card-header card-text text-center border-top">Options</h5>
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
            <div class="row justify-content-center mt-2 mb-1">
                <div class="card w-50">
                    <h4 class="card-header card-title text-center">Event Documents</h4>
                    <div class="card-body text-center">
                    @if($eventDocuments->count() > 0 )
                    @php $i = 1; @endphp
                    <table class="table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Document Type</th>
                                <th scope="col">Title</th>
                            </tr>
                        </thead>
                        <tbody>
                    @foreach($eventDocuments as $document)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $document->document_type }}</td>
                                <td>{{ $document->title }}</td>
                            </tr>
                    @php $i += 1; @endphp

                    @endforeach
                        </tbody>
                    </table>
                    @else
                        <p class="text-center">No Document found. :(</p>
                    @endif
                    </div>
                    <h5 class="card-header card-text text-center border-top">Options</h5>
                    <div class="card-body">
                        <a href="{{route('event_documents.create',['event_slug' => $event->slug,])}}">
                            <button class="btn btn-primary">Add Document</button>
                        </a>
                        <br>
                        <a href="{{route('event_documents.index',['event_slug' => $event->slug,])}}">
                            <button class="btn btn-primary">View All Event Documents</button>
                        </a>
                        
                    </div>
                </div>
            </div>
            @if($newEvent)
        	<hr>
            <div class="row justify-content-center my-1">
                <a href="{{route('event.create')}}">
                    <button class="btn btn-primary">Create Another Event</button>
                </a>
            </div>
            @endif
            <hr>
        	<div class="row justify-content-center my-1">
        		<a href="/e">
        			<button class="btn btn-secondary">Go back</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection
