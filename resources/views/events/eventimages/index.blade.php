@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
        	{{-- Title and Breadcrumbs --}}
        	<div class="row">
        	    {{-- Title --}}
        	    <h2 class="display-2 text-center">{{ $event->title }}</h2>
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
				<div class="row">		
					<div class="col">
						<div class="card" style="height: 20rem;">
						<div class="card-body">
								<h4 class="display-4 text-center">Posters</h4>
								{{-- TO FIX: OVERFLOW JUSTI --}}
								<div class="row d-flex justify-content-center flex-row flex-nowrap overflow-auto pb-2">
								@foreach($event->eventImages as $eventImage)
									@if($eventImage->image_type == 0)
									<div class="col-md-3">
										<a href="{{route('event.image.show', ['event_slug' => $event->slug, 'eventImage_slug' => $eventImage->slug])}}">
											<div class="card text-center w-20 h-100" style="border-color:black;">
												<img src="/storage/{{$eventImage->image}}" class="card-img-top w-100" style="max-height: 130px; width: 100px;">
												<div class="card-body">
													<p class="card-text" style="color:black;">{{$eventImage->caption}}</p>
												</div>
											</div>
										</a>
									</div>
									@endif
								@endforeach        		
								</div>
							</div>
						</div>
					</div>
				<div class="col">
					<div class="card"style="height: 20rem;">
					<div class="card-body">
							<h4 class="display-4 text-center pt-2">Evidences</h4>
							<div class="row d-flex justify-content-center flex-row flex-nowrap overflow-auto pb-2">
							@foreach($event->eventImages as $eventImage)
								@if($eventImage->image_type == 1)
								<div class="col-md-3">
									<a href="{{route('event.image.show', ['event_slug' => $event->slug, 'eventImage_slug' => $eventImage->slug])}}">
										<div class="card text-center w-20 h-100" style="border-color:black;">
											<img src="/storage/{{$eventImage->image}}" class="card-img-top w-100" style="max-width: 130px; height: 100px;">
											<div class="card-body">
												<p class="card-text" style="color:black;">{{$eventImage->caption}}</p>
											</div>
										</div>
									</a>
								</div>
								@endif
							@endforeach        		
							</div>
						</div>
					</div>
				</div>
        	<div class="flex-row my-2 text-center">
        	    <a href="{{route('event.show', ['event_slug' => $event->slug])}}"
        	    class="btn btn-secondary text-white"
        	    role="button">
        	        Go Back
        	    </a>
        	</div>
        </div>
    </div>
</div>
@endsection