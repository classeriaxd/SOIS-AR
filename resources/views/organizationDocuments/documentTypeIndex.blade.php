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
                <h2 class="display-7 text-left text-break">{{$organization->organization_acronym}} {{ $organizationDocumentType->type }} Documents</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('organizationDocuments.index',['organizationSlug' => $organization->organization_slug,])}}" class="text-decoration-none">{{ $organization->organization_acronym . ' Documents' }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $organizationDocumentType->type }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="card">
                <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">{{ $organizationDocumentType->type }}</h5>
                <div class="card-body">

                    <div class="flex-row my-2 text-center">
                        <a href="{{route('organizationDocuments.create', ['organizationSlug' => $organization->organization_slug,
                                         'organizationDocumentTypeSlug' => $organizationDocumentType->slug,])}}"
                            class="btn btn-primary text-white"
                            role="button">
                                <i class="fas fa-plus"></i> Upload {{ $organizationDocumentType->type }}
                        </a>
                    </div>

                    <table class="table table-striped table-hover table-bordered border border-dark" id="documentTable">
                        @if($organizationDocuments->isNotEmpty())
                            <thead class="text-white fw-bold bg-maroon">
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">Title</th>
                                <th class="text-center" scope="col">Uploaded on</th>
                                <th class="text-center" scope="col" data-sortable="false">Options</th>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach($organizationDocuments as $document)
                                    <tr>
                                        <td scope="row" class="text-center">{{ $i }}</td>
                                        <td>{{ $document->title }}</td>
                                        <td>{{date_format(date_create($document->created_at), 'F d, Y')}}</td>
                                        <td class="text-center">
                                            <a href="{{route('organizationDocuments.show', 
                                            ['organizationSlug' => $organization->organization_slug,
                                             'organizationDocumentTypeSlug' => $organizationDocumentType->slug, 
                                             'organizationDocumentID' => $document->organization_document_id])}}" 
                                                class="btn btn-success text-white" 
                                                role="button" 
                                                target="_blank">
                                                    <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{route('organizationDocuments.edit',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug, 'organizationDocumentID' => $document->organization_document_id])}}"
                                                class="btn btn-primary text-white"
                                                role="button"
                                                target="_blank">
                                                    <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @php $i += 1; @endphp
                                @endforeach
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

                    {{-- Organization Documents Table Pager --}}
                    <div class="d-flex justify-content-center">
                        @if($deletedOrganizationDocuments->isNotEmpty())
                            {{ 
                                $organizationDocuments->appends([
                                    'documents' => $organizationDocuments->currentPage(),
                                    'deletedDocuments' => $deletedOrganizationDocuments->currentPage(),
                                ])->links() 
                            }}
                        @else
                            {{ $organizationDocuments->links() }}
                        @endif
                    </div>
                    
                </div>
            </div>
            
            @if($deletedOrganizationDocuments->isNotEmpty())
                <div class="card w-100 mt-5 mb-2">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Deleted {{ $organizationDocumentType->type }}</h5>

                    <table class="table table-striped table-hover table-bordered border border-dark" id="deletedDocumentTable">
                        <thead class="text-white fw-bold bg-maroon">
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Title</th>
                            <th class="text-center" scope="col">Uploaded on</th>
                            <th class="text-center" scope="col" data-sortable="false">Options</th>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($deletedOrganizationDocuments as $document)
                                <tr>
                                    <td scope="row" class="text-center">{{ $i }}</td>
                                    <td>{{ $document->title }}</td>
                                    <td>{{date_format(date_create($document->created_at), 'F d, Y')}}</td>
                                    <td class="text-center">
                                        <form action="{{route('organizationDocuments.restore',['organizationSlug' => $organization->organization_slug, 'organizationDocumentTypeSlug' => $organizationDocumentType->slug, 'organizationDocumentID' => $document->organization_document_id])}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success text-white">
                                                <i class="fas fa-trash-restore"></i> Restore Document
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $i += 1; @endphp
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Deleted Organization Document Pager --}}
                    <div class="d-flex justify-content-center">
                        @if($organizationDocuments->isNotEmpty())
                            {{ 
                                $deletedOrganizationDocuments->appends([
                                    'documents' => $organizationDocuments->currentPage(),
                                    'deletedDocuments' => $deletedOrganizationDocuments->currentPage(),
                                ])->links() 
                            }}
                        @else
                            {{ $deletedOrganizationDocuments->links() }}
                        @endif
                    </div>
                </div>
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

        <a href="{{route('organizationDocuments.index',['organizationSlug' => $organization->organization_slug,])}}"
        class="btn btn-secondary text-white"
        role="button">
            <i class="fas fa-arrow-left"></i> Go Back to Organization Documents
        </a>
    </div>

</div>
@endsection

@push('scripts')
    {{-- Import Datatables --}}
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
@endpush

@section('scripts')
    <script type="module">
        // Simple-DataTables
        // https://github.com/fiduswriter/Simple-DataTables
        window.addEventListener('DOMContentLoaded', event => {
            const dataTable = new simpleDatatables.DataTable("#documentTable", {
                perPage: 30,
                searchable: true,
                labels: {
                    placeholder: "Search Documents...",
                    noRows: "No documents to display in this page or try in the next page.",
                },
            });
            const dataTable2 = new simpleDatatables.DataTable("#deletedDocumentTable", {
                perPage: 30,
                searchable: true,
                labels: {
                    placeholder: "Search Documents...",
                    noRows: "No documents to display in this page or try in the next page.",
                },
            });
        });
    </script>
@endsection

