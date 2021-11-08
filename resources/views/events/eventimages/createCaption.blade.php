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
                <div class="d-flex flex-row justify-content-center ">
                    <h6 class="display-6 me-1">Posters</h6>
                    <a role="button"
                        data-bs-toggle="popover" 
                        data-bs-container="body"
                        title="Posters" 
                        data-bs-content="Posters that are made exclusively for this Event. Portrait Orientation is a must."
                        data-bs-placement="right">
                        <i class="far fa-question-circle"></i>
                    </a>
                </div>
                @foreach($eventImages['posters'] as $poster)
                <div class="row border border-dark my-1">
                    <div class="col">
                        <img src="/storage/{{$poster->image}}" class="card-img-middle w-100" style="max-width:20vw; min-width: 20vw; max-height: 50vh; min-height: 50vh;">
                    </div>
                    
                    <div class="col d-flex align-items-center">
                        <div class="form-group row w-100">
                            <label for="caption" class="col-form-label text-center">Caption</label>    
                            <textarea id="caption" 
                            class="form-control @error('caption') is-invalid @enderror" 
                            name="{{'caption[' . $poster->slug . ']' }}"
                            placeholder="Poster Caption">{{ old('caption')}}</textarea>
                            @error('caption')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                @endforeach
            @else
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
                <div class="row border border-dark my-1">
                    <div class="col">
                        <img src="/storage/{{$evidence->image}}" class="card-img-middle w-100" style="max-width:35vw; min-width: 35vw; max-height: 25vh; min-height: 25vh;">
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group row w-100">
                            <label for="caption" class="col-form-label text-center">Caption</label>    
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
                @endforeach
            @else
            @endif

            @if(($eventImages['evidences']->isNotEmpty()) || ($eventImages['posters']->isNotEmpty()))
                <div class="flex-row my-2 text-center">
                    <button class="btn btn-primary text-white" type="submit">Add Captions</button>
                </div>
            @endif
            </div>
        </div>
    </form>

    <hr>

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
