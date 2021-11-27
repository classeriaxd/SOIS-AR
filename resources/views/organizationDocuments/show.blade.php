@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Success Alert --}}
                @if (session()->has('success'))
                    <div class="flex-row text-center" id="success_alert">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">{{ $organizationDocumentType->type }}</h2>
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
                            {{ $organizationDocument->title }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="card">
                <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">{{$organizationDocument->title}}</h5>
                <div class="card-body">
                    <iframe src="/storage{{$organizationDocument->file}}#toolbar=0" width="100%" style="height:70vh;">
                    </iframe>

                    <div class="flex-row my-2 text-center">
                        <div class="mb-1">
                            <a href="{{route('organizationDocuments.edit',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug, 'organizationDocumentID' => $organizationDocument->organization_document_id])}}"
                                class="btn btn-secondary text-white"
                                role="button">
                                <i class="fas fa-edit"></i> Edit Document Details
                            </a>
                        </div>

                        <div>
                            <button class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#areYouSureModal">
                                <i class="fas fa-trash"></i> Delete Document
                            </button>
                        </div>
                    </div>

                </div>
            </div>
                    
        </div>

        {{-- Are you sure Modal --}}
        <div class="modal fade" id="areYouSureModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="areYouSureModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="areYouSureModal">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    Are you Sure?
                    </div>
                    <div class="modal-footer">
                        <form action="{{route('organizationDocuments.destroy',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug, 'organizationDocumentID' => $organizationDocument->organization_document_id])}}" method="POST">
                            @method('DELETE')
                            @csrf
                        
                            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                            <button type="submit" class="btn btn-danger text-white"><i class="fas fa-check"></i> Understood</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    
    <div class="flex-row my-2 text-center">
        <a href="{{route('home')}}"
        class="btn btn-secondary text-white"
        role="button">
            <i class="fas fa-home"></i> Go Home
        </a>

        <span>or</span>

        <a href="{{route('organizationDocuments.documentTypeIndex',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug,])}}"
            class="btn btn-secondary text-white"
            role="button">
            <i class="fas fa-arrow-left"></i> Go back to {{ $organizationDocumentType->type }}
        </a>

        @if($newDocument ?? false)
            <span>or</span>

            <a href="{{route('organizationDocuments.create',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug,])}}"
                class="btn btn-primary text-white"
                role="button">
                <i class="fas fa-plus"></i> Upload Another {{ $organizationDocumentType->type }}
            </a>
        @endif
    </div>

</div>
@endsection


