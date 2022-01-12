@extends('layouts.admin-app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.schoolYears.update', ['school_year_id' => $schoolYear->school_year_id]) }}" enctype="multipart/form-data" method="POST" id="schoolYearUpdateForm"
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
                                <a href="{{route('admin.maintenance.schoolYears.index')}}" class="text-decoration-none">
                                    School Years
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit School Year
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="card mb-3">
                    <div class="card-header text-white bg-maroon">Edit School Year</div>
                    <div class="card-body">
                        <h3 class="text-center">
                            School Year {{$schoolYear->year_start . ' - ' . $schoolYear->year_end}}
                        </h3>

                        {{-- First Semester --}}
                        <div class="row mb-1">
                            <div class="col">
                                <label for="firstSemesterStart" class="col-md-4 form-label">First Semester Start<span class="required">*</span></label>
                                <input id="firstSemesterStart" 
                                type="date" 
                                class="form-control @error('firstSemesterStart') is-invalid @enderror" 
                                name="firstSemesterStart" 
                                value="{{ date_format(date_create($schoolYear->first_semester_start),'Y-m-d') }}" 
                                min="{{ date_format(date_create($schoolYear->year_start . '-01-01'),'Y-m-d') }}" 
                                max="{{ date_format(date_create($schoolYear->year_end . '-12-31'),'Y-m-d') }}"
                                required>
                                @error('firstSemesterStart')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="firstSemesterEnd" class="col-md-4 form-label">First Semester End<span class="required">*</span></label>
                                <input id="firstSemesterEnd" 
                                type="date" 
                                class="form-control @error('firstSemesterEnd') is-invalid @enderror" 
                                name="firstSemesterEnd" 
                                value="{{ date_format(date_create($schoolYear->first_semester_end),'Y-m-d') }}" 
                                min="{{ date_format(date_create($schoolYear->year_start . '-01-01'),'Y-m-d') }}" 
                                max="{{ date_format(date_create($schoolYear->year_end . '-12-31'),'Y-m-d') }}"
                                required>
                                @error('firstSemesterEnd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Second Semester --}}
                        <div class="row my-1">
                            <div class="col">
                                <label for="secondSemesterStart" class="col-md-4 form-label">Second Semester Start<span class="required">*</span></label>
                                <input id="secondSemesterStart" 
                                type="date" 
                                class="form-control @error('secondSemesterStart') is-invalid @enderror" 
                                name="secondSemesterStart" 
                                value="{{ date_format(date_create($schoolYear->second_semester_start),'Y-m-d') }}" 
                                min="{{ date_format(date_create($schoolYear->year_start . '-01-01'),'Y-m-d') }}" 
                                max="{{ date_format(date_create($schoolYear->year_end . '-12-31'),'Y-m-d') }}"
                                required>
                                @error('secondSemesterStart')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="secondSemesterEnd" class="col-md-4 form-label">Second Semester End<span class="required">*</span></label>
                                <input id="secondSemesterEnd" 
                                type="date" 
                                class="form-control @error('secondSemesterEnd') is-invalid @enderror" 
                                name="secondSemesterEnd" 
                                value="{{ date_format(date_create($schoolYear->second_semester_end),'Y-m-d') }}" 
                                min="{{ date_format(date_create($schoolYear->year_start . '-01-01'),'Y-m-d') }}" 
                                max="{{ date_format(date_create($schoolYear->year_end . '-12-31'),'Y-m-d') }}"
                                required>
                                @error('secondSemesterEnd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Summer Term --}}
                        <div class="row my-1">
                            <div class="col">
                                <label for="summerTermStart" class="col-md-4 form-label">Summer Term Start<span class="required">*</span></label>
                                <input id="summerTermStart" 
                                type="date" 
                                class="form-control @error('summerTermStart') is-invalid @enderror" 
                                name="summerTermStart" 
                                value="{{ date_format(date_create($schoolYear->summer_term_start),'Y-m-d') }}" 
                                min="{{ date_format(date_create($schoolYear->year_start . '-01-01'),'Y-m-d') }}" 
                                max="{{ date_format(date_create($schoolYear->year_end . '-12-31'),'Y-m-d') }}"
                                required>
                                @error('summerTermStart')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="summerTermEnd" class="col-md-4 form-label">Summer Term End<span class="required">*</span></label>
                                <input id="summerTermEnd" 
                                type="date" 
                                class="form-control @error('summerTermEnd') is-invalid @enderror" 
                                name="summerTermEnd" 
                                value="{{ date_format(date_create($schoolYear->summer_term_end),'Y-m-d') }}" 
                                min="{{ date_format(date_create($schoolYear->year_start . '-01-01'),'Y-m-d') }}" 
                                max="{{ date_format(date_create($schoolYear->year_end . '-12-31'),'Y-m-d') }}"
                                required>
                                @error('summerTermEnd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex-row my-2 text-center">
                            <button id="submitButton" class="btn btn-primary text-white" type="submit">
                                <i class="fas fa-edit"></i> Update School Year
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
