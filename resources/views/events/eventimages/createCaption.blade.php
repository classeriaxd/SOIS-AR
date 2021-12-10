@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('event.image.storeCaption', ['event_slug' => $event->slug])}}" enctype="multipart/form-data" method="POST" id="eventImageCaptionForm">
        @csrf
        <div class="row">
            <div class="col-12">
                {{-- Title and Breadcrumbs --}}
                <div class="d-flex justify-content-between align-items-center">
                    {{-- Title --}}
                    <h2 class="display-7 text-left text-break">Event Image Captions</h2>
                    {{-- Breadcrumbs --}}
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('event.index')}}" class="text-decoration-none">Events</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('event.show', ['event_slug' => $event->slug])}}" class="text-decoration-none">{{ $event->title }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{route('event.image.index', ['event_slug' => $event->slug,])}}" class="text-decoration-none">Images</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Captions
                            </li>
                        </ol>
                    </nav>
                </div>

                {{-- Posters --}}
                @if(($eventImages['posters']->isNotEmpty()))
                    <div class="d-flex flex-row justify-content-center align-items-center my-1">
                        <h6 class="display-6 text-center me-1">Posters</h6>
                        <a role="button"
                            data-bs-toggle="popover" 
                            data-bs-container="body"
                            data-bs-trigger="hover focus"
                            title="Posters" 
                            data-bs-content="Posters, Photographs, or Screenshots on the Event. Portrait Orientation is a must."
                            data-bs-placement="right">
                            <i class="far fa-question-circle"></i>
                        </a>
                    </div>
                    @foreach($eventImages['posters'] as $poster)
                        <div class="row">
                            <div class="col-sm-6">
                                 <div class="border border-dark">
                                    <div class="card-body">
                                        <img src="/storage/{{$poster->image}}" class="rounded mx-auto d-block" style="height: 190px; width: auto;">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-dark" style="height: 14rem;">
                                    <div class="card-header card-title text-center bg-maroon text-white fw-bold">Caption</div>
                                    <div class="card-body">
                                    <div class="card-body">
                                        <div class="form-group row w-100">   
                                                <textarea id="caption" 
                                                class="form-control @error('caption') is-invalid @enderror" 
                                                name="{{'caption[' . $poster->slug. ']' }}"
                                                placeholder="Poster Caption">{{ old('caption')}}</textarea>
                                                @error('caption')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                
            <br>

                @if(($eventImages['evidences']->isNotEmpty()))
                    <div class="d-flex flex-row justify-content-center align-items-center my-1">
                        <h6 class="display-6 text-center me-1">Evidences</h6>
                        <a role="button"
                            data-bs-toggle="popover" 
                            data-bs-container="body"
                            data-bs-trigger="hover focus"
                            title="Evidences" 
                            data-bs-content="Evidences, Photographs, or Screenshots on the Event. Landscape Orientation is a must."
                            data-bs-placement="right">
                            <i class="far fa-question-circle"></i>
                        </a>
                    </div>
                    @foreach($eventImages['evidences'] as $evidence)
                        <div class="row">
                            <div class="col-sm-6">
                                 <div class="border border-dark">
                                    <div class="card-body">
                                        <img src="/storage/{{$evidence->image}}" class="rounded mx-auto d-block" style="height: 190px; width: auto;">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-dark" style="height: 14rem;">
                                    <div class="card-header card-title text-center bg-maroon text-white fw-bold">Caption</div>
                                    <div class="card-body">
                                    <div class="card-body">
                                        <div class="form-group row w-100">   
                                                <textarea id="caption" 
                                                class="form-control @error('caption') is-invalid @enderror" 
                                                name="{{'caption[' . $evidence->slug. ']' }}"
                                                placeholder="Evidence Caption">{{ old('caption')}}</textarea>
                                                @error('caption')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if($eventImages['evidences']->isNotEmpty() || $eventImages['posters']->isNotEmpty())
                    <div class="flex my-2 text-center">
                        <button class="btn btn-primary text-white col-md-12" type="submit">Add Captions</button>
                    </div>
                @endif
            </div>
        </div>
    </form>

    <div class="flex-row my-2 text-center">
        <a href="{{route('event.show', ['event_slug' => $event->slug])}}"
        class="btn btn-secondary text-white"
        role="button">
            Go back
        </a>
    </div>
</div>

@endsection

@section('scripts')
    {{-- Enable Popovers --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap_related_js/enablePopover.js') }}"></script>
@endsection
