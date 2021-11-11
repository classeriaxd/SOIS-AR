@extends('layouts.admin-app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Event View</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.events.index')}}" class="text-decoration-none">Events</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.events.organization.index', ['organization_slug' => $event->organization->organization_slug])}}" class="text-decoration-none">{{ $event->organization->organization_acronym }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $event->title }}
                        </li>
                    </ol>
                </nav>
            </div>
            
        	<div class="row justify-content-center mb-1">
                <div class="col">
                    <div class="card my-2 w-100">
                        <h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Event Summary</h4>
                        <div class="card-body">

                            {{-- Title --}}
                            <div class="d-flex justify-content-center my-2">
                                {{-- Organization Logo --}}
                                <div class="my-auto">
                                    <img src="/storage/{{$event->organization->logo->file}}" style="max-width: 5em; max-height: 5em; min-height: 5em; min-width: 5em;">
                                </div>

                                {{-- Vertical Rule --}}
                                <div class="vr mx-2" style="border:1px solid black; background-color: black;"></div>

                                {{-- Event Details --}}
                                <div>
                                    <p class="card-title text-break">
                                        <span style="font-weight: bold; font-size:1.5em">{{ $event->title }}</span>

                                        <br>

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

                                        <br>

                                        <span style="font-weight: bold;">Organization:</span> {{ $event->organization->organization_acronym }}
                                    </p>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="row my-2">
                                <h5 class="card-text fw-bold">Description:</h5><div class="vr"></div>
                                <p class="text-justify">{{ $event->description }}</p>
                            </div>

                            {{-- Objective --}}
                            <div class="row my-2">
                                <h5 class="card-text fw-bold">Objective:</h5>
                                <p class="text-justify">{{ $event->objective }}</p>
                            </div>

                            {{-- Other Event Details --}}
                            <div class="row text-center mt-4 mb-1">

                                {{-- Date and Venue --}}
                                <div class="col">

                                    <h5 class="card-text fw-bold">Date and Venue</h5>
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
                                </div>

                                {{-- Funding --}}
                                <div class="col">
                                    <h5 class="card-text fw-bold">Funding</h5>
                                    <p class="card-text">
                                        <span style="font-weight: bold;">Budget:</span> 
                                        {{ $event->budget ?? '-' }}
                                    </p>
                                    <p class="card-text">
                                        {{ $event->eventFundSource->fund_source }}
                                    </p>
                                    <p class="card-text">
                                        <span style="font-weight: bold;">Sponsors:</span> 
                                        {{ $event->sponsors }}
                                    </p>
                                </div>

                                {{-- Categories --}}
                                <div class="col">
                                    <h5 class="card-text fw-bold">Categories</h5>
                                    <p class="card-text">
                                        <span style="font-weight: bold;">Type of Activity:</span> 
                                        {{ $event->activity_type }}
                                    </p>
                                    <p class="card-text">
                                        <span style="font-weight: bold;">Level:</span>
                                        {{ $event->eventLevel->level }}
                                    </p>
                                    <p class="card-text">
                                        <span style="font-weight: bold;">Classification:</span>
                                        {{ $event->eventClassification->classification }}
                                    </p>
                                    <p class="card-text">
                                        <span style="font-weight: bold;">Nature:</span>
                                        {{ $event->eventNature->nature }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card my-2 w-100">
                        <h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Event Gallery</h4>
                        <div class="card-body">
                            <h3 class="card-title text-center">Posters</h3>
                            <div class="row flex-row flex-nowrap pb-4 px-2 justify-content-center" style="overflow-x:auto;">
                                @if($event->eventImages->where('image_type', 0)->count() > 0)

                                @foreach($event->eventImages as $eventImage)
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
                            <div class="row flex-row flex-nowrap pb-2 pl-1 justify-content-center" style="overflow-x:auto;">

                                @if($event->eventImages->where('image_type', 1)->count() > 0)

                                @foreach($event->eventImages as $eventImage)
                                    @if($eventImage->image_type == 1)
                                        <img src="/storage/{{$eventImage->image}}" class="w-300 pr-3" style="max-width: 200px;">
                                    @endif
                                @endforeach

                                @else
                                    <p class="text-center">No Image found. :(</p>
                                @endif        
                            </div>                  
                        </div>
                    </div>
                    <div class="card my-2 w-100">
                        <h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Event Documents</h4>
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
                    </div>                
                </div>
        	</div>

            <hr>

            <div class="flex-row my-2 text-center">
                <a href="{{route('admin.events.organization.index', ['organization_slug' => $event->organization->organization_slug])}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        Go back to {{$event->organization->organization_acronym}} Events
                </a>
                <span>or</span>
                
                <a href="{{route('admin.events.index')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        Go back to All Events
                </a>            
            </div>

            

        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Enable Popovers --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap_related_js/enablePopover.js') }}"></script>
@endsection
