@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('event.image.storeCaption', ['event_slug' => $event->slug])}}" enctype="multipart/form-data" method="POST" id="eventImageCaptionForm">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                {{-- Title and Breadcrumbs --}}
                <div class="row">
                    {{-- Title --}}
                    <h2 class="display-2 text-center">Event Image Captions</h2>
                    <h6 class="display-6 text-center">{{$event->title}}</h6>
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

                @if(($eventImages['posters']->isNotEmpty()))
                <div class="d-flex flex-row justify-content-center align-items-center my-1">
                    <h6 class="display-6 text-center me-1">Posters</h6>
                    <a role="button"
                        data-bs-toggle="popover" 
                        data-bs-container="body"
                        title="Posters" 
                        data-bs-content="Posters, Photographs, or Screenshots on the Event. Landscape Orientation is a must."
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
            @else
            @endif

            @if($eventImages['posters']->isNotEmpty())
                <div class="flex my-2 text-center">
                    <button class="btn btn-primary text-white col-md-12" type="submit">Add Captions</button>
                </div>
            @endif
                
            <br>

            @if(($eventImages['evidences']->isNotEmpty()))
                <div class="d-flex flex-row justify-content-center align-items-center my-1">
                    <h6 class="display-6 text-center me-1">Evidences</h6>
                    <a role="button"
                        data-bs-toggle="popover" 
                        data-bs-container="body"
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
            @else
            @endif

            @if($eventImages['evidences']->isNotEmpty())
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
    <script type="text/javascript">
        // Enable All Popovers on this Page //
        // Requires Loading JS without Defer //
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
          return new bootstrap.Popover(popoverTriggerEl)
        })
        $('body').on('click', function (e) {
            $('[data-bs-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
        // https://stackoverflow.com/questions/11703093/how-to-dismiss-a-twitter-bootstrap-popover-by-clicking-outside //
    </script>
@endsection
