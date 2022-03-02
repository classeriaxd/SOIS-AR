@extends('layouts.app')
@section('style')
  @endsection
@section('content')


<div class="container"> 
    <form action="{{route('studentAccomplishment.store')}}" enctype="multipart/form-data" method="POST" id="studentAccomplishmentForm"
    onsubmit="document.getElementById('submitButton').disabled=true;">
        @csrf
        <div class="row">
            <div class="col-md-12">
                {{-- Title and Breadcrumbs --}}
                <div class="d-flex justify-content-between align-items-center">
                    {{-- Title --}}
                    <h2 class="display-7 text-left text-break">Add Accomplishment</h2>
                    {{-- Breadcrumbs --}}
                    <nav aria-label="breadcrumb align-items-center">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('studentAccomplishment.index')}}" class="text-decoration-none">
                                    My Accomplishments
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create Accomplishment
                            </li>
                        </ol>
                    </nav>
                </div>

                {{-- Create Page --}}
                <div class="col">
                    <div class="card mb-3">
                        <div class="card-header text-white bg-maroon">DETAIL</div>
                        <div class="card-body">

                            {{-- Title --}}
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label">Title<span class="required">*</span></label>
                                <input id="title" 
                                type="text" 
                                class="form-control typeahead @error('title') is-invalid @enderror" 
                                name="title" 
                                placeholder="Accomplishment Title"
                                value="{{ old('title') }}" 
                                required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label">Description<span class="required">*</span></label>    
                                <textarea id="description" 
                                class="form-control @error('description') is-invalid @enderror" 
                                name="description"
                                placeholder="Accomplishment Description" 
                                required>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            {{-- Objectives --}}
                            <div class="form-group row">
                                <label for="objective" class="col-md-4 col-form-label">Objective<span class="required">*</span></label>
                                <textarea id="objective" 
                                class="form-control @error('objective') is-invalid @enderror" 
                                name="objective"
                                placeholder="Organizer's Objective in making the Event"
                                required>{{ old('objective') }}</textarea>
                                @error('objective')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Organizer --}}
                            <div class="form-group row">
                                <label for="organizer" class="col-md-4 col-form-label">Organizer<span class="required">*</span></label>
                                <input id="organizer" 
                                type="text" 
                                class="form-control @error('organizer') is-invalid @enderror" 
                                name="organizer" 
                                placeholder="Event Organizer / Certifying Body / Sponsor"
                                value="{{ old('organizer') }}" 
                                required>
                                @error('organizer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Venue --}}
                            <div class="form-group row">
                                <label for="venue" class="col-md-4 col-form-label">Venue<span class="required">*</span></label>
                                <input id="venue" 
                                type="text" 
                                class="form-control @error('venue') is-invalid @enderror" 
                                name="venue"
                                placeholder="Venue (Ex. Zoom or Facebook Live)"  
                                value="{{ old('venue') }}">
                                @error('venue')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Dates --}}
                            <div class="form-group row mt-1">
                                {{-- Start Date --}}
                                <div class="col">
                                    <label for="startDate" class="col-md-4 form-label">Start Date<span class="required">*</span></label>
                                    <input id="startDate" 
                                    type="date" 
                                    class="form-control @error('startDate') is-invalid @enderror" 
                                    name="startDate" 
                                    value="{{ old('startDate') }}" 
                                    min="1992-01-01" 
                                    max="{{date('Y-m-d')}}"
                                    required>
                                    @error('startDate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- End Date --}}
                                <div class="col">
                                    <label for="endDate" class="col-md-4 form-label">End Date<span class="required">*</span></label>
                                    <input id="endDate" 
                                    type="date" 
                                    class="form-control @error('endDate') is-invalid @enderror" 
                                    name="endDate" 
                                    value="{{ old('endDate') }}"
                                    min="1992-01-01" 
                                    max="{{date('Y-m-d')}}"
                                    required>
                                    @error('endDate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>  
                            </div>

                            {{-- Time --}}
                            <div class="form-group row mt-1">
                                {{-- Start Time --}}
                                <div class="col form-group">
                                    <label for="startTime" class="col-md-4 col-form-label">Start Time<span class="required">*</span></label>
                                    <input id="startTime" 
                                    type="time" 
                                    class="form-control @error('startTime') is-invalid @enderror" 
                                    name="startTime" 
                                    value="{{ old('startTime') }}"
                                    required>
                                    @error('startTime')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- End Time --}}
                                <div class="col form-group">
                                    <label for="endTime" class="col-md-4 col-form-label">End Time<span class="required">*</span></label>
                                    <input id="endTime" 
                                    type="time" 
                                    class="form-control @error('endTime') is-invalid @enderror" 
                                    name="endTime" 
                                    value="{{ old('endTime') }}"
                                    required>
                                    @error('endTime')
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
            
            <hr>

            <div class="card mb-3">
                <div class="card-header text-center text-white bg-maroon">
                    <h4>Evidences</h4>
                    <h6>Include a certificate and some screenshots of the event/accomplishment.</h6>
                    <h6>Only Images and PDF are allowed. Max size is 3MB. Up to 3 Files can be uploaded.</h6>
                </div>
                <div class="card-body">

                    {{-- Evidence 1 --}}
                    <input type="file" 
                            class="filepond @error('evidence1') is-invalid @enderror my-1"
                            name="evidence1" 
                            id="evidence1"
                            data-max-file-size="2MB"
                            required>
                    @error('evidence1')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    {{-- Caption 1 --}}
                    <div class="form-group row">
                        <input id="caption1" 
                        type="text" 
                        class="form-control @error('caption1') is-invalid @enderror" 
                        name="caption1"
                        placeholder="Caption" 
                        value="{{ old('caption1') }}" 
                        required>
                        @error('caption1')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <select class="form-select" name="documentType1" required>
                            <option selected disabled>Select Document Type here<span class="required">*</span></option>
                            @foreach($documentTypes as $documentType)
                                <option value="{{$documentType->SA_document_type_id}}">{{$documentType->document_type}}</option>
                            @endforeach
                        </select>
                        @error('documentType1')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <hr class="my-4">

                    {{-- Evidence 2 --}}
                    <input type="file" 
                            class="filepond @error('evidence2') is-invalid @enderror"
                            name="evidence2" 
                            id="evidence2"
                            data-max-file-size="2MB">
                    @error('evidence2')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    {{-- Caption 2 --}}
                    <div class="form-group row">
                        <input id="caption2" 
                        type="text" 
                        class="form-control @error('caption2') is-invalid @enderror" 
                        name="caption2" 
                        placeholder="Caption" 
                        value="{{ old('caption2') }}">
                        @error('caption2')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <select class="form-select" name="documentType2">
                            <option selected disabled>Select Document Type here</option>
                            @foreach($documentTypes as $documentType)
                                <option value="{{$documentType->SA_document_type_id}}">{{$documentType->document_type}}</option>
                            @endforeach
                        </select>
                        @error('documentType2')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <hr class="my-4">

                    {{-- Evidence 3 --}}
                    <input type="file" 
                            class="filepond @error('evidence3') is-invalid @enderror"
                            name="evidence3" 
                            id="evidence3"
                            data-max-file-size="2MB">
                    @error('evidence3')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 

                    {{-- Caption 3 --}}
                    <div class="form-group row">
                        <input id="caption3" 
                        type="text" 
                        class="form-control @error('caption3') is-invalid @enderror" 
                        name="caption3" 
                        placeholder="Caption" 
                        value="{{ old('caption3') }}">
                        @error('caption3')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <select class="form-select" name="documentType3">
                            <option selected disabled>Select Document Type here</option>
                            @foreach($documentTypes as $documentType)
                                <option value="{{$documentType->SA_document_type_id}}">{{$documentType->document_type}}</option>
                            @endforeach
                        </select>
                        @error('documentType3')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="flex-row my-2 text-center">
                    <button id="submitButton" type="submit" class="btn btn-primary text-white fw-bold fs-6"><i class="fas fa-plus"></i> Add Accomplishment</button>
                </div>
            </div>
        </div>
    </form>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('home') }}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-home"></i> Go Home
        </a>
    </div>

