@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/o/documents" enctype="multipart/form-data" method="POST" id="OrganizationDocumentForm">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                <h2 class="text-center">Add New Organization Document</h2>
                <div class="form-group row">
                    <label for="document_type" class="col-md-4 col-form-label">Document</label>    
                    <select class= "form-control" name="document_type" id="document_type">
                      <option value>--Select Document Type--</option>
                      @foreach($doctypes as $doctype)
                            <option value="{{$doctype->orgdoctype_id}}">{{$doctype->doctype}}</option>
                      @endforeach
                    </select>
                    @error('document_type')
                        <span class="invalid-feedback" role="alert">\
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                     
                </div>
                <div class="form-group row">
                    <label for="file" class="col-md-4 col-form-label">Upload</label>    
                    <input type="text" name="file" id="file" class="form-control @error('file') is-invalid @enderror" 
                    name="file"
                    value= "{{ old('file') }}"
                    autocomplete="file"></input>
                    @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Title</label>
                    <input type="text" id="title" class="form-control @error('title') is-invalid @enderror" name="title"
                    value= "{{ old('title') }}"
                    autocomplete= "title"></input>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- TODO: Add option for multiple dates --}}
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label">Description</label>
                    <input id="description" 
                    type="text" 
                    class="form-control @error('description') is-invalid @enderror" 
                    name="description" 
                    value="{{ old('description') }}" autocomplete="description">
                    @error('meeting_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row pt-4">
                    <button class="btn btn-primary" type='submit'>Add Organization Document</button>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <div class="row justify-content-center">
        <a href="/home">
            <button class="btn btn-secondary">Go back</button>
        </a>
    </div>
</div>
@endsection
