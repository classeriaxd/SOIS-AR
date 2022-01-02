@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Title and Breadcrumbs --}}
    <div class="d-flex justify-content-between align-items-center">
        {{-- Title --}}
        <h2 class="display-7 text-left text-break">Edit {{ $organizationDocumentType->type }}</h2>
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
                <li class="breadcrumb-item">
                    <a href="{{route('organizationDocuments.show',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug, 'organizationDocumentID' => $organizationDocument->organization_document_id])}}" class="text-decoration-none">{{ $organizationDocument->title }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Edit Document
                </li>
            </ol>
        </nav>
    </div>

    {{-- Organization Document Create Form --}}
    <form action="{{route('organizationDocuments.update',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug,'organizationDocumentID' => $organizationDocument->organization_document_id])}}" enctype="multipart/form-data" method="POST" id="organizationDocumentEditForm"
        onsubmit="document.getElementById('submitButton').disabled=true;">
        <div class="row">
            <div class="col">
                <div class="card mb-2">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Edit Document</h5>
                    <div class="card-body">

                        {{-- Document Title --}}
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label">Title<span class="required">*</span></label>
                            <input id="title" 
                                type="text" 
                                class="form-control @error('title') is-invalid @enderror" 
                                name="title"
                                value="{{ $organizationDocument->title }}"
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
                                required>{{ $organizationDocument->description }}</textarea>

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
                                value="{{ $organizationDocument->effective_date }}" 
                                min="1992-01-01" 
                                max="{{date('Y-m-d')}}"
                                required>
                            @error('effective_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        {{-- Document Preview --}}
                        <div class="d-flex flex-row justify-content-center align-items-center my-1">
                            <h6 class="display-6 my-1">Document</h6>
                        </div>
                        <div class="row">
                            <div class="col">
                                <iframe src="/storage{{$organizationDocument->file}}#toolbar=0" width="100%" style="height:50vh;">
                                </iframe>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @csrf
            <div class="row my-2 text-center">
                <button id="submitButton" class="btn btn-primary text-white col-md-12" type="submit">
                    <i class="fas fa-edit"></i> Update Document
                </button>
            </div> 
        </div>     
    </form>

    <hr>

    <div class="flex-row my-1 text-center">
        <a href="{{route('organizationDocuments.show',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug, 'organizationDocumentID' => $organizationDocument->organization_document_id])}}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-arrow-left"></i> Go Back to {{ $organizationDocument->title }}
        </a>

        <span>or</span>

        <a href="{{route('organizationDocuments.documentTypeIndex',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug,])}}"
            class="btn btn-secondary text-white"
            role="button">
            <i class="fas fa-arrow-left"></i> Go Back to {{ $organizationDocumentType->type }}
        </a>
    </div>

</div>
@endsection
