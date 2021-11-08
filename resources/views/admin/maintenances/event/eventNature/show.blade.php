@extends('layouts.admin-app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h4 class="display-5 text-center">{{ $eventNature->nature }}</h4>
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
                            <a href="{{route('admin.maintenance.eventNatures.index')}}" class="text-decoration-none">
                                Event Natures
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                           {{ $eventNature->nature }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="flex-row d-flex justify-content-center">
                <div class="card w-50 text-center">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Event Nature: {{ $eventNature->nature }}</h5>
                    <div class="card-body">
                        <p class="card-text">{{ $eventNature->helper }}</p>
                        <hr class="my-2">
                        <p class="card-text my-1">Options</p>
                        <div class="flex-row">
                            <a href="{{ route('admin.maintenance.eventNatures.edit', ['nature_id' => $eventNature->nature]) }}"
                                class="btn btn-primary text-white mx-1"
                                role="button">
                                    Edit Nature
                            </a>
                            <a href="#"
                                class="btn btn-danger text-white mx-1"
                                role="button"
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteEventNatureReminderModal">
                                    Delete Nature
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.eventNatures.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                Go Back
        </a>
    </div>

    {{-- Event Nature Delete Reminder Modal --}}
        <div class="modal fade" id="deleteEventNatureReminderModal" tabindex="-1" aria-labelledby="deleteEventNatureReminderLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-maroon text-white fw-bold">
                        <h5 class="modal-title" id="deleteEventNatureReminderLabel">Event Nature Deletion</h5>
                        <button type="button" class="btn-close text-white bg-maroon" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-center">Reminder for Event Nature Deletion</h5>
                        <ul>
                            <li>Deleted Event Nature will not be permanently deleted and can be restored.</li>
                            <li>All Events that have this event nature will not be affected/deleted.</li>
                            <li>A Notification will be sent to all concerned members of the Organization (Documentation Officers and President).</li>
                            <li>This Event Nature will not be made available as a choice for creating future Events.</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" 
                            class="btn btn-danger text-white" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteEventNatureModal"
                            data-bs-dismiss="modal">
                            Proceed
                        </button>
                    </div>
                </div>
            </div>
        </div>

    {{-- Event Nature Delete Modal --}}
        <div class="modal fade" id="deleteEventNatureModal" tabindex="-1" aria-labelledby="deleteEventNatureLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{route('admin.maintenance.eventNatures.destroy', ['nature_id' => $eventNature->event_nature_id])}}" method="POST" id="eventNatureDeleteForm">
                        @method('DELETE')
                        @csrf

                        <div class="modal-header bg-maroon text-white fw-bold">
                            <h5 class="modal-title" id="deleteEventNatureLabel">Event Nature Deletion</h5>
                            <button type="button" class="btn-close text-white bg-maroon" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5 class="text-center fw-bold">Verification</h5>
                            <div class="form-group row my-1">
                                <label for="verification" class="form-label text-center">Please type <b>{{ $eventNature->nature }}</b> to confirm</label>
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
                                value="{{ 'SYSTEM: Deletion of Event Nature: ' .  $eventNature->nature}}" 
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
                                required>{{ 'The Event Nature:  ' . $eventNature->nature . ', will not be available on future creation of Events. (State your reasons/intentions here and other plans for this event nature.)' }}</textarea>
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
                            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger text-white">Proceed</button>
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
                var deleteEventRoleModal = new bootstrap.Modal(document.getElementById('deleteEventRoleModal'));
                deleteEventRoleModal.show();
            @endif
        });
    </script>
@endsection
