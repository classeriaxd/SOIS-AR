@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.eventClassifications.store') }}" enctype="multipart/form-data" method="POST" id="eventClassificationCreateForm">
        @csrf
        <div class="row">
            <div class="col-md-12">
                {{-- Title and Breadcrumbs --}}
                <div class="row">
                    {{-- Title --}}
                    <h4 class="display-5 text-center">Add Classification</h4>
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
                                <a href="{{route('admin.maintenance.eventClassifications.index')}}" class="text-decoration-none">
                                    Event Classification
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Add Event Classification
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="form-group row my-1">
                    <label for="classification" class="col-md-4 col-form-label">Event Classification</label>
                    <input id="classification" 
                    type="text" 
                    class="form-control @error('classification') is-invalid @enderror" 
                    name="classification" 
                    placeholder="Event Classification"
                    value="{{ old('classification') }}"
                    required>
                    @error('classification')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row my-1">
                    <label for="helper" class="col-md-4 col-form-label">Helper/Description</label>    
                    <textarea id="helper" 
                    class="form-control @error('helper') is-invalid @enderror" 
                    name="helper"
                    placeholder="Helper/Description" 
                    required>{{ old('helper') }}</textarea>
                    @error('helper')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="flex-row my-2 text-center">
                    <button class="btn btn-primary text-white">Add Event Classification</button>
                </div>

            </div>
        </div>
    </form>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.eventClassifications.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                Go Back
        </a>
    </div>

</div>
@endsection
