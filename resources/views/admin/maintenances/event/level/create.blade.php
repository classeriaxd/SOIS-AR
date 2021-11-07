@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.levels.store') }}" enctype="multipart/form-data" method="POST" id="levelCreateForm">
        @csrf
        <div class="row">
            <div class="col-md-12">
                {{-- Title and Breadcrumbs --}}
                <div class="row">
                    {{-- Title --}}
                    <h4 class="display-5 text-center">Add Level</h4>
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
                                Add Level
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="form-group row my-1">
                    <label for="level" class="col-md-4 col-form-label">Level</label>
                    <input id="level" 
                    type="text" 
                    class="form-control @error('level') is-invalid @enderror" 
                    name="level" 
                    placeholder="Level"
                    value="{{ old('level') }}" 
                    required>
                    @error('level')
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
                    <button class="btn btn-primary text-white">Add Level</button>
                </div>
            </div>
        </div>
    </form>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.levels.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                Go Back
        </a>
    </div>

</div>
@endsection

