<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{public_path('css/pdf_css.css') }}" rel="stylesheet" media="screen">
</head>

<body>

    {{-- Event Title Page --}}
    <div class="page">
        <div class="vertical-center">
            <div class="event-title-block">
                <p class="block-title">{{ $event['title'] }}</p>
                <div style="text-align:center;">
                    <span class="badge" style="background-color: {{$event['event_role']['background_color']}}; color: {{$event['event_role']['text_color']}};">{{ $event['event_role']['event_role'] }}</span>
                    |
                    <span class="badge" style="background-color: {{$event['event_category']['background_color']}}; color: {{$event['event_category']['text_color']}};">{{ $event['event_category']['category'] }}</span>
                </div>
                <p class="block-desc">Classification: {{ $event['event_classification']['classification'] }} </p>
                <p class="block-desc">Nature: {{ $event['event_nature']['nature'] }}</p>
                <p class="block-desc">Level: {{ $event['event_level']['level'] }}</p>
            </div>

           
        </div>
    </div>
    <div class="page-break"></div>

    {{-- Description Page --}}
    <div class="page">
        <div class="vertical-center">
            <div class="event-desc-block">
                <p class="block-desc" style="text-align:center;">Description</p>
                <p class="block-desc">{{ $event['description'] }}</p>
            </div>
        </div>
    </div>
    <div class="page-break"></div>

    {{-- Event Information Page --}}
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
            <p class="block-desc">{{ ($event['budget'] == 0) ? $event['budget'] : '-'}}</p>
        </div>
    </div>

    {{-- Event Images --}}
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