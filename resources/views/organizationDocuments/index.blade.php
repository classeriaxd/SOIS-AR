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
                <h2 class="display-7 text-left text-break">{{$organization->organization_acronym}} Documents</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Organization Documents
                        </li>
                    </ol>
                </nav>
            </div>

            @if($organizationDocumentTypes->isNotEmpty())
                @foreach($organizationDocumentTypes as $organizationDocumentType)
                    <div class="card my-1">
                        <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">{{ $organizationDocumentType->type }}</h5>
                        <div class="card-body">
                            <table class="table table-striped table-hover table-bordered border border-dark" id="documentTable">
                                @if($organizationDocumentType->organizationDocuments->isNotEmpty())
                                    <thead class="text-white fw-bold bg-maroon">
                                        <th class="text-center" scope="col">#</th>
                                        <th class="text-center" scope="col">Title</th>
                                        <th class="text-center" scope="col">Uploaded on</th>
                                        <th class="text-center" scope="col" data-sortable="false">Options</th>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach($organizationDocumentType->organizationDocuments as $document)
                                            @if($loop->index == 3)
                                            @break
                                            @endif
                                        <tr>
                                            <td scope="row" class="text-center">{{ $i }}</td>
                                            <td>{{ $document->title }}</td>
                                            <td>{{date_format(date_create($document->created_at), 'F d, Y')}}</td>
                                            <td class="text-center">
                                                <a href="{{route('organizationDocuments.show', 
                                                ['organizationSlug' => $organization->organization_slug,
                                                 'organizationDocumentTypeSlug' => $organizationDocumentType->slug, 
                                                 'organizationDocumentID' => $document->organization_document_id])}}" 
                                                    class="btn btn-primary" 
                                                    role="button" 
                                                    target="_blank">
                                                        <span class="fas fa-external-link-alt text-white"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        @php $i += 1; @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <a href="{{route('organizationDocuments.documentTypeIndex', 
                                                ['organizationSlug' => $organization->organization_slug,
                                                 'organizationDocumentTypeSlug' => $organizationDocumentType->slug,])}}" 
                                                    class="btn btn-primary text-white" 
                                                    role="button" 
                                                    target="_blank">
                                                        View all {{ $organizationDocumentType->type }}
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                No {{$organizationDocumentType->type}} to display. You can upload one <a href="{{route('organizationDocuments.create', ['organizationSlug' => $organization->organization_slug,
                                                 'organizationDocumentTypeSlug' => $organizationDocumentType->slug,])}}" style="color:blue;"><u>here</u></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                    
                @endforeach
            
                
            @else
            <p class="text-center">
                No Organization Document Type Found. :(.
            </p>
            @endif
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

        <a href="{{route('maintenances.organizationDocumentTypes.index', ['organizationSlug' => $organization->organization_slug])}}"
            class="btn btn-primary text-white"
            role="button">
           <i class="fas fa-th"></i> Go to Organization Document Types
        </a>
    </div>

</div>
@endsection

@push('scripts')
    {{-- Import Datatables --}}
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
@endpush

