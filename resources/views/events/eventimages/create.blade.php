@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('event.image.store', ['event_slug' => $event->slug])}}" enctype="multipart/form-data" method="POST" id="eventImageForm">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                {{-- Title and Breadcrumbs --}}
                <div class="row">
                    {{-- Title --}}
                    <h2 class="display-2 text-center">New Event Image</h2>
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
                                Create Images
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="row text-center">
        <div class="col">
            <div class="card mb-3">
            <div class="card-header text-center text-white bg-maroon" >
                    <small>Only Images are allowed. Max size per file is 3MB. Up to 5 Images per category can be uploaded.</small>
                </div>
                <div class="d-flex flex-row justify-content-center align-items-center my-1">
                    <h6 class="display-6 me-1">Posters</h6>
                    <a role="button"
                        data-bs-toggle="popover" 
                        data-bs-container="body"
                        data-bs-trigger="hover focus"
                        title="Posters" 
                        data-bs-content="Posters that are made exclusively for this Event. Portrait Orientation is a must."
                        data-bs-placement="right">
                        <i class="far fa-question-circle"></i>
                    </a>
                </div>
                <input type="file" 
                    class="filepond @error('poster[]') is-invalid @enderror" 
                    name="poster[]" 
                    id="poster"
                    accept="image/png, image/jpeg, image/jpg"
                    multiple
                    data-max-file-size="3MB"
                    data-max-files="5">
                @error('poster[]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <br>

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
                <input type="file" 
                    class="filepond @error('evidence[]') is-invalid @enderror" 
                    name="evidence[]" 
                    id="evidence" 
                    accept="image/png, image/jpeg, image/jpg" 
                    multiple
                    data-max-file-size="3MB"
                    data-max-files="5">
                @error('evidence[]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="flex-row my-2 text-center">
                    <button class="btn btn-primary text-white" type="submit">
                        <i class="fas fa-plus"></i> Add Images
                    </button>
                </div>
            </div>
        </div>
    </form>

    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{route('event.show', ['event_slug' => $event->slug])}}"
        class="btn btn-secondary text-white"
        role="button">
            <i class="fas fa-arrow-left"></i> Go back
        </a>
    </div>
</div>
{{-- 
                <div class="form-group row">
                    <label for="poster_caption" class="col-md-4 col-form-label">Poster Caption</label>
                    <input id="poster_caption" 
                    type="text" 
                    class="form-control @error('poster_caption') is-invalid @enderror" 
                    name="poster_caption" 
                    value="{{ old('poster_caption') }}" autocomplete="poster_caption">
                    @error('poster_caption')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> 
                <div class="form-group row">
                    <label for="evidence_caption" class="col-md-4 col-form-label">Caption</label>
                    <input id="evidence_caption" 
                    type="text" 
                    class="form-control @error('evidence_caption') is-invalid @enderror" 
                    name="evidence_caption" 
                    value="{{ old('evidence_caption') }}" autocomplete="evidence_caption">
                    @error('evidence_caption')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>--}}
@endsection


@if($filePondJS ?? false)
    @push('scripts')
        {{-- FilePond CSS --}}
        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet"> 
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"> 
    @endpush

    @push('footer-scripts')
        {{-- FilePond JS --}}
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    @endpush
@endif

@section('scripts')
    <script type="module">
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileEncode);

        const evidenceInputElement = document.getElementById('evidence');
        FilePond.create( evidenceInputElement, {
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg',],
            allowFileSizeValidation: true,
            maxFileSize: '3MB',
            allowMultiple: true,
            maxFiles: '5',
            allowFileEncode: true,
            labelFileTypeNotAllowed: 'Only Images [ PNG / JPEG / JPG ] are allowed.',
            labelIdle: 'Drop an Image here or <span class="filepond--label-action"> Browse </span>',
            });
        const posterInputElement = document.getElementById('poster');
        FilePond.create( posterInputElement, {
            name: "poster",
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg',],
            allowFileSizeValidation: true,
            maxFileSize: '3MB',
            allowMultiple: true,
            maxFiles: '5',
            allowFileEncode: true,
            labelFileTypeNotAllowed: 'Only Images [ PNG / JPEG / JPG ] are allowed.',
            labelIdle: 'Drop an Image here or <span class="filepond--label-action"> Browse </span>',
            });

        FilePond.setOptions({
            server: {
                url: '/e/images/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                revert: '/revert',
            }
        });
    </script>
    <script type="text/javascript">
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
    </script>
@endsection
