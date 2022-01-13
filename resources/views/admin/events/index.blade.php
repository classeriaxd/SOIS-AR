@extends('layouts.admin-app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">All Accomplished Events</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Events
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Event Table --}}
            <div class="row my-2">
                @if($events->isNotEmpty())

                <div class="d-flex justify-content-center">
                        {{ $events->links() }}
                </div>

                <table class="table table-striped table-hover table-bordered border border-dark" id="eventTable">
                    <thead class="text-white fw-bold bg-maroon">
                        <th class="text-center" scope="col">#</th>
                        <th class="text-center" scope="col">Org</th>
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
                            <td class="text-center">{{ $event->organization->organization_acronym }}</td>
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
                                <a href="{{route('admin.events.show', ['organizationSlug' => $event->organization->organization_slug, 'eventSlug' => $event->slug])}}" 
                                    class="btn btn-primary" 
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
                        {{ $events->links() }}
                </div>

                @else
                <p class="text-center">
                    No Event Found. :(
                </p>
                @endif
            </div>

            {{-- Organizations --}}
            <div class="row">
                <h2 class="display-7 text-center">View Events by Organization</h2>
            </div>
            <div class="row my-2">
                <div class="col d-flex justify-content-evenly">
                    @if($organizations->count() > 0)

                        @foreach($organizations as $organization)
                            <a href="{{ route('admin.events.organization.index', ['organizationSlug' => $organization->organization_slug]) }}">
                                <div class="card">
                                    <img class="card-img-top" src="/storage/{{$organization->logos->first()->file}}" style="max-width: 7em; max-height: 7em; min-height: 7em; min-width: 7em;">
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
            const dataTable = new simpleDatatables.DataTable("#eventTable", {
                perPage: 30,
                searchable: true,
                labels: {
                    placeholder: "Search Events...",
                    noRows: "No events to display in this page or try in the next page.",
                },
            });
        });
    </script>
@endsection
