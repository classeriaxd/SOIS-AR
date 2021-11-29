@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Title and Breadcrumbs --}}
    <div class="d-flex justify-content-between align-items-center">
        {{-- Title --}}
        <h2 class="display-7 text-left text-break">Upload {{ $organizationDocumentType->type }}</h2>
        {{-- Breadcrumbs --}}
        <nav aria-label="breadcrumb align-items-center">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item">
                    <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{route('organizationDocuments.index',['organizationSlug' => $organization->organization_slug,])}}" class="text-decoration-none">{{ $organization->organization_acronym . ' Documents' }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{route('organizationDocuments.documentTypeIndex',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug,])}}" class="text-decoration-none">{{ $organizationDocumentType->type }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Upload Document
                </li>
            </ol>
        </nav>
    </div>

    {{-- Organization Document Create Form --}}
    <form action="{{route('organizationDocuments.store',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug,])}}" enctype="multipart/form-data" method="POST" id="organizationDocumentCreateForm">
        <div class="row">
            <div class="col">
                <div class="card mb-2">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">New Document</h5>
                    <div class="card-body">

                        {{-- Document Title --}}
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label">Title<span class="required">*</span></label>
                            <input id="title" 
                                type="text" 
                                class="form-control @error('title') is-invalid @enderror" 
                                name="title"
                                placeholder="Document Title" 
                                value="{{ old('title') }}" 
                                autofocus 
                                required>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Document Description --}}
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label">Description<span class="required">*</span></label>    
                            <textarea id="description" 
                                class="form-control @error('description') is-invalid @enderror" 
                                name="description"
                                placeholder="Description" 
                                required>{{ old('description') ?? ''}}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Effective Date --}}
                        <div class="form-group row">
                            <label for="effective_date" class="col-md-4 form-label">Effective Date<span class="required">*</span></label>
                            <input id="effective_date" 
                                type="date" 
                                class="form-control @error('effective_date') is-invalid @enderror" 
                                name="effective_date" 
                                value="{{ old('effective_date') }}" 
                                min="1992-01-01" 
                                max="{{date('Y-m-d')}}"
                                required>
                            @error('effective_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Document Upload --}}
                        <div class="d-flex flex-row justify-content-center align-items-center my-1">
                            <h6 class="display-6 my-1">Document</h6>
                        </div>
                        <input type="file" 
                            class="filepond @error('document') is-invalid @enderror" 
                            name="document" 
                            id="document" 
                            accept="application/pdf" 
                            data-max-file-size="3MB"
                            data-max-files="1">
                        @error('document')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

           <div class="flex-row my-2 text-center">
                @csrf
                <button class="btn btn-primary text-white col-md-12" type="submit">
                    <i class="fas fa-plus"></i> Add Document
                </button>
            </div> 
        </div>     
    </form>

    <hr>

    <div class="flex-row my-1 text-center">
        <a href="{{route('organizationDocuments.documentTypeIndex',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug,])}}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-arrow-left"></i> Go Back to {{ $organizationDocumentType->type }} Documents
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
        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet">
    @endpush

    @push('footer-scripts')
        {{-- FilePond JS --}}
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    @endpush
@endif

@section('scripts')
    {{-- FilePondJS Upload --}}
    <script type="module">
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        // Get a reference to the file input element
        const mainInputElement = document.getElementById('document');
        FilePond.create( mainInputElement, {
          acceptedFileTypes: ['application/pdf'],
          labelFileTypeNotAllowed: 'Only PDF Documents [PDF] are allowed.',
          labelIdle: 'Drop a PDF here or <span class="filepond--label-action"> Browse </span>',
          });

        FilePond.setOptions({
            server: {
                url: '{{route('organizationDocuments.documents.upload',['organizationSlug' => $organization->organization_slug])}}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                revert: '{{route('organizationDocuments.documents.undoUpload',['organizationSlug' => $organization->organization_slug])}}',
            }
        });
    </script>
@endsection
