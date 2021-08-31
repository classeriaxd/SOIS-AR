@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
    		<h2 class="display-2 text-center">{{ $event->title }}</h2>
            <h4 class="display-5 text-center">Supporting Documents</h4>
            <div class="row justify-content-center mb-1">
                <form action="{{route('event_documents.downloadAll',['event_slug' => $event->slug])}}" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-primary">Download All</button>
                </form>
            </div>
            @foreach($eventDocuments as $document)
            <hr>
            <h4 class="display-4 text-center">{{ $document->document_type }}</h4>
        	<div class="row justify-content-center mb-1">
                <div class="col-md-11">
                    <iframe src="/storage{{$document->file}}#toolbar=0" width="100%" style="height:50vh;">
                    </iframe>
                </div>
                <div class="col-md-1">
                    <form action="{{route('event_documents.download',['event_slug' => $event->slug, 'document_id' => $document->event_document_id])}}" enctype="multipart/form-data">
                        <button type="submit" class="btn btn-primary">Download</button>
                    </form>
                    <br>
                    <form action="{{route('event_documents.destroy', ['event_slug' => $event->slug, 'document_id' => $document->event_document_id])}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger">Delete</button>
                    </form>  
                        
                    </a>
                </div>
            </div>
            @endforeach
            <hr>
            <div class="row justify-content-center mt-1">
                <a href="/e/{{$event->slug}}">
                    <button class="btn btn-secondary">Go back</button>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
