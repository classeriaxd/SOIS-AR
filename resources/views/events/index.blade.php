@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="text-center">
            <h2 class="display-2 ">{{$orgAcronym}} Events</h2>
        </div>
        <div class="col-md-10">
            {{-- <div class="accordion" id="eventAccordion">
                @php $open = true; @endphp
                @foreach ($events as $year => $yearEvent)
                    <div class="card w-100">
                        <div class="card-header" id="{{'heading'.$year}}">
                            <h2 class="mb-0 text-center">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="{{'#collapse'.$year}}" aria-expanded="{{($open)?'true':'false'}}" aria-controls="{{'collapse'.$year}}">
                            {{$year}}
                            </button>
                            </h2>
                        </div>
                        <div id="{{'collapse'.$year}}" class="{{($open)?'collapse show':'collapse'}}" aria-labelledby="{{'heading'.$year}}" data-parent="#eventAccordion">
                            <div class="card-body">
                            <table class="table-striped table-hover w-100">
                                <thead class="bg-dark text-white text-center">
                                    <th scope="col" colspan="3">Events</th>
                                </thead>
                                <tbody>
                                    @foreach($yearEvent as $event)
                                    <tr>
                                        <td>
                                            {{$event->title}}
                                        </td>
                                        <td>
                                            {{date_format(date_create($event->start_date), 'F d, Y')
                                            }}
                                        </td>
                                        <td class="text-right">
                                            <a href="/e/{{ $event->slug }}">
                                                <button class="btn btn-primary m-1" id="{{'btn-event-'.$event->slug}}">Go to Event</button>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach 
                                </tbody>                    
                            </table>
                            </div>
                        </div>
                    </div>
                @php $open = false; @endphp
                @endforeach
            </div> --}}
        
            <table class="table-striped table-bordered" id="eventTable">
                <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Role</th>
                    <th>Level</th>
                    <th>Date</th>
                    <th data-sortable="false">Options</th>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($events as $event)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->eventCategory->category }}</td>
                        <td>{{ $event->eventRole->event_role }}</td>
                        <td>{{ $event->eventLevel->level }}</td>
                        <td> 
                            @if($event->start_date == $event->end_date)
                                {{date_format(date_create($event->start_date), 'F d, Y')}}
                            @else
                                {{date_format(date_create($event->start_date), 'F d, Y') . ' - ' . date_format(date_create($event->end_date), 'F d, Y')}}
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary" href="{{route('event.show', ['event_slug' => $event->slug])}}" role="button" target="_blank"><span class="fas fa-external-link-alt"></span></a>
                        </td>
                    </tr>
                    @php $i += 1; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <hr>
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header text-center align-middle">
                <div class="display-5 text-white bg-maroon">Navigation</div>
            </div>
            <div class="card-body">
                <div class="justify-content-around d-flex flex-row">
                    <a href="{{route('event.create')}}">
                        <button class="btn btn-primary mr-2">Add Event</button>
                    </a>
                    <a href="{{route('accomplishmentreports.create')}}">
                        <button class="btn btn-primary">Year Summary</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-2 justify-content-center">
        <a href="{{route('home')}}">
            <button class="btn btn-secondary">Go Home</button>
        </a>
    </div>

</div>
@endsection
@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
@endpush
@section('scripts')
    <script type="module">
        const dataTable = new simpleDatatables.DataTable("#eventTable", {
            searchable: true,
            labels: {
            placeholder: "Search Events...",
            perPage: "Show {select} events per page",
            noRows: "No events to display",
            info: "Showing {start} to {end} of {rows} events (Page {page} of {pages} pages)",
            },
        })
    </script>
@endsection
