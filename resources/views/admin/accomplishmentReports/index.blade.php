@extends('layouts.admin-app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">All Accomplishment Reports</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Accomplishment Reports
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Accomplishment Reports Table --}}
            <div class="row my-2">
                @if($accomplishmentReports->isNotEmpty())

                <div class="d-flex justify-content-center">
                        {{ $accomplishmentReports->links() }}
                </div>

                <table class="table table-striped table-hover table-bordered border border-dark" id="accomplishmentReportTable">
                    <thead class="text-white fw-bold bg-maroon">
                        <th class="text-center" scope="col">#</th>
                        <th class="text-center" scope="col">Org</th>
                        <th class="text-center" scope="col">Type</th>
                        <th class="text-center" scope="col">Title</th>
                        <th class="text-center" scope="col">Inclusive Date</th>
                        <th class="text-center" scope="col">Status</th>
                        <th class="text-center" scope="col" data-sortable="false">Options</th>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($accomplishmentReports as $accomplishmentReport)
                        <tr>
                            <td scope="row" class="text-center">{{ $i }}</td>
                            <td class="text-center">{{ $accomplishmentReport->organization->organization_acronym }}</td>
                            <td>
                                @if($accomplishmentReport->accomplishmentReportType->accomplishment_report_type == 'Tabular')
                                    <i class="fas fa-file-excel fs-2"></i>|{{$accomplishmentReport->accomplishmentReportType->accomplishment_report_type}}
                                @elseif($accomplishmentReport->accomplishmentReportType->accomplishment_report_type == 'Design')
                                    <i class="fas fa-file-pdf fs-2"></i>|{{$accomplishmentReport->accomplishmentReportType->accomplishment_report_type}}
                                @endif
                            </td>
                            <td class="text-break">
                                @if($accomplishmentReport->read_at == NULL)
                                    <span class="badge bg-primary text-white rounded-pill fs-6">New</span>
                                @endif 
                                {{ $accomplishmentReport->title }} 
                            </td>
                            <td class="text-center">
                                {{ date_format(date_create($accomplishmentReport->start_date), 'F d, Y') . ' - ' . date_format(date_create($accomplishmentReport->end_date), 'F d, Y') }}
                            </td>
                            <td class="text-center">
                                @if($accomplishmentReport->status == 1)
                                    <span class="badge bg-warning text-dark rounded-pill fs-6">Pending</span>
                                @elseif($accomplishmentReport->status == 2 && $accomplishmentReport->accomplishmentReportType->accomplishment_report_type == 'Design')
                                    <span class="badge bg-success text-white rounded-pill fs-6">Approved</span>
                                @elseif($accomplishmentReport->status == 2 && $accomplishmentReport->accomplishmentReportType->accomplishment_report_type == 'Tabular')
                                    <span class="badge bg-success text-white rounded-pill fs-6">Automatically Approved</span>
                                @elseif ($accomplishmentReport->status == 3)
                                    <span class="badge bg-danger text-white rounded-pill fs-6">Disapproved</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{route('admin.accomplishmentReports.show', ['organizationSlug' => $accomplishmentReport->organization->organization_slug, 'accomplishmentReportUUID' => $accomplishmentReport->accomplishment_report_uuid])}}" 
                                    class="btn btn-primary text-white" 
                                    role="button" 
                                    target="_blank">
                                        <span class="fas fa-external-link-alt text-white"></span>
                                </a>
                            </td>
                        </tr>
                        @php $i += 1; @endphp
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                        {{ $accomplishmentReports->links() }}
                </div>

                @else
                <p class="text-center">
                    No Accomplishment Report Found. :(
                </p>
                @endif
            </div>

            {{-- Organizations --}}
            <div class="row">
                <h2 class="display-7 text-center">View Accomplishment Reports by Organization</h2>
            </div>
            {{-- Acad Orgs --}}
            <div class="row my-2">
                <div class="col d-flex justify-content-evenly">
                    @if($academicOrganizations->count() > 0)

                        @foreach($academicOrganizations as $organization)
                            <a href="{{ route('admin.accomplishmentReports.organization.index', ['organizationSlug' => $organization->organization_slug]) }}">
                                <div class="card">
                                    @if($organization->logos->count() !== 0)
                                        <img class="card-img-top" src="/storage/{{$organization->logos->first()->file}}" style="max-width: 7em; max-height: 7em; min-height: 7em; min-width: 7em;">
                                    @else
                                        <img class="card-img-top" src="/storage/organization_assets/logo/default_logo.png" style="max-width: 7em; max-height: 7em; min-height: 7em; min-width: 7em;">
                                    @endif
                                    <div class="card-body text-center bg-maroon text-white fw-bold">
                                        <p class="card-title">
                                           {{ $organization->organization_acronym }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                    <p class="text-center">
                        No Organization Found. :(
                    </p>
                    @endif
                </div>
            </div>
            {{-- Non Acad Orgs --}}
            <div class="row my-2">
                <div class="col d-flex justify-content-evenly">
                    @if($nonAcademicOrganizations->count() > 0)

                        @foreach($nonAcademicOrganizations as $organization)
                            <a href="{{ route('admin.accomplishmentReports.organization.index', ['organizationSlug' => $organization->organization_slug]) }}">
                                <div class="card">
                                    @if($organization->logos->count() !== 0)
                                        <img class="card-img-top" src="/storage/{{$organization->logos->first()->file}}" style="max-width: 7em; max-height: 7em; min-height: 7em; min-width: 7em;">
                                    @else
                                        <img class="card-img-top" src="/storage/organization_assets/logo/default_logo.png" style="max-width: 7em; max-height: 7em; min-height: 7em; min-width: 7em;">
                                    @endif
                                    <div class="card-body text-center bg-maroon text-white fw-bold">
                                        <p class="card-title">
                                           {{ $organization->organization_acronym }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                    <p class="text-center">
                        No Organization Found. :(
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <hr>
    
    <div class="flex-row my-2 text-center">
        <a href="{{route('admin.home')}}"
        class="btn btn-secondary text-white"
        role="button">
            <i class="fas fa-home"></i> Go Home
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
            const dataTable = new simpleDatatables.DataTable("#accomplishmentReportTable", {
                perPage: 30,
                searchable: true,
                labels: {
                    placeholder: "Search Events...",
                    noRows: "No accomplishment reports to display in this page or try in the next page.",
                },
            });
        });
    </script>
@endsection
