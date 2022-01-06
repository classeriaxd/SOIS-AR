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
            <div class="row">
                {{-- Title --}}
                <h2 class="display-2 text-center">{{$orgAcronym}} GPOA Events</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('event.index')}}" class="text-decoration-none">Events</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            GPOA Events
                        </li>
                    </ol>
                </nav>
            </div>

            @if($accomplishedEvents->isNotEmpty())
                <div class="card w-100 my-2">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">GPOA Events</h5>
                    <div class="d-flex justify-content-center">
                        {{ $accomplishedEvents->links() }}
                    </div>

                    <table class="table table-striped table-hover table-bordered border border-dark" id="eventTable">
                        <thead class="text-white fw-bold bg-maroon">
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Title</th>
                            <th class="text-center" scope="col" style="width:35%;">Objectives</th>
                            <th class="text-center" scope="col">Date, Time, Venue</th>
                            <th class="text-center" scope="col">Projected Budget</th>
                            <th class="text-center" scope="col" data-sortable="false">Options</th>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($accomplishedEvents as $event)
                            <tr>
                                <td scope="row" class="text-center">{{ $i }}</td>
                                <td>{{ $event->title }}</td>
                                <td style="width:35%;">{{ $event->objectives }}</td>
                                <td> 
                                    {{
                                        date_format(date_create($event->date), 'F d, Y') . ' | ' .
                                        date_format(date_create($event->time), 'h:i A') . ' | ' . 
                                        $event->venue
                                    }}
                                </td>
                                <td>{{ $event->projected_budget }}</td>
                                <td class="text-center align-middle">
                                    <a href="{{route('event.gpoa.create', ['gpoaID' => $event->upcoming_event_id])}}" 
                                        class="btn btn-primary text-white" 
                                        role="button" 
                                        target="_blank">
                                            <i class="fas fa-plus"></i> Create AR Entry
                                    </a>
                                </td>
                            </tr>
                            @php $i += 1; @endphp
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $accomplishedEvents->links() }}
                    </div>
                </div>    
            @else
                <p class="text-center">
                    No GPOA Event Found. :)
                </p>
            @endif

        </div>
    </div>

    <hr>
    
    <div class="flex-row my-2 text-center">
        <a href="{{route('event.index')}}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-arrow-left"></i> Go Back to All Events
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
        // Datatables JS
        const dataTable = new simpleDatatables.DataTable("#eventTable", {
            searchable: true,
            perPage: 30,
            labels: {
            placeholder: "Search Events...",
            perPage: "Show {select} events per page",
            noRows: "No events to display or try the next page",
            info: "Showing {start} to {end} of {rows} events (Page {page} of {pages} pages)",
            },
        })
    </script>
@endsection
