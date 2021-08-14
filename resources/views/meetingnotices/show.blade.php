@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
    		<h2 class="display-2 text-center">Notice of the Meeting</h2>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-5">
        			<div class="card">
        				<div class="card-header text-center align-middle">
        				    <div class="display-5">Notice Summary</div>
        				</div>
        				<div class="card-body">
        					<p class="card-title">For: {{ $mn->for }}</p>
        					<!-- <p class="card-text">
        						Date: {{ strftime("%B %e, %Y",strtotime($mn->date))." — ".strftime("%I:%M %p",strtotime($mn->start_time))."-".strftime("%I:%M %p",strtotime($mn->end_time))}}
        					</p> -->
        					<p class="card-text">
        						From: {{ $mn->from }}
        					</p>
        					<p class="card-text">
        						Creation Date: {{ $mn->creation_date }}
        					</p>
                            <p class="card-text">
                                Meeting Date: {{ $mn->meeting_date }}
                            </p>
        					<p class="card-text">
                                Venue: {{ $mn->venue }}
                            </p>  
                            <p class="card-text">                   
                                Objectives: {{ $mn->objectives }}
                            </p>
        				</div>
        				<div class="card-header text-center align-middle">
        					<div class="display-5">Options</div>
        				</div>
        				<div class="card-body d-flex flex-row justify-content-around">
        					<a href='/n/{{$mn->notice_uuid}}/edit'>
        						<button class="btn btn-primary">Edit Notice</button>
        					</a>
        					<form action="/n/{{$mn->notice_uuid}}" method="POST">
        						@csrf
                                @method('DELETE')
        						<button class="btn btn-danger">Delete Notice</button>
        					</form>  
        				</div>
        			</div>
        		</div>        		
        	<hr>
        	<div class="row justify-content-center pt-1">
        		<a href="/home">
        			<button class="btn btn-secondary">Go back</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection
