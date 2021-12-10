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
            {{-- Error Alert --}}
                @if (session()->has('error'))
                    <div class="flex-row text-center" id="error_alert">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">{{$organization->organization_acronym}} Organization Document Types</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $organization->organization_acronym . ' Organization Documents Types' }}
                        </li>
                    </ol>
                </nav>
            </div>
            
            <div class="flex-row my-2 text-center">
                <a href="{{ route('maintenances.organizationDocumentTypes.create', ['organizationSlug' => $organization->organization_slug]) }}"
                    class="btn btn-primary text-white"
                    role="button">
                        <i class="fas fa-plus"></i> Add Document Type
                </a>
            </div>

            <div class="card w-100">
                <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Document Types</h5>

                <table class="w-100 my-1 table table-bordered table-striped table-hover border border-dark">
                    <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                        <th>#</th>
                        <th>Type</th>
                        <th>Total Documents</th>
                        <th>Slug</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach($organizationDocumentTypes as $organizationDocumentType)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $organizationDocumentType->type }}</td>
                            <td>{{ $organizationDocumentType->organization_documents_count }}</td>
                            <td>{{ $organizationDocumentType->slug }}</td>
                            <td class="text-center">
                                <a class="btn btn-success text-white" 
                                    href="{{ route('maintenances.organizationDocumentTypes.show',  ['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug]) }}" 
                                    role="button">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-primary text-white" 
                                    href="{{ route('maintenances.organizationDocumentTypes.edit', ['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug]) }}" 
                                    role="button">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @php $i += 1; @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Deleted Organization Document Types Table --}}
            @if($deletedOrganizationDocumentTypes->isNotEmpty())
                <div class="card w-100 mt-5 mb-2">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Deleted Document Types</h5>

                    <table class="table my-1 table-striped table-hover table-bordered border border-dark" id="deletedDocumentTypeTable">
                        <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                            <th>#</th>
                            <th>Type</th>
                            <th>Total Documents</th>
                            <th>Slug</th>
                            <th>Option</th>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach($deletedOrganizationDocumentTypes as $organizationDocumentType)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $organizationDocumentType->type }}</td>
                                <td>{{ $organizationDocumentType->organization_documents_count }}</td>
                                <td>{{ $organizationDocumentType->slug }}</td>
                                <td class="text-center">
                                    <form action="{{ route('maintenances.organizationDocumentTypes.restore',  ['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success text-white">
                                            <i class="fas fa-trash-restore"></i> Restore Document Type
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php $i += 1; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif  
            
            <div class="flex-row my-2 text-center">
                <a href="{{ route('home') }}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-home"></i> Go Home
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

