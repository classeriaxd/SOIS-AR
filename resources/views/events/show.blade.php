@extends('layouts.app')

@section('content')
<div class="container-liquid">
	<div class="row justify-content-center">
        <div class="col-md-10">
            
            {{-- Success Alert --}}
                @if (session()->has('success'))
                    <div class="flex-row text-center" id="success_alert">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

            {{-- Error Alert --}}
                @if (session()->has('error'))
                    <div class="flex-row text-center" id="success_alert">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h2 class="display-2 text-center">{{ $event->title }}</h2>
                <h3 class="text-center">
                    <span class="badge" style="background-color:{{$event->eventCategory->background_color}}; color:{{$event->eventCategory->text_color}};">
                        {{$event->eventCategory->category}}
                        @if($event->eventCategory->deleted_at != NULL)
                        <a role="button"
                            data-bs-toggle="popover"
                            data-bs-container="body"
                            data-bs-trigger="hover focus" 
                            title="{{$event->eventCategory->category}}" 
                            data-bs-content="This category has been deleted since {{date_format(date_create($event->eventCategory->deleted_at), 'F d, Y')}}."
                            data-bs-placement="right">
                            <i class="fas fa-exclamation-circle"></i>
                        </a>
                        @endif
                    </span>  
                    <span class="badge" style="background-color:{{$event->eventRole->background_color}}; color:{{$event->eventRole->text_color}};">
                        {{$event->eventRole->event_role}}
                        @if($event->eventRole->deleted_at != NULL)
                        <a role="button"
                            data-bs-toggle="popover"
                            data-bs-container="body" 
                            data-bs-trigger="hover focus"
                            title="{{$event->eventRole->event_role}}" 
                            data-bs-content="This event role has been deleted since {{date_format(date_create($event->eventRole->deleted_at), 'F d, Y')}}."
                            data-bs-placement="right">
                            <i class="fas fa-exclamation-circle"></i>
                        </a>
                        @endif
                    </span>
                </h3>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('event.index')}}" class="text-decoration-none">Events</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $event->title }}
                        </li>
                    </ol>
                </nav>
            </div>
            
        	<div class="row justify-content-center mb-1">
        		<div class="col-md-5">
        			<div class="card" style="height: 39rem;">
        				<h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Event Summary</h4>
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
        					<a href="{{route('event.edit', ['event_slug' => $event->slug])}}">
        						<button class="btn btn-primary text-white">Edit Event</button>
        					</a>
        					<form action="{{route('event.destroy', $event->slug)}}" method="POST">
        						@method('DELETE')
        						@csrf
        						<button class="btn btn-danger text-white">Delete Event</button>
        					</form>  
        				</div>
        			</div>
        		</div>
        		<div class="col-md-5">
        			<div class="card">
    				    <h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Event Gallery</h4>
        				<div class="card-body" style="height: 30rem;">
                            <h3 class="card-title text-center">Posters</h3>
                            <div class="row flex-row flex-nowrap pb-4 px-2" style="overflow-x:auto;">
                        @if($event->eventImages->where('image_type', 0)->count() > 0)

                        @foreach($event->eventImages as $eventImage)
                            @if($eventImage->image_type == 0)
                                <img src="/storage/{{$eventImage->image}}" class="w-200 pr-3" style="max-height: 130px; width: 100px;">
                            @endif
                        @endforeach
                        @else
                                <p class="text-center">No Image found. :(</p>
                        @endif
                            </div>
                            <hr>
                            <h3 class="card-title text-center">Evidences</h3>
                        <div class="row flex-row flex-nowrap pb-4 px-2" style="overflow-x:auto;">

                            @if($event->eventImages->where('image_type', 1)->count() > 0)

                            @foreach($event->eventImages as $eventImage)
                                @if($eventImage->image_type == 1)
                                    <img src="/storage/{{$eventImage->image}}" class="w-200 pr-3" style="max-width: 130px; height: 100px;">
                                @endif
                            @endforeach
                            @else
                                    <p class="text-center">No Image found. :(</p>
                            @endif        
                            </div>                  
                        </div>
        			</div>                   		
                <h5 class="card-header card-text text-center border-top">Options</h5>
        				<div class="card-body d-flex flex-row justify-content-around">
                            <a href="{{route('event.image.create', ['event_slug' => $event->slug])}}">
                                <button class="btn btn-primary text-white">Add Image</button>
                            </a>
                            <a href="{{route('event.image.index', ['event_slug' => $event->slug])}}">
                                <button class="btn btn-primary text-white">View Event Gallery</button>
                            </a>	
        				</div>
                    </div>
        	    </div>
            <div class="row justify-content-center mt-2 mb-1">
                <div class="card w-50">
                    <div class="card-header card-title text-center  text-black fw-bold">Event Documents</div>
                    <div class="card-body text-center">
                    @if($event->eventDocuments->count() > 0 )
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
                    @foreach($event->eventDocuments as $document)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $document->documentType->document_type }}</td>
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

                    <div class="card-body d-flex justify-content-around">
                        <a href="{{route('event.document.create',['event_slug' => $event->slug,])}}"
                            class="btn btn-primary text-white"
                            role="button">
                            Add Document
                        </a>

                        <a href="{{route('event.document.index',['event_slug' => $event->slug,])}}"
                            class="btn btn-primary text-white"
                            role="button">
                            View All Event Documents
                        </a>
                        
                    </div>
                </div>
            </div>

            <hr>

            <div class="flex-row my-2 text-center">
                <a href="{{route('event.index')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-arrow-left"></i> Go Back
                </a>
                @if($newEvent)

                    <span>or</span>

                    <a href="{{route('event.create')}}"
                        class="btn btn-primary text-white"
                        role="button">
                            <i class="fas fa-clipboard-list"></i> Create Another Event
                    </a>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Enable Popovers --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap_related_js/enablePopover.js') }}"></script>
@endsection
