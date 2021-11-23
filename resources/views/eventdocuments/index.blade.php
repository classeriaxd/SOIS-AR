@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Supporting Documents - {{ $event->title }}</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('event.index')}}" class="text-decoration-none">Events</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('event.show', ['event_slug' => $event->slug])}}" class="text-decoration-none"> {{ $event->title }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Documents
                        </li>
                    </ol>
                </nav>
            </div>

            @if($eventDocuments->count() > 0)
                <div class="flex-row text-center my-1">
                    <form action="{{route('event.document.downloadAll',['event_slug' => $event->slug])}}" enctype="multipart/form-data">
                        <button type="submit" class="btn btn-primary text-white"><i class="fas fa-download"></i> Download All</button>
                    </form>
                </div>
            @else
                <div class="text-center">
                    <p>No document found. :( You can create one <a href="{{route('event.document.create',['event_slug' => $event->slug,])}}" style="color:blue;"><u>here</u></a></p>
                </div>
            @endif

            @foreach($eventDocuments as $document)
            <h4 class="display-4 text-center">{{ $document->document_type }}</h4>
        	<div class="row justify-content-center mb-1">
                <div class="col-md-10">
                    <iframe src="/storage{{$document->file}}#toolbar=0" width="100%" style="height:50vh;">
                    </iframe>
                </div>
                <div class="col">
                    <form action="{{route('event.document.download',['event_slug' => $event->slug, 'document_id' => $document->event_document_id])}}" enctype="multipart/form-data">
                        <button type="submit" class="btn btn-primary text-white"><i class="fas fa-download"></i> Download</button>
                    </form>
                    <br>
                    <form action="{{route('event.document.destroy', ['event_slug' => $event->slug, 'document_id' => $document->event_document_id])}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger text-white"><i class="fas fa-trash"></i> Delete</button>
                    </form>  
                        
                    </a>
                </div>
            </div>
            <hr>
            @endforeach

            <div class="flex-row my-2 text-center">
                <a href="{{route('event.show', ['event_slug' => $event->slug])}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-arrow-left"></i> Go Back
                </a>

                <span>or</span>

                <a href="{{route('event.document.create',['event_slug' => $event->slug,])}}"
                    class="btn btn-primary text-white"
                    role="button">
                    <i class="fas fa-file-pdf"></i> Add a Document
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
