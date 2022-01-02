@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-12">
            {{-- Success Alert --}}
                @if (session()->has('success'))
                    <div class="flex-row text-center" id="success_alert">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            {{-- Error Alert --}}
                @if (session()->has('error'))
                    <div class="flex-row text-center" id="error_alert">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

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

            {{-- Download All Button or No Document Indicator --}}
            @if($eventDocuments->count() > 0)
                <div class="d-flex justify-content-center text-center my-1">
                    <div class="me-2">
                        <form action="{{route('event.document.downloadAll',['event_slug' => $event->slug])}}" enctype="multipart/form-data" class="mr-2"
                            onsubmit="document.getElementById('downloadAll').disabled=true;">
                            <button id="downloadAll" type="submit" class="btn btn-primary text-white"><i class="fas fa-download"></i> Compile and Download All Documents</button>
                        </form>
                    </div>
                    
                    @if($deletedEventDocuments->isNotEmpty())
                        <div>
                            <a href="#deletedEventDocuments">
                                <button class="btn btn-secondary text-white">
                                    <i class="fas fa-long-arrow-alt-down"></i> Jump to Deleted Documents
                                </button>
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center">
                    <p>No document found. :( You can create one <a href="{{route('event.document.create',['event_slug' => $event->slug,])}}" style="color:blue;"><u>here</u></a></p>
                </div>
            @endif

            {{-- Documents Loop --}}
            @foreach($eventDocuments as $document)
                <div class="mt-3">
                    <h4 class="display-4 text-center">{{ $document->documentType->document_type }}</h4>
                    <h5 class="text-center">{{ $document->title }}</h5>
                </div>
            	<div class="row justify-content-center my-1 border border-dark">
                    <div class="col-10">
                        <iframe src="/storage{{$document->file}}#toolbar=0" width="100%" style="height:50vh;" class="border border-dark my-1">
                        </iframe>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="flex-fill">
                            <form action="{{route('event.document.download',['event_slug' => $event->slug, 'document_id' => $document->event_document_id])}}" enctype="multipart/form-data"
                                onsubmit="document.getElementById('downloadSingle').disabled=true;">
                                <button id="downloadSingle" type="submit" class="btn btn-primary text-white w-100">
                                    <i class="fas fa-download"></i> Download<br>{{ $document->title }}
                                </button>
                            </form>

                            <br>

                            <button class="btn btn-danger text-white w-100" data-bs-toggle="modal" data-bs-target="#areYouSureModal{{$loop->index}}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                        
                    </div>
                </div>

                {{-- Are you sure Modal --}}
                <div class="modal fade" id="areYouSureModal{{$loop->index}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="areYouSureModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="areYouSureModal">Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            Are you Sure?
                            </div>
                            <div class="modal-footer">
                                <form action="{{route('event.document.destroy', ['event_slug' => $event->slug, 'document_id' => $document->event_document_id])}}" method="POST"
                                    onsubmit="document.getElementById('deleteButton').disabled=true;">
                                    @method('DELETE')
                                    @csrf
                                
                                    <button id="deleteButton" type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                                    <button type="submit" class="btn btn-danger text-white"><i class="fas fa-check"></i> Understood</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Deleted Event Documents Table --}}
            @if($deletedEventDocuments->isNotEmpty())

                <div class="card w-100 mt-5 mb-2" id="deletedEventDocuments">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Deleted Event Documents</h5>

                    <table class="w-100 my-1 table table-bordered table-striped table-hover border border-dark">
                        <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                            <th>#</th>
                            <th>Document Type</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Deleted On</th>
                            <th>Option</th>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach($deletedEventDocuments as $document)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $document->documentType->document_type }}</td>
                                <td class="text-break">{{ $document->title }}</td>
                                <td class="text-break">{{ $document->description }}</td>
                                <td>{{ date_format(date_create($document->deleted_at), 'F d, Y') }}</td>
                                <td class="text-center">
                                    <form action="{{route('event.document.restore', ['event_slug' => $event->slug, 'document_id' => $document->event_document_id])}}" method="POST"
                                        onsubmit="document.getElementById('restoreButton').disabled=true;">
                                        @csrf
                                        <button id="restoreButton" type="submit" class="btn btn-success text-white">
                                            <i class="fas fa-trash-restore"></i> Restore
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @php $i += 1; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

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
