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
                <h2 class="display-2 text-center">{{$orgAcronym}} Events</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Events
                        </li>
                    </ol>
                </nav>
            </div>

            @if($events->isNotEmpty())
                <div class="card w-100 my-2">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Events</h5>
                    <div class="d-flex justify-content-center">
                        @if($deletedEvents->isNotEmpty())
                            {{ 
                                $events->appends([
                                    'events' => $events->currentPage(),
                                    'deletedEvents' => $deletedEvents->currentPage(),
                                ])->links() 
                            }}
                        @else
                            {{ $events->links() }}
                        @endif
                    </div>

                    <table class="table table-striped table-hover table-bordered border border-dark" id="eventTable">
                        <thead class="text-white fw-bold bg-maroon">
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Title</th>
                            <th class="text-center" scope="col">Category</th>
                            <th class="text-center" scope="col">Role</th>
                            <th class="text-center" scope="col">Level</th>
                            <th class="text-center" scope="col">Date</th>
                            <th class="text-center" scope="col" data-sortable="false">Options</th>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($events as $event)
                            <tr>
                                <td scope="row" class="text-center">{{ $i }}</td>
                                <td>{{ $event->title }}</td>
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
                                <td>{{ $event->eventLevel->level }}</td>
                                <td> 
                                    @if($event->start_date == $event->end_date)
                                        {{date_format(date_create($event->start_date), 'F d, Y')}}
                                    @else
                                        {{date_format(date_create($event->start_date), 'F d, Y') . ' - ' . date_format(date_create($event->end_date), 'F d, Y')}}
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{route('event.show', ['event_slug' => $event->slug])}}" 
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
                        @if($deletedEvents->isNotEmpty())
                            {{ 
                                $events->appends([
                                    'events' => $events->currentPage(),
                                    'deletedEvents' => $deletedEvents->currentPage(),
                                ])->links() 
                            }}
                        @else
                            {{ $events->links() }}
                        @endif
                    </div>
                </div>    
            @else
                <p class="text-center">
                    No Event Found. :( You can create one <a href="{{route('event.create')}}" style="color:blue;"><u>here</u></a>.
                </p>
            @endif

            @if($deletedEvents->isNotEmpty())
                <div class="card w-100 mt-5 mb-2">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Deleted Events</h5>
                    <div class="d-flex justify-content-center">
                        @if($events->isNotEmpty())
                            {{ 
                                $deletedEvents->appends([
                                    'events' => $events->currentPage(),
                                    'deletedEvents' => $deletedEvents->currentPage(),
                                ])->links() 
                            }}
                        @else
                            {{ $deletedEvents->links() }}
                        @endif
                    </div>

                    <table class="table table-striped table-hover table-bordered border border-dark" id="deletedEventTable">
                        <thead class="text-white fw-bold bg-maroon">
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Title</th>
                            <th class="text-center" scope="col">Category</th>
                            <th class="text-center" scope="col">Role</th>
                            <th class="text-center" scope="col">Level</th>
                            <th class="text-center" scope="col">Date</th>
                            <th class="text-center" scope="col" data-sortable="false">Options</th>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($deletedEvents as $event)
                            <tr>
                                <td scope="row" class="text-center">{{ $i }}</td>
                                <td>{{ $event->title }}</td>
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
                                <td>{{ $event->eventLevel->level }}</td>
                                <td> 
                                    @if($event->start_date == $event->end_date)
                                        {{date_format(date_create($event->start_date), 'F d, Y')}}
                                    @else
                                        {{date_format(date_create($event->start_date), 'F d, Y') . ' - ' . date_format(date_create($event->end_date), 'F d, Y')}}
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{route('event.restore', ['event_slug' => $event->slug])}}" method="POST"
                                        onsubmit="document.getElementById('restoreButton').disabled=true;">
                                        @csrf
                                        <button id="restoreButton" type="submit" class="btn btn-success text-white">
                                            <i class="fas fa-trash-restore"></i> Restore Event
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php $i += 1; @endphp
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        @if($events->isNotEmpty())
                            {{ 
                                $deletedEvents->appends([
                                    'events' => $events->currentPage(),
                                    'deletedEvents' => $deletedEvents->currentPage(),
                                ])->links() 
                            }}
                        @else
                            {{ $deletedEvents->links() }}
                        @endif
                    </div>
                </div>
            @endif


        </div>
    </div>

    <hr>

    {{-- GPOA Button --}}
    <div class="flex-row my-2 text-center">
        <a href="{{route('event.gpoa.index')}}">
            <button class="btn btn-primary text-white position-relative">
                <i class="fas fa-clipboard-list"></i> Go to GPOA Events

                {{-- GPOA Alert Badge --}}
                @if($accomplishedEventsCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{$accomplishedEventsCount}}
                        <span class="visually-hidden">GPOA Alert</span>
                    </span>
                @endif
            </button>
        </a>
    </div>

    <hr>
    
    <div class="flex-row my-2 text-center">
        <a href="{{route('home')}}"
        class="btn btn-secondary text-white"
        role="button">
            <i class="fas fa-home"></i> Go Home
        </a>

        <span>or</span>

        <a href="{{route('event.create')}}"
        class="btn btn-primary text-white"
        role="button">
            <i class="fas fa-clipboard-list"></i> Create Event
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
        const dataTable2 = new simpleDatatables.DataTable("#deletedEventTable", {
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
