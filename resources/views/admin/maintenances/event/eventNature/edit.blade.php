@extends('layouts.admin-app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.eventNatures.update', ['nature_id' => $eventNature->event_nature_id]) }}" enctype="multipart/form-data" method="POST" id="eventNatureUpdateForm">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-12">
                {{-- Title and Breadcrumbs --}}
                <div class="row">
                    {{-- Title --}}
                    <h4 class="display-5 text-center">Edit</h4>
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
                                Edit Event Nature
                            </li>
                        </ol>
                    </nav>
                </div>
            <div class="card mb-3">
                <div class="card-header text-white bg-maroon">Edit accomplishment</div>
                <div class="card-body">
                <div class="form-group row my-1">
                    <label for="nature" class="col-md-4 col-form-label align-middle fw-bold fs-3">Event Nature</label>
                    <input id="nature" 
                    type="text" 
                    class="form-control @error('nature') is-invalid @enderror" 
                    name="nature" 
                    placeholder="Event Nature"
                    value="{{ $eventNature->nature }}" 
                    required>
                    @error('nature')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row my-1">
                    <label for="helper" class="col-md-4 col-form-label align-middle fw-bold fs-3">Helper/Description</label>    
                    <textarea id="helper" 
                    class="form-control @error('helper') is-invalid @enderror" 
                    name="helper"
                    placeholder="Helper/Description" 
                    required>{{ $eventNature->helper }}</textarea>
                    @error('helper')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="flex-row d-flex text-center my-1">
                    <div class="col">
                        <input type="checkbox" class="form-check-input" id="notify" name="notify" >
                        <label class="form-check-label" for="notify">Do you want to notify the Organization Officers?</label>
                    </div>
                </div>

                <div class="flex-row my-2 text-center">
                    <button class="btn btn-primary text-white" type="submit">Update Event Nature</button>
                </div>
            </div>
        </div>
    </form>
</div>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.eventNatures.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                Go Back
        </a>
    </div>

</div>
@endsection

