@extends('layouts.admin-app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.tabularTables.tabularColumns.update', ['tabular_table_id' => $tabularTable->tabular_table_id, 'tabular_column_id' => $tabularColumn->tabular_column_id]) }}" enctype="multipart/form-data" method="POST" id="tabularColumnUpdateForm">
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
                                <a href="{{ route('admin.maintenance.tabularTables.index') }}" class="text-decoration-none">
                                    Tabular AR Tables
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.maintenance.tabularTables.show', ['tabular_table_id' => $tabularTable->tabular_table_id]) }}" class="text-decoration-none">
                                    {{ $tabularTable->tabular_table_name }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Tabular AR Column
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="form-group row my-1">
                    <label for="tabularColumnName" class="col-md-4 col-form-label">Column Name</label>
                    <input id="tabularColumnName" 
                    type="text" 
                    class="form-control @error('tabularColumnName') is-invalid @enderror" 
                    name="tabularColumnName" 
                    value="{{ $tabularColumn->tabular_column_name }}" 
                    required>
                    @error('tabularColumnName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row my-1">
                    <label for="description" class="col-md-4 col-form-label">Description</label>
                    <textarea id="description" 
                    class="form-control @error('description') is-invalid @enderror" 
                    placeholder="No Description Provided" 
                    name="description">{{ $tabularColumn->description }}</textarea>
                    @error('description')
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
                    <button class="btn btn-primary text-white" type="submit">Update Tabular Column</button>
                </div>
            </div>
        </div>
    </form>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.tabularTables.show', ['tabular_table_id' => $tabularTable->tabular_table_id]) }}"
            class="btn btn-secondary text-white"
            role="button">
                Go Back
        </a>
    </div>

</div>

@endsection

