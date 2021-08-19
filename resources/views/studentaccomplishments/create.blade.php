@extends('layouts.app')

@section('content')

<div class="container">
    <form action="/s/accomplishments" enctype="multipart/form-data" method="POST" id="studentAccomplishmentForm">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                <h2 class="text-center">Add Accomplishment</h2>
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Title</label>
                    <input id="title" 
                    type="text" 
                    class="form-control @error('title') is-invalid @enderror" 
                    name="title" 
                    value="{{ old('title') }}" 
                    required>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label">Description</label>    
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" 
                    name="description"
                    required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="evidences" class="col-md-4 col-form-label">Evidences</label>
                </div>
                <input type="file" 
                        class="filepond @error('evidence1') is-invalid @enderror"
                        name="evidence1" 
                        id="evidence1"
                        data-max-file-size="2MB"
                        required>
                @error('evidence1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <input type="file" 
                        class="filepond @error('evidence2') is-invalid @enderror"
                        name="evidence2" 
                        id="evidence2"
                        data-max-file-size="2MB">
                @error('evidence2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <input type="file" 
                        class="filepond @error('evidence3') is-invalid @enderror"
                        name="evidence3" 
                        id="evidence3"
                        data-max-file-size="2MB">
                @error('evidence3')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="text-center">
                    <small>Images are only allowed. Max size is 3MB. Up to 3 Files can be uploaded.</small>
                </div> 
                <div class=" form-group row justify-content-center mt-3">
                    <button class="btn btn-primary">Add Accomplishment</button>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <div class="row justify-content-center">
        <a href="/home">
            <button class="btn btn-secondary">Go back</button>
        </a>
    </div>
</div>
@endsection

@if($filePondJS ?? false)
    @push('scripts')
        {{-- FilePond CSS --}}
        <link href="{{ asset('css/filepond.css') }}" rel="stylesheet"> 
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">     
    @endpush

    @push('footer-scripts')
        {{-- FilePond JS --}}
        <script src="{{ asset('js/filepond.js') }}" type="text/javascript"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    @endpush
@endif

@section('scripts')
    <script type="module">
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginImagePreview);
        // Get a reference to the file input element
        FilePond.setOptions({
            server: {
                url: '/s/accomplishments/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                revert: '/revert',
            }
        });

        const mainInputElement = document.getElementById('evidence1');
        FilePond.create( mainInputElement, {
          acceptedFileTypes: ['image/png', 'image/jpeg'],
          labelFileTypeNotAllowed: 'Only Images [ PNG / JPEG ] are allowed.',
          labelIdle: 'Drop an Image here First or <span class="filepond--label-action"> Browse </span>',
          });

        const otherInputElements = document.querySelectorAll('input.filepond:not(#evidence1)');
        // Create a FilePond instance
        Array.from(otherInputElements).forEach(inputElement => {

          // create a FilePond instance at the input element location
          FilePond.create( inputElement, {
            acceptedFileTypes: ['image/png', 'image/jpeg'],
            labelFileTypeNotAllowed: 'Only Images [ PNG / JPEG ] are allowed.',
            labelIdle: 'Drop here next or <span class="filepond--label-action"> Browse </span>',
            });

        })

        FilePond.setOptions({
            server: {
                url: '/s/accomplishments/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                revert: '/revert',
            }
        });
    </script>
@endsection
