@extends('layouts.admin-app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.tabularTables.store') }}" enctype="multipart/form-data" method="POST" id="tabularTableCreateForm">
        @csrf
        <div class="row">
            <div class="col-md-12">
                {{-- Title and Breadcrumbs --}}
                <div class="row">
                    {{-- Title --}}
                    <h4 class="display-5 text-center">Add Tabular AR Table</h4>
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
                                <a href="{{route('admin.maintenance.tabularTables.index')}}" class="text-decoration-none">
                                    Tabular AR Tables
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Add Table
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="card mb-3">
            <div class="card-header text-white bg-maroon">Add Tabular AR table</div>
                <div class="card-body">
                <div class="form-group row my-1">
                    <label for="tabularTableName" class="col-md-4 col-form-label align-middle fw-bold fs-3">Table Name</label>
                    <input id="tabularTableName" 
                    type="text" 
                    class="form-control @error('tabularTableName') is-invalid @enderror" 
                    name="tabularTableName" 
                    placeholder="Table Name"
                    value="{{ old('tabularTableName') }}" 
                    required>
                    @error('tabularTableName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row my-1">
                    <label for="description" class="col-md-4 col-form-label align-middle fw-bold fs-3">Description</label>    
                    <textarea id="description" 
                    class="form-control @error('description') is-invalid @enderror" 
                    name="description"
                    placeholder="Table Description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row my-1">
                    <label for="referenceTableNumber" class="col-md-4 col-form-label align-middle fw-bold fs-3">Reference Table No.</label>
                    <input id="referenceTableNumber" 
                    type="text" 
                    class="form-control @error('referenceTableNumber') is-invalid @enderror" 
                    name="referenceTableNumber" 
                    placeholder="Optional Reference Number"
                    value="{{ old('referenceTableNumber') }}">
                    @error('referenceTableNumber')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row my-2 text-center">
                    <h4><strong>You will need to inform an IT Personnel to add this table in code, as well as the necessary data for the columns that it will need.</strong></h4>
                </div>

                <div class="flex-row my-2 text-center">
                    <button class="btn btn-primary text-white"><i class="fas fa-plus"></i> Add Table</button>
                </div>
            </div>
        </div>
    </form>
</div>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.tabularTables.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>

</div>
@endsection

