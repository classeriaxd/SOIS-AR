@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10 col-sm-10 col-12">
            <div class="page">
    		<div class="row justify-content-center">
                <div class="col-md-4 col-sm-2 col-6 align-center m-auto">
                    <img class="w-100" src="/images/cs_logo.png">
                </div>
                <div class="col-md-6 col-sm-6 col-6 align-center m-auto">
                    <h2>Republic of the Philippines<br>
                    <strong>POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</strong><br>
                    <strong>TAGUIG CITY BRANCH</strong><br>
                    <strong><span style="color:cornflowerblue;">COMPUTER SOCIETY</span></strong></h2> 
                </div>
    		</div>
            <div class="row d-flex flex-column text-center mt-4">
                <h4 class="display-5">Quarterly Accomplishment Report for: </h4>
                <h5>{{ date("F", strtotime($start_date))." ".date("Y", strtotime($start_date))." - ".date("F", strtotime($end_date))." ".date("Y", strtotime($end_date)) }}</h5>
            </div>  
            </div>
@foreach($events as $event)
        <div class="page">
            <div class="row d-flex flex-column text-center">
                <h3 class="display-4 text-center">{{ $event->title }}</h3>
                <p>Date: {{ strftime("%B %e, %Y",strtotime($event->date))." | ".strftime("%I:%M %p",strtotime($event->start_time))."-".strftime("%I:%M %p",strtotime($event->end_time))}} </p>
            </div>
            <div class="row d-flex flex-column text-center">
                <h5><strong>Event Description</strong></h5>
                <p>{{ $event->description }}</p>
            </div>
            <div class="row d-flex flex-column text-center">
                <h5><strong>Objectives</strong></h5>
                <p>{{ $event->objective }}</p>
            </div>
            <div class="row d-flex flex-column text-center">
                <h5><strong>Venue</strong></h5>
                <p>{{ $event->venue }}</p>
            </div>
            <div class="row d-flex flex-column text-center">
                <h5><strong>Activity Type</strong></h5>
                <p>{{ $event->activity_type }}</p>
            </div>
            <div class="row d-flex flex-column text-center">
                <h5><strong>Beneficiaries</strong></h5>
                <p>{{ $event->beneficiaries }}</p>
            </div>
            <div class="row d-flex flex-column text-center">
                <h5><strong>Sponsors</strong></h5>
                <p>{{ $event->sponsors }}</p>
            </div>
            <div class="row d-flex flex-column text-center">
                <h5><strong>Budget</strong></h5>
                <p>{{ $event->budget }}</p>
            </div>
            
            <div class="row d-flex flex-column text-center">
                <h4 class="display-6 text-center">Event Images</h3>
            </div>
            <div class="row d-flex flex-column text-center">
                <div class="row justify-content-center">
@php 
    $i = 0;
@endphp
@foreach($event->eventImages as $eventImage)         
                    <div class="card mr-2 mb-1" style="max-width: 200px" >
                        <img src="/storage/{{ $eventImage->image }}" class="card-img-top m-auto" style="max-width: 200px">
                        <div class="card-body">
                            <h5 class="card-title">{{ ($eventImage->image_type) ? 'Evidence' : 'Poster' }}</h5>
                                <p class="card-text">Caption: {{ $eventImage->caption }}</p>
                        </div>
                    </div>
@php
    $i++;
    if($i>2):
@endphp
                </div>
                <div class="row justify-content-center">       
@php
    $i=0;       
    endif;
@endphp
@endforeach                    
                </div>

            </div>
            <hr>
            
        </div>
@endforeach
    	</div>
	</div>
</div>
@endsection