@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="text-center">
            <h2 class="display-2">{{$orgAcronym}} Events</h2>
        </div>
        <div class="col-md-10">
            <div class="accordion" id="eventAccordion">
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
            </div>
        </div>
    </div>

    <hr>
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header text-center align-middle">
                <div class="display-5">Navigation</div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
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
