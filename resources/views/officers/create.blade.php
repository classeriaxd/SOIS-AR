@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
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
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Update Officer Signature</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('maintenances.officerSignatures.index', ['organizationSlug' => $organization->organization_slug])}}" class="text-decoration-none">{{$organization->organization_acronym}} Officer Signatures</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Update Signature
                        </li>
                    </ol>
                </nav>
            </div>
            @if($officer->signature != NULL)
            <div class="row">
                <div class="card">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Current Signature</h5>
                    <div class="card-body d-flex justify-content-center">
                        <img src="/storage/{{$officer->signature}}" style="max-width: 10em; max-height: 5em; min-height: 5em; min-width: 10em;">
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="card">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Update Signature</h5>
                    <div class="card-body">
                        <form action="{{route('maintenances.officerSignatures.store', ['officerID' => $officer->officer_id, 'organizationSlug' => $organization->organization_slug])}}" enctype="multipart/form-data" method="POST" id="officerSignatureForm"
                            onsubmit="document.getElementById('submitButton').disabled=true;">
                            @csrf

                            {{-- Image --}}
                            <input type="file" 
                                class="filepond @error('signature') is-invalid @enderror"
                                name="signature" 
                                id="signature"
                                data-max-file-size="3MB"
                                required>
                            @error('signature')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror 

                            <div class="flex-row my-2 text-center">
                                <button id="submitButton" type="submit" class="btn btn-primary text-white"><i class="fas fa-upload"></i> Upload Signature</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>      

    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{route('maintenances.officerSignatures.index', ['organizationSlug' => $organization->organization_slug])}}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-arrow-left"></i> Go Back to {{$organization->organization_acronym}} Officer Signatures
        </a>

        <span>or</span>

        <a href="{{route('home')}}"
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
        <link href="{{ asset('css/filepond.css') }}" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">  
    @endpush

    @push('footer-scripts')
        {{-- FilePond JS --}}
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>      
        <script src="{{ asset('js/filepond.js') }}" type="text/javascript"></script>
    @endpush
@endif

@section('scripts')
    {{-- FilePondJS Upload --}}
    <script type="module">
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.registerPlugin(FilePondPluginImagePreview);
        const mainInputElement = document.querySelectorAll('input.filepond');
        // Create a FilePond instance
        Array.from(mainInputElement).forEach(inputElement => {
          // create a FilePond instance at the input element location
          FilePond.create( inputElement, {
            maxFileSize: '3MB',
            acceptedFileTypes: ['image/png'],
            labelFileTypeNotAllowed: 'Only Image [PNG] is allowed.',
            labelIdle: 'Drop an Image here or <span class="filepond--label-action"> Browse </span>',
            });

        });

        FilePond.setOptions({
            server: {
                url: '{{ route('maintenances.officerSignatures.upload') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                revert: '{{ route('maintenances.officerSignatures.undoUpload') }}',
            }
        });
    </script>
@endsection
