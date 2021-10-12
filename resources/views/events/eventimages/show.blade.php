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
                            Image
                        </li>
                    </ol>
                </nav>
            </div>

        	<div class="row justify-content-center pb-1">
        		<div class="col-md-5">
        			<div class="card h-100">
                        <div class="card-header text-center align-middle">
                            <div class="display-5">Image</div>
                        </div>
                        <img src="/storage/{{$event->eventImage->image}}" class="card-img-middle w-100" style="width:500px;">
                        <div class="card-footer text-center align-middle">
                            <h5 class="display-5">
                                @if($event->eventImage->image_type == 0)
                                    Poster
                                @else
                                    Evidence
                                @endif
                            </h5>
                        </div>
                    </div>  
        		</div>
                <div class="col-md-5">
                    <div class="card h-100">
                        <div class="card-header text-center align-middle">
                            <div class="display-5">Caption</div>
                        </div>
                        <div class="card-body text-center align-middle">
                            <p class="card-text">
                                {{$event->eventImage->caption ?? 'No Caption Provided'}}
                            </p>
                        </div>
                        <div class="card-header text-center align-middle" style="border: 1px;">
                            <div class="display-5">Options</div>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <a href="{{route('event.image.edit', ['event_slug' => $event->slug, 'eventImage_slug' => $event->eventImage->slug])}}">
                                <button class="btn btn-primary me-3 text-white">Edit</button>
                            </a>
                            <form action="{{route('event.image.destroy', ['event_slug' => $event->slug, 'eventImage_slug' => $event->eventImage->slug])}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger text-white" type="submit">Delete Image</button>
                            </form>  
                        </div>
                    </div>
                </div>
        	</div>	 
        	<hr>

            <div class="flex-row my-2 text-center">
                <a href="{{route('event.image.index', ['event_slug' => $event->slug])}}"
                class="btn btn-secondary text-white"
                role="button">
                    Go Back
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
