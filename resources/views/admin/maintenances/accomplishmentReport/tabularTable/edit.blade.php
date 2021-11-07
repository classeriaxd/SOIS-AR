@extends('layouts.admin-app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.tabularTables.update', ['tabular_table_id' => $tabularTable->tabular_table_id]) }}" enctype="multipart/form-data" method="POST" id="tabularTableUpdateForm">
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
                                <a href="{{route('admin.maintenance.tabularTables.index')}}" class="text-decoration-none">
                                    Tabular AR Tables
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Table
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="form-group row my-1">
                    <label for="tabularTableName" class="col-md-4 col-form-label">Table Name</label>
                    <input id="tabularTableName" 
                    type="text" 
                    class="form-control @error('tabularTableName') is-invalid @enderror" 
                    name="tabularTableName" 
                    value="{{ $tabularTable->tabular_table_name }}" 
                    required>
                    @error('tabularTableName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row my-1">
                    <label for="description" class="col-md-4 col-form-label">Description</label>    
                    <textarea id="description" 
                    class="form-control @error('description') is-invalid @enderror" 
                    name="description"
                    placeholder="No Description Provided" 
                    required>{{ $tabularTable->description }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row my-1">Reference Table No.</label>
                    <input id="referenceTableNumber" 
                    type="text" 
                    class="form-control @error('referenceTableNumber') is-invalid @enderror" 
                    name="referenceTableNumber" 
                    value="{{ $tabularTable->reference_table_number }}" 
                    required>
                    @error('referenceTableNumber')
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

                {{-- Insert Prompt --}}
                <div class="flex-row my-2 text-center">
                    <button class="btn btn-primary text-white" type="submit">Update Table</button>
                </div>
            </div>
        </div>
    </form>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.tabularTables.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                Go Back
        </a>
    </div>

</div>

@endsection

