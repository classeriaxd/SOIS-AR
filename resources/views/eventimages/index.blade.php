@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
        	<h2 class="display-2 text-center">{{ $event->title }}</h2>
        	<h4 class="display-4 text-center">Posters</h4>
        	{{-- TO FIX: OVERFLOW JUSTI --}}
        	<div class="row d-flex justify-content-center flex-row flex-nowrap overflow-auto pb-2">
@foreach($eventImages as $eventImage)
    @if($eventImage->image_type == 0)
	    		<div class="col-md-3">
	    			<a href="/e/{{$event->slug}}/images/{{$eventImage->slug}}">
						<div class="card text-center w-20 h-100" style="border-color:black;">
							<img src="/storage/{{$eventImage->image}}" class="card-img-top w-100" style="width:400px;">
							<div class="card-body">
								<p class="card-text" style="color:black;">{{$eventImage->caption}}</p>
							</div>
		    			</div>
		    		</a>
		    	</div>
   	@endif
@endforeach        		
        	</div>
        	<hr>
        	<h4 class="display-4 text-center pt-2">Evidences</h4>
        	<div class="row d-flex justify-content-center flex-row flex-nowrap overflow-auto pb-2">
@foreach($eventImages as $eventImage)
    @if($eventImage->image_type == 1)
		    	<div class="col-md-3">
		    		<a href="/e/{{$event->slug}}/images/{{$eventImage->slug}}">
						<div class="card text-center w-20 h-100" style="border-color:black;">
							<img src="/storage/{{$eventImage->image}}" class="card-img-top w-100" style="width:400px;">
							<div class="card-body">
								<p class="card-text" style="color:black;">{{$eventImage->caption}}</p>
							</div>
						</div>
					</a>
				</div>
   	@endif
@endforeach        		
        	</div>
        	<hr>
        	<div class="row justify-content-center pt-1">
        		<a href="/e/{{$event->id}}">
        			<button class="btn btn-secondary">Go back</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection