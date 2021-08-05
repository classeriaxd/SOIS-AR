<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Accomplishment Report</title>
    <link href="{{ resource_path('css/pdf_css.css') }}" rel="stylesheet">
</head>

<body>
    <div class="page">
        <div class="intro-title-block">
            <img class="w-100" src="{{public_path('/images/cs_logo.png')}}">
            <h2>Republic of the Philippines<br>
            <strong>POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</strong><br>
            <strong>TAGUIG CITY BRANCH</strong><br>
            <strong><span style="color:cornflowerblue;">COMPUTER SOCIETY</span></strong></h2> 
        </div>
        <div class="intro-desc-block">
            <h2 class="">QUARTERLY ACCOMPLISHMENT REPORT OF COMPUTER SOCIETY CENTRAL BODY</h2>
            <h3>({{$start.' - '.$end}})</h3>
        </div>
    </div>
    <div class="page-break"></div>
@foreach($events as $event)
    <div class="page">
        <div class="event-desc-block">
            <h3 class="">{{ $event->title }}</h3>
            <p>Date: {{ strftime("%B %e, %Y",strtotime($event->date))." | ".strftime("%I:%M %p",strtotime($event->start_time))."-".strftime("%I:%M %p",strtotime($event->end_time))}} </p>
        </div>
        <div class="event-desc-block">
            <h5><strong>Event Description</strong></h5>
            <p>{{ $event->description }}</p>
        </div>
        <div class="event-desc-block">
            <h5><strong>Objectives</strong></h5>
            <p>{{ $event->objective }}</p>
        </div>
        <div class="event-desc-block">
            <h5><strong>Venue</strong></h5>
            <p>{{ $event->venue }}</p>
        </div>
        <div class="event-desc-block">
            <h5><strong>Activity Type</strong></h5>
            <p>{{ $event->activity_type }}</p>
        </div>
        <div class="event-desc-block">
            <h5><strong>Beneficiaries</strong></h5>
            <p>{{ $event->beneficiaries }}</p>
        </div>
        <div class="event-desc-block">
            <h5><strong>Sponsors</strong></h5>
            <p>{{ $event->sponsors }}</p>
        </div>
        <div class="event-desc-block">
            <h5><strong>Budget</strong></h5>
            <p>{{ $event->budget }}</p>
        </div>
        
        
    </div>
    <div class="page-break"></div>
    <div class="page">
        <div class="event-desc-block">
            <h4 class="display-6 text-center">Event Images</h3>
        </div>
        <div class="event-img-block">
            <div class="row justify-content-center">
    @php $i = 0; @endphp
    @foreach($event->eventImages as $eventImage)         
                <div class="card mr-2 mb-1" style="max-width: 200px" >
                    <img src="/storage/{{ $eventImage->image }}" class="card-img-top m-auto" style="max-width: 200px">
                    <div class="card-body">
                        <h5 class="card-title">{{ ($eventImage->image_type) ? 'Evidence' : 'Poster' }}</h5>
                            <p class="card-text">Caption: {{ $eventImage->caption }}</p>
                    </div>
                </div>
    @php $i++; @endphp
        @if($i>2)
                </div>
                <div class="row justify-content-center">
    @php $i=0; @endphp
        @endif
    @endforeach       
                </div>            
        </div>
    </div>
         
  
@endforeach


</body>
</html>