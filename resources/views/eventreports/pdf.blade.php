<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Accomplishment Report</title>
    <link href="{{ ($view) ? asset('css/pdf_css.css') : public_path('css/pdf_css.css') }}" rel="stylesheet" media="screen">
</head>

<body>

    <div class="page">
        <div class="intro-title-block vertical-center">
            <img src="{{ ($view) ? '/storage/'.$organization_logo->image : public_path('/storage/'.$organization_logo->image) }}">
            <h2>Republic of the Philippines<br>
            <strong>POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</strong><br>
            <strong>TAGUIG CITY BRANCH</strong><br>
            <strong><span style="color:cornflowerblue; text-transform: uppercase;">{{$organization->organization_name}}</span></strong></h2> 
            <br>
            <h2 class="">QUARTERLY ACCOMPLISHMENT REPORT OF<br><span style="text-transform: uppercase;">{{$organization->organization_name}}</span><br>CENTRAL BODY</h2>
            <h3>({{$start.' — '.$end}})</h3>
        </div>
    </div>
    <div class="page-break"></div>

    <div class="page">
        <div class="event-prep-block vertical-center">
            <div class="prep-presented">
                <p class="prep-text">Presented by:</p>
                <p class="prep-org">{{$organization->organization_name}} CENTRAL BODY</p>
            </div>
            <br>
            <div class="prep-prepared">
                <p class="prep-text">Prepared by:</p>
                <p class="prep-signature">signature</p>
                <p class="prep-officer">Jillian Pollescas</p>
                <p class="prep-officer-title">CS Vice President for Research and Documentation</p>
                <p class="prep-signature">signature</p>
                <p class="prep-officer">Mark Joshua Allando</p>
                <p class="prep-officer-title">CS Assistant Vice President for Research and Documentation</p>
            </div>
            <br>
            <div class="prep-approved">
                <p class="prep-text">Approved by:</p>
                <p class="prep-signature">signature</p>
                <p class="prep-officer">John Timothy Sescar</p>
                <p class="prep-officer-title">CS President </p>
            </div>
        </div>
    </div>
    <div class="page-break"></div>

    @foreach($events as $event)
    <div class="page">
        <div class="event-title-block vertical-center">
            <p class="block-title">{{ $event->title }}</p>
        </div>
    </div>
    <div class="page-break"></div>
    
    <div class="page">
        <div class="event-desc-block vertical-center">
            <p class="block-desc">{{ $event->description }}</p>
        </div>
    </div>
    <div class="page-break"></div>

    <div class="page">
        <div class="event-info-block vertical-center">
            <p class="block-title">Objective</p>
            <p class="block-desc">{{ $event->objective }}</p>

            <p class="block-title">Date and Time</p>
            <p class="block-desc">{{ strftime("%B %e, %Y",strtotime($event->date))." | ".strftime("%I:%M %p",strtotime($event->start_time))." — ".strftime("%I:%M %p",strtotime($event->end_time))}}</p>

            <p class="block-title">Venue</p>
            <p class="block-desc">{{ $event->venue }}</p>

            <p class="block-title">Activity Type</</p>
            <p class="block-desc">{{ $event->activity_type }}</p>

            <p class="block-title">Beneficiaries</p>
            <p class="block-desc">{{ $event->beneficiaries }}</p>

            <p class="block-title">SPONSORS</p>
            <p class="block-desc">{{ $event->sponsors }}</p>

            <p class="block-title">EVENT BUDGET</p>
            <p class="block-desc">{{ ($event->budget) ? $event->budget : '-'}}</p>
        </div>
    </div>
    <div class="page-break"></div>

        @php 
            $i = 1; 
            $j = 1;
            $imageCount = $event->eventImages->count();
        @endphp

        {{-- Prints 2 imgs in a single page --}}
    @foreach($event->eventImages as $eventImage)

        @if($j == 1)
    <div class="page">
        @endif

        @if($i == 1)
        <div class="event-img-block">
            <p class="block-title">Event Images</p>
        </div>
            @php $i = 0; @endphp
        @endif

        @if($j <= 2)
        <div class="event-img-block">
            <div class="img-block">
                <img src="{{ ($view) ? asset('/storage/'.$eventImage->image) : public_path('/storage/'.$eventImage->image) }}">
            </div>
            <div class="info-block">
                <p class="block-desc">{{ $eventImage->caption }}</p>
            </div>
        </div>
            @php 
                $j++;
                $imageCount -= 1;
            @endphp

        @else
    </div> {{-- end page --}}
    <div class="page-break"></div>
            @php $j = 1; @endphp
        @endif

    @endforeach {{-- endforeach event-img --}}
    <div class="page-break"></div>
    

    @endforeach {{-- endforeach event --}}
    {{--  --}}
    


</body>
</html>