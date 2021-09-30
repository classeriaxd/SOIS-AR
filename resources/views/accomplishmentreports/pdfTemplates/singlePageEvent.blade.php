<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{public_path('css/pdf_css.css') }}" rel="stylesheet" media="screen">
</head>

<body>

    <div class="page">
        <div class="vertical-center">
            <div class="event-title-block">
                <p class="block-title">{{ $event['title'] }}</p>
                <h2 style="text-align: center;">
                    @if ($event['event_role_id'] == 1)
                        <span style="color: #0275d8">Organizer</span>
                    @elseif ($event['event_role_id'] == 2) 
                        <span style="color: #5cb85c">Sponsor</span>
                    @elseif ($event['event_role_id'] == 3) 
                        <span style="color: gray">Participant</span>
                    @endif
                    |
                    @if ($event['event_category_id'] == 1)
                        <span style="color: #0275d8">Academic</span>
                    @elseif ($event['event_category_id'] == 2) 
                        <span style="color: #d9534f">Non-academic</span>
                    @elseif ($event['event_category_id'] == 3) 
                        <span style="color: #f0ad4e">Cultural</span>
                    @elseif ($event['event_category_id'] == 4) 
                        <span style="color: #5cb85c">Sports</span>
                    @elseif ($event['event_category_id'] == 5) 
                        <span style="color: #5bc0de">Seminars/Workshops</span>
                    @elseif ($event['event_category_id'] == 6)
                        <span style="color: #5bc0de">Community Outreach</span>
                    @endif
                </h2>
            </div>

            <div class="event-desc-block">
                
                <p class="block-desc">{{ $event['description'] }}</p>
            </div>
        </div>
    </div>
    <div class="page-break"></div>

    <div class="page">
        <div class="event-info-block vertical-center">
            <p class="block-title">Objective</p>
            <p class="block-desc">{{ $event['objective'] }}</p>

            <p class="block-title">Date and Time</p>
            @if($event['start_date'] == $event['end_date'])
            {{date_format(date_create($event['start_date']), 'F d, Y')}}
            @else
            {{date_format(date_create($event['start_date']), 'F d, Y') . ' - ' . date_format(date_create($event['end_date']), 'F d, Y')}}
            @endif
             | 
            @if($event['start_time'] == $event['end_time'])
            {{date_format(date_create($event['start_time']), 'h:i A')}}
            @else
            {{date_format(date_create($event['start_time']), 'h:i A') . ' - ' . date_format(date_create($event['end_time']), 'h:i A')}}
            @endif

            <p class="block-title">Venue</p>
            <p class="block-desc">{{ $event['venue'] }}</p>

            <p class="block-title">Activity Type</</p>
            <p class="block-desc">{{ $event['activity_type'] }}</p>

            <p class="block-title">Beneficiaries</p>
            <p class="block-desc">{{ $event['beneficiaries'] }}</p>

            <p class="block-title">SPONSORS</p>
            <p class="block-desc">{{ $event['sponsors'] }}</p>

            <p class="block-title">EVENT BUDGET</p>
            <p class="block-desc">{{ ($event['budget']) ? $event['budget'] : '-'}}</p>
        </div>
    </div>
    @isset($event['event_images'])
    @if($event['event_images'] != NULL)
    <div class="page-break"></div>
        @php $runOnce = 1; @endphp
        @foreach($event['event_images'] as $eventImage)

            @if($runOnce == 1)
                <div class="event-img-block">
                    <p class="block-title">Event Images</p>
                </div>
            @php $runOnce = 0; @endphp
            @endif

            <div class="page">
                <div class="event-img-block">
                    <div class="img-block">
                        <img src="{{ public_path('/storage/'.$eventImage['image']) }}">
                    </div>
                    <div class="info-block">
                        <p class="block-desc">{{ $eventImage['caption'] }}</p>
                    </div>
                </div>
            </div>
            @if(!($loop->last))
            <div class="page-break"></div>
            @endif
        @endforeach {{-- endforeach event-img --}}
    @endif
    @endisset
</body>
</html>