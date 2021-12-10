@extends('layouts.admin-app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h4 class="display-5 text-center">{{ $documentType->document_type }}</h4>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Maintenances
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.maintenance.eventDocumentTypes.index')}}" class="text-decoration-none">
                                Event Document Types
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                           {{ $documentType->document_type }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="flex-row d-flex justify-content-center">
                <div class="card w-50 text-center">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Document Type: {{ $documentType->document_type }}</h5>
                    <div class="card-body">
                        @if($documentType->deleted_at !== NULL)
                            <p class="card-text"><span class="badge rounded-pill bg-danger text-white">Status: DELETED</span></p>
                        @endif
                        <p class="card-text">{{ $documentType->helper }}</p>
                        <hr class="my-2">
                        <p class="card-text my-1">Options</p>
                        <div class="flex-row">
                            @if($documentType->deleted_at !== NULL)
                                <form action="{{ route('admin.maintenance.eventDocumentTypes.restore', ['document_type_id' => $documentType->event_document_type_id]) }}" enctype="multipart/form-data" method="POST" id="eventDocumentTypeRestoreForm">
                                    @csrf
                                    <button class="btn btn-success text-white mx-1" type="submit">Restore Document Type</button>
                                </form>  
                                </a>
                            @else
                                <a href="{{ route('admin.maintenance.eventDocumentTypes.edit', ['document_type_id' => $documentType->event_document_type_id]) }}"
                                    class="btn btn-primary text-white mx-1"
                                    role="button">
                                        Edit Document Type
                                </a>
                                <a href="#"
                                    class="btn btn-danger text-white mx-1"
                                    role="button"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteEventDocumentTypeReminderModal">
                                        Delete Document Type
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.eventDocumentTypes.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>

    {{-- Event Document Type Delete Reminder Modal --}}
        <div class="modal fade" id="deleteEventDocumentTypeReminderModal" tabindex="-1" aria-labelledby="deleteEventDocumentTypeReminderLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-maroon text-white fw-bold">
                        <h5 class="modal-title" id="deleteEventDocumentTypeReminderLabel">Event Document Type Deletion</h5>
                        <button type="button" class="btn-close text-white bg-maroon" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-center">Reminder for Event Document Type Deletion</h5>
                        <ul>
                            <li>Deleted Document Types will not be permanently deleted and can be restored.</li>
                            <li>All Event Documents that have this document type will not be affected/deleted.</li>
                            <li>A Notification will be sent to all concerned members of the Organization (Documentation Officers and President).</li>
                            <li>This Event Document Type will not be made available as a choice for creating future Event Documents.</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                        <button type="button" 
                            class="btn btn-danger text-white" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteEventDocumentTypeModal"
                            data-bs-dismiss="modal">
                            <i class="fas fa-check"></i> Proceed
                        </button>
                    </div>
                </div>
            </div>
        </div>

    {{-- Event Document Type Delete Modal --}}
        <div class="modal fade" id="deleteEventDocumentTypeModal" tabindex="-1" aria-labelledby="deleteEventDocumentTypeLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{route('admin.maintenance.eventDocumentTypes.destroy', ['document_type_id' => $documentType->event_document_type_id])}}" method="POST" id="eventDocumentTypeDeleteForm">
                        @method('DELETE')
                        @csrf

                        <div class="modal-header bg-maroon text-white fw-bold">
                            <h5 class="modal-title" id="deleteEventDocumentTypeLabel">Event Document Type Deletion</h5>
                            <button type="button" class="btn-close text-white bg-maroon" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5 class="text-center fw-bold">Verification</h5>
                            <div class="form-group row my-1">
                                <label for="verification" class="form-label text-center">Please type <b>{{ $documentType->document_type }}</b> to confirm</label>
                                <input id="verification" 
                                type="text" 
                                class="form-control text-center @error('verification') is-invalid @enderror border border-danger text-danger fw-bold" 
                                name="verification" 
                                autofocus
                                required>
                                @error('verification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <hr>
                            <h5 class="text-center fw-bold">Notification Form</h5>
                            <div class="form-group row my-2">
                                <label for="notificationTitle" class="form-label">Notification Title</label>
                                <input id="notificationTitle" 
                                type="text" 
                                class="form-control @error('notificationTitle') is-invalid @enderror" 
                                name="notificationTitle" 
                                value="{{ 'SYSTEM: Deletion of Event Document Type: ' .  $documentType->document_type}}" 
                                required>
                                @error('notificationTitle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group row my-2">
                                <label for="notificationDescription" class="form-label">Description</label>    
                                <textarea id="notificationDescription" 
                                class="form-control @error('notificationDescription') is-invalid @enderror" 
                                name="notificationDescription"
                                rows="6"
                                required>{{ 'The Event Document Type:  ' . $documentType->document_type . ', will not be available on future creation of Event Documents. (State your reasons/intentions here and other plans for this event document type.)' }}</textarea>
                                @error('notificationDescription')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row text-center">
                                <small>If the fields are empty, please refresh the page.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                            <button type="submit" class="btn btn-danger text-white"><i class="fas fa-check"></i> Proceed</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) { 
            @if (count($errors) > 0)
                var deleteEventDocumentTypeModal = new bootstrap.Modal(document.getElementById('deleteEventDocumentTypeModal'));
                deleteEventDocumentTypeModal.show();
            @endif
        });
    </script>
@endsection

