@extends('layouts.admin-app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h4 class="display-5 text-center">Add School Year</h4>
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
                            <a href="{{route('admin.maintenance.schoolYears.index')}}" class="text-decoration-none">
                                School Years
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add School Year
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="card mb-3">
                <div class="card-header text-white bg-maroon">Add School Year</div>
                <div class="card-body">
                    {{-- Add Years --}}
                    <form action="{{ route('admin.maintenance.schoolYears.store') }}" enctype="multipart/form-data" method="POST" id="schoolYearCreateForm"
                        onsubmit="document.getElementById('submitButtonAddYears').disabled=true;">
                            @csrf
                        <div class="form-group row my-1">
                            <label for="addYearSelect" class="col-md-4 col-form-label align-middle fw-bold fs-3">Add School Years to latest</label>
                            <select class="form-select text-center fw-bold" name="addYearSelect" id="addYearSelect" aria-label="addYearSelect" required>
                                <option selected disabled value="">Select years to add....</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{$i}}">
                                            @if($i == 1)
                                                {{$i . ' year'}}
                                            @else
                                                {{$i . ' years'}}
                                            @endif
                                    </option>
                                @endfor
                            </select>

                            <div class="flex-row my-1 text-center">
                                <button id="submitButtonAddYears" type="submit" class="btn btn-primary text-white" >
                                    <i class="fas fa-plus"></i> Add School Year/s
                                </button>
                            </div>
                            <input type="hidden" name="addYearWithSelect" value="addYearWithSelect">
                            @error('addYearWithSelect')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('addYearSelect')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>

                    <hr>

                    <form action="{{ route('admin.maintenance.schoolYears.store') }}" enctype="multipart/form-data" method="POST" id="schoolYearCreateForm"
                        onsubmit="document.getElementById('submitButtonCustom').disabled=true;">
                            @csrf
                        <div class="form-group row my-1">
                            <label for="addYearCustom" class="col-md-4 col-form-label align-middle fw-bold fs-3">Add School Year by year</label>
                            <input id="addYearCustom" 
                            type="number" 
                            class="form-control @error('addYearCustom') is-invalid @enderror" 
                            name="addYearCustom" 
                            placeholder="Year Start (ex. 2021)"
                            value="{{ old('addYearCustom') }}" 
                            required>
                            @error('addYearWithCustom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('addYearCustom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="flex-row my-1 text-center">
                            <button id="submitButtonCustom" type="submit" class="btn btn-primary text-white">
                                <i class="fas fa-plus"></i> Add School Year
                            </button>
                        </div>
                        <input type="hidden" name="addYearWithCustom" value="addYearWithCustom">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.schoolYears.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>
</div>
@endsection

