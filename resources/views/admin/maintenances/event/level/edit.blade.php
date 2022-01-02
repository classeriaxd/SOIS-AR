@extends('layouts.admin-app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.levels.update', ['level_id' => $level->level_id]) }}" enctype="multipart/form-data" method="POST" id="levelUpdateForm"
        onsubmit="document.getElementById('submitButton').disabled=true;">
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
                                <a href="{{route('admin.maintenance.levels.index')}}" class="text-decoration-none">
                                    Levels
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Level
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="card mb-3">
            <div class="card-header text-white bg-maroon">Edit Level</div>
                <div class="card-body">
                <div class="form-group row my-1">
                    <label for="level" class="col-md-4 col-form-label align-middle fw-bold fs-3">Level</label>
                    <input id="level" 
                    type="text" 
                    class="form-control @error('level') is-invalid @enderror" 
                    name="level" 
                    placeholder="Level"
                    value="{{ $level->level }}" 
                    required>
                    @error('level')
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
                    required>{{ $level->helper }}</textarea>
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
                    <button id="submitButton" class="btn btn-primary text-white" type="submit"><i class="fas fa-edit"></i> Update Level</button>
                </div>
            </div>
        </div>
    </form>
</div>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.levels.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>

</div>

@endsection

