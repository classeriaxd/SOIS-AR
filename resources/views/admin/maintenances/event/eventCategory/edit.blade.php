@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{ route('admin.maintenance.eventCategories.update', ['category_id' => $eventCategory->event_category_id]) }}" enctype="multipart/form-data" method="POST" id="eventCategoryUpdateForm">
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
                                <a href="{{route('admin.maintenance.eventCategories.index')}}" class="text-decoration-none">
                                    Event Categories
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Add Event Category
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="form-group row my-1">
                    <label for="category" class="col-md-4 col-form-label">Category</label>
                    <input id="category" 
                    type="text" 
                    class="form-control @error('category') is-invalid @enderror" 
                    name="category" 
                    placeholder="Category"
                    value="{{ $eventCategory->category }}" 
                    onchange="changeText('sample')" 
                    required>
                    @error('category')
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
                    required>{{ $eventCategory->helper }}</textarea>
                    @error('helper')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="flex-row d-flex justify-content-evenly my-1">
                    <div class="col">
                        <div class="form-group row my-1 justify-content-center">
                            <label for="background_color" class="col-md-4 col-form-label">Pick Background Color</label>
                            <input type="color" 
                            class="form-control form-control-color" 
                            name="background_color"
                            id="background_color"
                            value="{{ $eventCategory->background_color }}"
                            onchange="changeSampleBackgroundColor('sample')">
                            @error('background_color')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row my-1 justify-content-center">
                            <label for="text_color" class="col-md-4 col-form-label">Pick Text Color</label>
                            <input type="color" 
                            class="form-control form-control-color" 
                            name="text_color"
                            id="text_color"
                            value="{{ $eventCategory->text_color }}"
                            onchange="changeSampleTextColor('sample')">
                            @error('text_color')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col d-flex align-items-center justify-content-center">
                        <div class="flex-row">
                            <span class="badge rounded-pill border border-dark fs-4"
                            id="sample">{{ $eventCategory->category }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex-row d-flex text-center my-1">
                    <div class="col">
                        <input type="checkbox" class="form-check-input" id="notify" name="notify" >
                        <label class="form-check-label" for="notify">Do you want to notify the Organization Officers?</label>
                    </div>
                </div>

                <div class="flex-row my-2 text-center">
                    <button class="btn btn-primary text-white" type="submit">Update Event Category</button>
                </div>
            </div>
        </div>
    </form>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.eventCategories.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                Go Back
        </a>
    </div>

</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) { 
            changeSampleTextColor('sample');
            changeSampleBackgroundColor('sample');
        });

        function changeSampleBackgroundColor(elementID)
        {
            document.getElementById(elementID).style.backgroundColor = document.getElementById("background_color").value;
        }
        function changeSampleTextColor(elementID)
        {
            document.getElementById(elementID).style.color = document.getElementById("text_color").value;
        }
        function changeText(elementID)
        {
            document.getElementById(elementID).textContent = document.getElementById("category").value;
        }
        
    </script>
    
@endsection

