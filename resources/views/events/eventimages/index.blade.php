@extends('layouts.app')

@section('content')
<script>
$(document).ready(function () {
  $('#PosterControls').find('.carousel-item').first().addClass('active');
});	
</script>
<div class="container">
	{{-- Title and Breadcrumbs --}}
	<div class="row">
		{{-- Title --}}
		<h2 class="display-2 text-center">{{ $event->title }}</h2>
		{{-- Breadcrumbs --}}
		<nav aria-label="breadcrumb align-items-center">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item">
                <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{route('event.index')}}" class="text-decoration-none">Events</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Create
                </li>
            </ol>
        </nav>
	</div>
	<div class="card my-2 w-100">
		<h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Event Gallery</h4>
		<div class="card-body">
			<div class="row">
				<h3 class="card-title text-center">Posters</h3>
				@if($posters->count() > 0)
					<div id="PosterControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
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
</div>
@endsection