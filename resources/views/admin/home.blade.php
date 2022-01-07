@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Login Alert --}}
                @if ($loginAlert != NULL)
                    <div id="login_alert" style="position:fixed; top:0; right:0; width:20%;">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $loginAlert }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Dashboard</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item active" aria-current="page">
                            Home
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-success">
                                <span class="material-icons">groups</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>School Organizations</strong></p>
                            <h3 class="card-title">{{ $organizationCount ?? 0 }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="{{ route('admin.organizations.index') }}">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-info">
                                <span class="material-icons">task</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Accomplishment Reports</strong></p>
                            <h3 class="card-title">{{ $accomplishmentReportCount ?? 0 }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="{{ route('admin.accomplishmentReports.index') }}">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header">
                            <div class="icon icon-rose">
                            <span class="material-icons">description</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="category"><strong>Event Reports</strong></p>
                            <h3 class="card-title">{{ $eventCount ?? 0 }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="{{ route('admin.events.index') }}">More info
                                    <i class="material-icons more-info">arrow_circle_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notification Form --}}
            <form action="{{route('admin.notifications.store')}}" enctype="multipart/form-data" method="POST" id="adminNotificationCreateForm"
                onsubmit="document.getElementById('submitButton').disabled=true;">

                <div class="card w-100">
                    <h5 class="card-header card-title text-center bg-maroon text-black fw-bold">Send an Announcement</h5>
                    <div class="card-body">
                        
                            {{-- Notification Title --}}
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label">Title<span class="required">*</span></label>
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
                                placeholder="Notification Description" 
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
                        
                    </div>
                </div>
            </form>
        </div>

            
        
    </div>
</div>
@endsection


@section('scripts')
    <script type="text/javascript">
        {{-- LOGIN ALERT TIMEOUT --}}
        window.setTimeout(function() {
            $("#login_alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 3000);
    </script>

    {{-- Enable Popovers --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap_related_js/enablePopover.js') }}"></script>
@endsection
