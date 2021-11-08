@extends('layouts.admin-app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.fundSources.store') }}" enctype="multipart/form-data" method="POST" id="fundSourceCreateForm">
        @csrf
        <div class="row">
            <div class="col-md-12">
                {{-- Title and Breadcrumbs --}}
                <div class="row">
                    {{-- Title --}}
                    <h4 class="display-5 text-center">Add Fund Source</h4>
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
                                <a href="{{route('admin.maintenance.fundSources.index')}}" class="text-decoration-none">
                                    Fund Sources
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Add Fund Source
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="card mb-3">
            <div class="card-header text-white bg-maroon">Add Fund Source</div>
                <div class="card-body">
                <div class="form-group row my-1">
                    <label for="fundSource" class="col-md-4 col-form-label align-middle fw-bold fs-3">Fund Source</label>
                    <input id="fundSource" 
                    type="text" 
                    class="form-control @error('fundSource') is-invalid @enderror" 
                    name="fundSource" 
                    placeholder="Fund Source"
                    value="{{ old('fundSource') }}" 
                    required>
                    @error('fundSource')
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
                    <button class="btn btn-primary text-white">Add Fund Source</button>
                </div>
            </div>
        </div>
    </form>
</div>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.fundSources.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                Go Back
        </a>
    </div>

</div>
@endsection
