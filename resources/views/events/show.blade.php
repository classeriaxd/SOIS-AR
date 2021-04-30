@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
    		<h2 class="display-2 text-center">{{ $event->title }}</h2>
        	<div class="row justify-content-center">
        		<div class="col-md-5">
        			<div class="card">
        				<div class="card-header text-center align-middle">
        				    <div class="display-5">Event Summary</div>
        				</div>
        				<div class="card-body">
        					<h3 class="card-title">Title: {{ $event->title }}</h3>
        					<p class="card-text">
        						Date: {{ strftime("%B %e, %Y",strtotime($event->date))." — ".strftime("%I:%M %p",strtotime($event->start_time))."-".strftime("%I:%M %p",strtotime($event->end_time))}}
        					</p>
        					<p class="card-text">
        						Venue: {{ $event->venue }}
        					</p>
        					<p class="card-text">
        						Type of Activity: {{ $event->activity_type }}
        					</p>
        					<p class="card-text">
        						Sponsors: {{ $event->sponsors }}
        					</p>
        				</div>
        				<div class="card-header text-center align-middle">
        					<div class="display-5">Options</div>
        				</div>
        				<div class="card-body d-flex flex-row justify-content-around">
        					<a href="/e/{{$event->id}}/edit">
        						<button class="btn btn-primary">Edit</button>
        					</a>
        					<form action="{{route('event.destroy', $event->id)}}" method="POST">
        						@method('DELETE')
        						@csrf
        						<button class="btn btn-danger">Delete</button>
        					</form>  
        				</div>
        			</div>
        		</div>
        		 <div class="col-md-4">
        			<div class="card">
        				<div class="card-header text-center align-middle">
        				    <div class="display-5">Event Gallery</div>
        				</div>
        				<div class="card-body"></div>
        				<div class="card-header text-center align-middle">
        					<div class="display-5">Options</div>
        				</div>
        				<div class="card-body d-flex flex-row justify-content-around">
        					<a href="/e/{{ $event->id }}/edit">
        						<button class="btn btn-primary">Edit</button>
        					</a>
        					<a href="#">
        						<button class="btn btn-danger">Delete</button>
        					</a>	
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
@endsection
