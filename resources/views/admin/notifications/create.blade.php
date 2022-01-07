@extends('layouts.admin-app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h2 class="display-2 text-center">Create Notification</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.notifications.index')}}" class="text-decoration-none">Notifications</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Create
                        </li>
                    </ol>
                </nav>
            </div>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-8">
                    
                    <div class="card">
                        <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Create Notification</h5>
                        <div class="card-body">
                            <form action="{{route('admin.notifications.store')}}" enctype="multipart/form-data" method="POST" id="adminNotificationCreateForm"
                            onsubmit="document.getElementById('submitButton').disabled=true;">
                                {{-- Notification Title --}}
                                <div class="form-group row">
                                    <label for="title" class="col-md-4 col-form-label">Title<span style="color:red">*</span></label>
                                    <input id="title" 
                                    type="text" 
                                    class="form-control @error('title') is-invalid @enderror" 
                                    name="title"
                                    placeholder="Notification Title" 
                                    value="{{ old('title') }}" 
                                    autofocus 
                                    required>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Notification Description --}}
                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label">Description<span class="required">*</span></label>    
                                    <textarea id="description" 
                                    class="form-control @error('description') is-invalid @enderror" 
                                    name="description"
                                    placeholder="Description" 
                                    required>{{ old('description')}}</textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Reciever Organization --}}
                                <div class="form-group row">
                                    <label for="organizationSelect" class="col-md-8 col-form-label">Organization<span class="required">*</span> (select one or more)
                                        <a role="button"
                                            data-bs-toggle="popover"
                                            data-bs-container="body" 
                                            data-bs-trigger="hover focus"
                                            title="Selecting Organizations" 
                                            data-bs-content="You can select multiple Organizations by click-and-drag, or hold the CTRL key then click."
                                            data-bs-placement="right">
                                            <i class="far fa-question-circle"></i>
                                        </a>
                                    </label>
                                    
                                    <select class="form-select" id="organizationSelect" name="organization[]" multiple required>
                                        @foreach($organizations as $organization)
                                            <option class="text-truncate" value="{{$organization->organization_id}}">{{'(' . $organization->organization_acronym . ') ' . $organization->organization_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('organization')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Reciever Users --}}
                                <div class="form-group row">
                                    <label for="userRecieverRadioGroup" class="col-md-4 col-form-label">Reciever</label>
                                    <div id="userRecieverRadioGroup">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="reciever" id="userRecieverRadioGroup-All" value="All" required>
                                            <label class="form-check-label" for="userRecieverRadioGroup-All">All</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="reciever" id="userRecieverRadioGroup-Officers" value="Officers" required>
                                            <label class="form-check-label" for="userRecieverRadioGroup-Officers">Officers</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="reciever" id="userRecieverRadioGroup-Presidents" value="Presidents" required>
                                            <label class="form-check-label" for="userRecieverRadioGroup-Presidents">Presidents</label>
                                        </div>
                                    </div>
                                    @error('reciever')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group flex-row text-center">
                                    @csrf
                                    <button id="submitButton" class="btn btn-primary text-white" type="submit"><i class="fas fa-paper-plane"></i> Send Notification</button>
                                </div>
                            </form>

                        </div>
                    </div>
        		</div>
        	</div>

        	<hr>

        	<div class="flex-row my-2 text-center">
                <a href="{{route('admin.home')}}"
                class="btn btn-secondary text-white"
                role="button">
                    <i class="fas fa-home"></i> Go Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Enable Popovers --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap_related_js/enablePopover.js') }}"></script>
@endsection
