@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{ route('maintenances.organizationDocumentTypes.store', ['organizationSlug' => $organization->organization_slug]) }}" enctype="multipart/form-data" method="POST" id="organizationDocumentTypeCreateForm">
        @csrf
        <div class="row">
            <div class="col-md-12">
                
                {{-- Title and Breadcrumbs --}}
                <div class="d-flex justify-content-between align-items-center">
                    {{-- Title --}}
                    <h2 class="display-7 text-left text-break">Create Organization Document Type</h2>
                    {{-- Breadcrumbs --}}
                    <nav aria-label="breadcrumb align-items-center">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('maintenances.organizationDocumentTypes.index', ['organizationSlug' => $organization->organization_slug])}}" class="text-decoration-none">{{ $organization->organization_acronym . ' Documents Types' }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="card mb-3">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">New Document Type</h5>
                    <div class="card-body">
                        <div class="form-group row my-1">
                            <label for="documentType" class="col-md-4 col-form-label align-middle fw-bold">Document Type</label>
                            <input id="documentType" 
                                type="text" 
                                class="form-control @error('documentType') is-invalid @enderror" 
                                name="documentType" 
                                id="documentType" 
                                placeholder="Document Type"
                                value="{{ old('documentType') }}" 
                                required>
                            @error('documentType')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="flex-row my-2 text-center">
                            <button class="btn btn-primary text-white" type="submit">
                                <i class="fas fa-plus"></i> Add Document Type
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="flex-row my-2 text-center">
            <a href="{{route('maintenances.organizationDocumentTypes.index', ['organizationSlug' => $organization->organization_slug])}}"
                class="btn btn-secondary text-white"
                role="button">
                    <i class="fas fa-arrow-left"></i> Go Back
            </a>

            <span>or</span>

            <a href="{{route('home')}}"
                class="btn btn-secondary text-white"
                role="button">
                    <i class="fas fa-home"></i> Go Home
            </a>
        </div>
    </form>
</div>
@endsection
