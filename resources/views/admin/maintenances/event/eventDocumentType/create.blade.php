@extends('layouts.admin-app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.eventDocumentTypes.store') }}" enctype="multipart/form-data" method="POST" id="eventDocumentTypeCreateForm">
        @csrf
        <div class="row">
            <div class="col-md-12">
                {{-- Title and Breadcrumbs --}}
                <div class="row">
                    {{-- Title --}}
                    <h4 class="display-5 text-center">Add Document Type</h4>
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
                                Add Event Document Type
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="card mb-3">
                    <div class="card-header text-white bg-maroon">Add Document Type</div>
                    <div class="card-body">
                        <div class="form-group row my-1">
                            <label for="documentType" class="col-md-4 col-form-label align-middle fw-bold fs-3">Event Document Type</label>
                            <input id="documentType" 
                            type="text" 
                            class="form-control @error('documentType') is-invalid @enderror" 
                            name="documentType" 
                            placeholder="Event Document Type"
                            value="{{ old('documentType') }}" 
                            required>
                            @error('documentType')
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
                            required>{{ old('helper') }}</textarea>
                            @error('helper')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="flex-row my-2 text-center">
                            <button class="btn btn-primary text-white"><i class="fas fa-plus"></i> Add Document Type</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.eventDocumentTypes.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>

</div>
@endsection

