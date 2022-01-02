@extends('layouts.admin-app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">{{ $organizationDocumentType->type}}</h2>
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
                            {{ $organizationDocumentType->type}}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="card mb-3">
                <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Document Type</h5>
                <div class="card-body">
                    <div class="row my-2">
                        <h5 class="card-text text-center">{{$organizationDocumentType->type}}</h5>
                        <p class="card-text text-center"><span class="fw-bold">Slug: </span>{{$organizationDocumentType->slug}}</p>
                        <p class="card-text text-center"><span class="fw-bold">Last Updated: </span>{{$organizationDocumentType->updated_at ?? 'NONE'}}</p>
                    </div>
                    <div class="flex-row my-2 text-center">
                        <a class="btn btn-primary text-white" 
                            href="{{ route('maintenances.organizationDocumentTypes.show',  ['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug]) }}" 
                            role="button">
                            <i class="fas fa-edit"></i> Edit Document Type
                        </a>

                        <span>or</span>

                        <button class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#areYouSureModal">
                                <i class="fas fa-trash"></i> Delete Document Type
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
                    <form action="{{ route('maintenances.organizationDocumentTypes.destroy',  ['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug]) }}" method="POST"
                        onsubmit="document.getElementById('deleteButton').disabled=true;">
                        @method('DELETE')
                        @csrf
                    
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button id="deleteButton" type="submit" class="btn btn-danger text-white">
                            <i class="fas fa-check"></i> Understood
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

