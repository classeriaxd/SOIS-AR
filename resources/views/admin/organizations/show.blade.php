@extends('layouts.admin-app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Organization View</h2>

                {{-- Organization Logo --}}
                <img src="/storage/{{ $organization->logo->file }}" style="max-width: 7em; max-height: 7em; min-height: 7em; min-width: 7em;">

                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.organizations.index')}}" class="text-decoration-none">Organizations</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $organization->organization_acronym }}
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Accomplishment Reports Table --}}
            <div class="row my-2">
                <h2 class="display-7 text-center">Accomplishment Reports by {{$organization->organization_acronym}}</h2>
                @if($accomplishmentReports->isNotEmpty())

                <table class="table table-striped table-hover table-bordered border border-dark" id="accomplishmentReportTable">
                    <thead class="text-white fw-bold bg-maroon">
                        <th class="text-center" scope="col">#</th>
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
                                <a href="{{route('admin.accomplishmentReports.show', ['organizationSlug' => $organization->organization_slug, 'accomplishmentReportUUID' => $accomplishmentReport->accomplishment_report_uuid])}}" 
                                    class="btn btn-primary text-white" 
                                    role="button" 
                                    target="_blank">
                                        <span class="fas fa-external-link-alt text-white"></span>
                                </a>
                            </td>
                        </tr>
                        @php $i += 1; @endphp
                        @endforeach
                        <tr>
                            <td colspan="6" class="text-center">
                                <a href="{{route('admin.accomplishmentReports.organization.index', ['organizationSlug' => $organization->organization_slug])}}" 
                                    class="btn btn-primary text-white fw-bold" 
                                    role="button" 
                                    target="_blank">
                                    View {{$organization->organization_acronym}} Accomplishment Reports
                                </a> 
                            </td>
                        </tr>
                    </tbody>
                </table>

                @else
                <p class="text-center">
                    No Accomplishment Report Found. :(
                </p>
                @endif
            </div>

            {{-- Events Table --}}
            <div class="row my-2">
                <h2 class="display-7 text-center">Events by {{$organization->organization_acronym}}</h2>
                @if($events->isNotEmpty())

                <table class="table table-striped table-hover table-bordered border border-dark" id="eventTable">
                    <thead class="text-white fw-bold bg-maroon">
                        <th class="text-center" scope="col">#</th>
                        <th class="text-center" scope="col">Title</th>
                        <th class="text-center" scope="col">Category</th>
                        <th class="text-center" scope="col">Role</th>
                        <th class="text-center" scope="col">Date</th>
                        <th class="text-center" scope="col" data-sortable="false">Options</th>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($events as $event)
                        <tr>
                            <td scope="row" class="text-center">{{ $i }}</td>
                            <td class="text-break">{{ $event->title }}</td>
                            <td class="text-center">
                                <span class="badge fs-6" style="background-color:{{$event->eventCategory->background_color}}; color:{{$event->eventCategory->text_color}};">
                                    {{$event->eventCategory->category}}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge fs-6" style="background-color:{{$event->eventRole->background_color}}; color:{{$event->eventRole->text_color}};">
                                    {{$event->eventRole->event_role}}
                                </span>
                            </td>
                            <td> 
                                @if($event->start_date == $event->end_date)
                                    {{date_format(date_create($event->start_date), 'F d, Y')}}
                                @else
                                    {{date_format(date_create($event->start_date), 'F d, Y') . ' - ' . date_format(date_create($event->end_date), 'F d, Y')}}
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{route('admin.events.show', ['organizationSlug' => $organization->organization_slug, 'eventSlug' => $event->slug])}}" 
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
                            <td colspan="6" class="text-center">
                                <a href="{{route('admin.events.organization.index', ['organizationSlug' => $organization->organization_slug])}}" 
                                    class="btn btn-primary text-white fw-bold" 
                                    role="button" 
                                    target="_blank">
                                    View {{$organization->organization_acronym}} Events
                                </a> 
                            </td>
                        </tr>
                    </tbody>
                </table>

                @else
                <p class="text-center">
                    No Event Found. :(
                </p>
                @endif
            </div>

            

            <hr>

            <div class="flex-row my-2 text-center">
                <a href="{{route('admin.organizations.index')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        Go back to All Organizations
                </a>
                <span>or</span>
                
                <a href="{{route('admin.home')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        Go Home
                </a>            
            </div>

            

        </div>
    </div>
</div>
@endsection
