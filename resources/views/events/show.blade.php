@extends('layouts.app')

@section('content')
<div class="container-liquid">
	<div class="row justify-content-center">
        <div class="col-md-12">
            
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
            

            <div class="row justify-content-center my-1">
                <div class="col">
                    <div class="card my-2 w-100">
                        <h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Event Summary</h4>
                        <div class="card-body">

                            {{-- Title --}}
                            <div class="d-flex justify-content-center my-2">
                                {{-- Organization Logo --}}
                                <div class="my-auto">
                                    @if($event->organization->logo !== NULL)
                                        <img src="/storage/{{$event->organization->logo->file}}" style="max-width: 5em; max-height: 5em; min-height: 5em; min-width: 5em;">
                                    @else
                                        <img src="/storage/organization_assets/logo/default_logo.png" style="max-width: 5em; max-height: 5em; min-height: 5em; min-width: 5em;">
                                    @endif
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
                                <h5 class="card-text fw-bold">Description:</h5>
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

                            {{-- Event Options --}}
                            <div class="d-flex mt-2 mb-1 justify-content-around">
                                <a href="{{route('event.edit', ['event_slug' => $event->slug])}}">
                                    <button class="btn btn-primary text-white">
                                        <i class="fas fa-edit"></i> Edit Event
                                    </button>
                                </a>
                                
                                <button class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#areYouSureModal">
                                    <i class="fas fa-trash"></i> Delete Event
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card my-2 w-100">
                        <h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Event Gallery</h4>
                        <div class="card-body">

                            {{-- Posters --}}
                            <div class="row">
                                <h3 class="card-title text-center">Posters</h3>
                                @if($eventPosters->count() > 0)
                                    <div id="PosterControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
                                        <div class="carousel-indicators">
                                            @foreach($eventPosters as $poster)
                                                <button type="button" data-bs-target="#PosterControls" data-bs-slide-to="{{$loop->index}}" @if($loop->first) class="active" aria-current="true" @endif aria-label="Slide {{$loop->index}}"></button>
                                            @endforeach
                                        </div>
                                        <div class="carousel-inner">
                                            @foreach($eventPosters as $poster)
                                                <div class="carousel-item @if($loop->first)active @endif">
                                                    <a href="{{route('event.image.show', ['event_slug' => $event->slug, 'eventImage_slug' => $poster->slug])}}">
                                                        <img src="/storage/{{$poster->image}}" class="d-block" style="max-width: 350px; max-height: 350px; margin:auto"> 
                                                        <div class="carousel-caption">
                                                            <div class="d-flex justify-content-center">
                                                                <p class="bg-primary bg-opacity-50 text-white p-1 rounded-pill">
                                                                    {{$poster->caption ?? 'No Caption Provided'}}
                                                                </p>
                                                            </div>
                                                        </div>  
                                                    </a>
                                                </div>  
                                            @endforeach
                                        </div>

                                        <button class="carousel-control-prev" type="button" data-bs-target="#PosterControls" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#PosterControls" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                @else
                                    <p class="text-center">No Image found. :(</p>
                                @endif
                            </div>
                            
                            <hr>

                            {{-- Evidences --}}
                            <div class="row">
                                <h3 class="card-title text-center">Evidences</h3>
                                @if($eventEvidences->count() > 0)
                                    <div id="EvidenceControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
                                        <div class="carousel-indicators">
                                            @foreach($eventEvidences as $evidence)
                                                <button type="button" data-bs-target="#EvidenceControls" data-bs-slide-to="{{$loop->index}}" @if($loop->first) class="active" aria-current="true" @endif aria-label="Slide {{$loop->index}}"></button>
                                            @endforeach
                                        </div>
                                        <div class="carousel-inner">
                                            @foreach($eventEvidences as $evidence)
                                                <div class="carousel-item @if($loop->first)active @endif">  
                                                    <a href="{{route('event.image.show', ['event_slug' => $event->slug, 'eventImage_slug' => $evidence->slug])}}">
                                                        <img src="/storage/{{$evidence->image}}" class="d-block" style="max-width: 500px; max-height: 350px; margin:auto"> 
                                                        <div class="carousel-caption">
                                                            <div class="d-flex justify-content-center">
                                                                <p class="bg-primary bg-opacity-50 text-white p-1 rounded-pill">
                                                                    {{$evidence->caption ?? 'No Caption Provided'}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>

                                        <button class="carousel-control-prev" type="button" data-bs-target="#EvidenceControls" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#EvidenceControls" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                @else
                                    <p class="text-center">No Image found. :(</p>
                                @endif
                            </div>

                            {{-- Event Images Options --}}
                            <div class="d-flex justify-content-around">
                                <a href="{{route('event.image.create', ['event_slug' => $event->slug])}}">
                                    <button class="btn btn-primary text-white">
                                        <i class="fas fa-plus"></i> Add Image
                                    </button>
                                </a>
                                <a href="{{route('event.image.index', ['event_slug' => $event->slug])}}">
                                    <button class="btn btn-primary text-white">
                                        <i class="fas fa-th"></i> View Event Gallery
                                    </button>
                                </a>    
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

                        {{-- Event Document Options --}}
                        <div class="mt-2 mb-1 d-flex justify-content-around">
                            <a href="{{route('event.document.create',['event_slug' => $event->slug,])}}"
                                class="btn btn-primary text-white"
                                role="button">
                                <i class="fas fa-plus"></i> Add Document
                            </a>

                            <a href="{{route('event.document.index',['event_slug' => $event->slug,])}}"
                                class="btn btn-primary text-white"
                                role="button">
                                <i class="fas fa-th"></i> View All Event Documents
                            </a>
                        </div>   
                        </div>
                    </div>                
                </div>
            </div>

            <hr>

            <div class="flex-row my-2 text-center">
                <a href="{{route('event.index')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-arrow-left"></i> Go Back to All Events
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

            {{-- Are you sure Modal --}}
            <div class="modal fade" id="areYouSureModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="areYouSureModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="areYouSureModal">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you Sure?
                        </div>
                        <div class="modal-footer">
                            <form action="{{route('event.destroy', $event->slug)}}" method="POST"
                                    onsubmit="document.getElementById('deleteButton').disabled=true;">
                                @method('DELETE')
                                @csrf
                            
                                <button id="deleteButton" type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                                <button type="submit" class="btn btn-danger text-white"><i class="fas fa-check"></i> Understood</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Enable Popovers --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap_related_js/enablePopover.js') }}"></script>
@endsection
