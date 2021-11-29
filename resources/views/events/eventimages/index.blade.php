@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
        	{{-- Title and Breadcrumbs --}}
        	<div class="d-flex justify-content-between align-items-center">
        	    {{-- Title --}}
        	    <h2 class="display-7 text-left text-break">{{ $event->title }}</h2>
        	    {{-- Breadcrumbs --}}
        	    <nav aria-label="breadcrumb">
        	        <ol class="breadcrumb justify-content-center">
        	            <li class="breadcrumb-item">
        	                <a href="{{route('home')}}" class="text-decoration-none">Home</a>
        	            </li>
        	            <li class="breadcrumb-item">
        	                <a href="{{route('event.index')}}" class="text-decoration-none">Events</a>
        	            </li>
        	            <li class="breadcrumb-item">
        	                <a href="{{route('event.show', ['event_slug' => $event->slug])}}" class="text-decoration-none">{{ $event->title }}</a>
        	            </li>
        	            <li class="breadcrumb-item active" aria-current="page">
        	            	Images
        	            </li>
        	        </ol>
        	    </nav>
        	</div>

        	{{-- Event Gallery --}}
        	<div class="row">
        		<div class="card my-2 w-100">
        			<h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Event Gallery</h4>
	        		<div class="card-body">
	        			<div class="row">
	        				<h3 class="card-title text-center">Posters</h3>
	        				@if($posters->count() > 0)
	        					<div id="PosterControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
	        						<div class="carousel-indicators">
	        							@foreach($posters as $poster)
	        								<button type="button" data-bs-target="#PosterControls" data-bs-slide-to="{{$loop->index}}" @if($loop->first) class="active" aria-current="true" @endif aria-label="Slide {{$loop->index}}"></button>
	        							@endforeach
        						  	</div>
	        						<div class="carousel-inner">
		        						@foreach($posters as $poster)
	        								<div class="carousel-item @if($loop->first)active @endif">
	        									<a href="{{route('event.image.show', ['event_slug' => $event->slug, 'eventImage_slug' => $poster->slug])}}">
	        									<img src="/storage/{{$poster->image}}" class="d-block" style="max-width: 350px; max-height: 350px; margin:auto"> 
	        									<div class="carousel-caption d-none d-md-block">
	        										<p class="card-text fw-bold badge bg-primary text-wrap" style="color:white;">{{$poster->caption}}</p>
	        									</div>	
	        									</a>
	        								</div>	
		        						@endforeach
	        						</div>

	        						<button class="carousel-control-prev" type="button" data-bs-target="#PosterControls" data-bs-slide="prev">
	        							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
	        							<span class="visually-hidden">Previous</span>
	        						</button>
	        						<button class="carousel-control-next" type="button" data-bs-target="#PosterControls" data-bs-slide="next">
	        							<span class="carousel-control-next-icon" aria-hidden="true"></span>
	        							<span class="visually-hidden">Next</span>
	        						</button>
	        					</div>
	        				@else
	        					<p class="text-center">No Image found. :(</p>
	        				@endif
	        			</div>

	        			<hr>

	        			<div class="row">
	        				<h3 class="card-title text-center">Evidences</h3>
	        				@if($evidences->count() > 0)
	        					<div id="EvidenceControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
	        						<div class="carousel-indicators">
	        							@foreach($evidences as $evidence)
	        								<button type="button" data-bs-target="#EvidenceControls" data-bs-slide-to="{{$loop->index}}" @if($loop->first) class="active" aria-current="true" @endif aria-label="Slide {{$loop->index}}"></button>
	        							@endforeach
	    						  	</div>
		        					<div class="carousel-inner">
		        						@foreach($evidences as $evidence)
		        								<div class="carousel-item @if($loop->first)active @endif">	
		        									<a href="{{route('event.image.show', ['event_slug' => $event->slug, 'eventImage_slug' => $evidence->slug])}}">
		        									<img src="/storage/{{$evidence->image}}" class="d-block" style="max-width: 500px; max-height: 350px; margin:auto"> 
		        									<div class="carousel-caption d-none d-md-block">
		        										<p class="card-text fw-bold badge bg-primary text-wrap" style="color:white;">{{$poster->caption}}</p>
		        									</div>
		        									</a>
		        								</div>
		        						@endforeach
	        						</div>

	        						<button class="carousel-control-prev" type="button" data-bs-target="#EvidenceControls" data-bs-slide="prev">
	        							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
	        							<span class="visually-hidden">Previous</span>
	        						</button>
	        						<button class="carousel-control-next" type="button" data-bs-target="#EvidenceControls" data-bs-slide="next">
	        							<span class="carousel-control-next-icon" aria-hidden="true"></span>
	        							<span class="visually-hidden">Next</span>
	        						</button>
	        					</div>
	        				@else
	        					<p class="text-center">No Image found. :(</p>
	        				@endif
        				</div>
        			</div>
        		</div>
        	</div>

        	<div class="flex-row my-2 text-center">
        	    <a href="{{route('event.show', ['event_slug' => $event->slug])}}"
        	    class="btn btn-secondary text-white"
        	    role="button">
        	        <i class="fas fa-arrow-left"></i> Go Back
        	    </a>

        	    <span>or</span>

        	    <a href="{{route('event.image.create', ['event_slug' => $event->slug])}}"
        	    class="btn btn-primary text-white"
        	    role="button">
        	        <i class="fas fa-plus"></i> Add Image
        	    </a>
        	</div>
		</div>
	</div>
</div>
@endsection