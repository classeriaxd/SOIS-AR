<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Accomplishment Report</title>
    <link href="{{ ($view) ? asset('css/pdf_css.css') : public_path('css/pdf_css.css') }}" rel="stylesheet" media="screen">
</head>

<body>
    <div class="page">
        <div class="intro-title-block">
            <img class="w-100" src="{{ ($view) ? asset('/images/cs_logo.png') : public_path('/images/cs_logo.png') }}">
            <h2>Republic of the Philippines<br>
            <strong>POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</strong><br>
            <strong>TAGUIG CITY BRANCH</strong><br>
            <strong><span style="color:cornflowerblue;">COMPUTER SOCIETY</span></strong></h2> 
            <br>
            <h2 class="">QUARTERLY ACCOMPLISHMENT REPORT OF<br>COMPUTER SOCIETY CENTRAL BODY</h2>
            <h3>({{$start.' — '.$end}})</h3>
        </div>
    </div>
    <div class="page-break"></div>
@foreach($events as $event)
    <div class="page">
        <div class="event-title-block">
            <p class="block-title">{{ $event->title }}</p>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="page">
        <div class="event-desc-block">
            <p class="block-desc">{{ $event->description }}</p>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="page">
        <div class="event-info-block">
            <p class="block-title">Objective</p>
            <p class="block-desc">{{ $event->objective }}</p>

            <br>

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
    <div class="page">
        <div class="event-img-block">
            <p class="block-title">Event Images</p>
        </div>
        <div class="event-img-block">
    @php $i = 0; @endphp
    @foreach($event->eventImages as $eventImage)         
            <div class="img-block" style="max-width: 200px" >
                <img src="{{ ($view) ? asset('/storage/'.$eventImage->image) : public_path('/storage/'.$eventImage->image) }}" class="block-img">
            </div>
            <div class="info-block">
                <p class="block-title">{{ ($eventImage->image_type) ? 'Evidence' : 'Poster' }}</p>
                <p class="block-desc">Caption: {{ $eventImage->caption }}</p>
            </div>
    @php $i++; @endphp
        @if($i>2)

    @php $i=0; @endphp
        @endif
    @endforeach       
        </div>            
        
    </div> {{-- page end --}}
    <div class="page-break"></div>
         
  
@endforeach


</body>
</html>