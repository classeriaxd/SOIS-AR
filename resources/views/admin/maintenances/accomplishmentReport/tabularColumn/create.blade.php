@extends('layouts.admin-app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.tabularTables.tabularColumns.store', ['tabular_table_id' => $tabularTable->tabular_table_id]) }}" enctype="multipart/form-data" method="POST" id="tabularColumnCreateForm">
        @csrf
        <div class="row">
            <div class="col-md-12">
                {{-- Title and Breadcrumbs --}}
                <div class="row">
                    {{-- Title --}}
                    <h4 class="display-5 text-center">Add Tabular AR Column</h4>
                    <h4 class="display-6 text-center">{{ $tabularTable->tabular_table_name }}</h4>
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
                                    {{ $tabularTable->tabular_table_name }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Add Column
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
                    placeholder="Column Name"
                    value="{{ old('tabularColumnName') }}" 
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
                    name="description"
                    placeholder="Description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="flex-row my-2 text-center">
                    <button class="btn btn-primary text-white"><i class="fas fa-plus"></i> Add Column</button>
                </div>
            </div>
        </div>
    </form>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.tabularTables.show', ['tabular_table_id' => $tabularTable->tabular_table_id]) }}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>

</div>
@endsection