</div>
@endsection

@if($filePondJS ?? false)
    @push('scripts')
        {{-- FilePond CSS --}}
        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">     
    @endpush

    @push('footer-scripts')
        {{-- FilePond JS --}}
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    @endpush
@endif

@if($typeAheadJS ?? false)
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js" defer></script>
    @endpush
@endif

@section('scripts')
    <script type="module">
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // Get a reference to the file input element
        const mainInputElement = document.getElementById('evidence1');
        FilePond.create( mainInputElement, {
          acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'],
          labelFileTypeNotAllowed: 'Only Images [ PNG / JPEG / JPG ] and PDF Documents [PDF] are allowed.',
          labelIdle: 'Drop an Image/PDF here first or <span class="filepond--label-action"> Browse </span>',
          });

        const otherInputElements = document.querySelectorAll('input.filepond:not(#evidence1)');
        // Create a FilePond instance
        Array.from(otherInputElements).forEach(inputElement => {

          // create a FilePond instance at the input element location
          FilePond.create( inputElement, {
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'],
            labelFileTypeNotAllowed: 'Only Images [ PNG / JPEG / JPG ] and PDF [PDF] are allowed.',
            labelIdle: 'Drop here next or <span class="filepond--label-action"> Browse </span>',
            });

        })

        FilePond.setOptions({
            server: {
                url: '{{route('studentAccomplishment.documents.upload')}}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                revert: '{{route('studentAccomplishment.documents.undoUpload')}}',
            }
        });
    </script>

    {{-- Bloodhound TypeAhead --}}
    {{-- Requires JQuery --}}
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            // Set the Options for "Bloodhound" suggestion engine
            var engine = new Bloodhound({
                remote: {
                    url: '{{ route('event.find', ['event' => '%QUERY%']) }}',
                },
                datumTokenizer: Bloodhound.tokenizers.whitespace('event'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
            });

            // Get Input
            $("#title").typeahead({
                hint: true,
                highlight: true,
                minLength: 0,
            },
            {
                source: engine.ttAdapter(),

                // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'eventList',
                // Key to Display
                display: 'title',
                // Number of suggestions to display
                limit: 10,
                templates: 
                {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">Suggested Events'
                    ],
                    suggestion: function (data) 
                    {
                        return '<a class="list-group-item">' + data.title + ' ('+ data.start_date +')'+'</a>'
                    }
                }
            });
        });
    </script>
    
    <link href="{{ asset('css/typeaheadjs.css') }}" rel="stylesheet">
@endsection
