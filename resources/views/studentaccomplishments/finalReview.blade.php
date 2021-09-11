@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
    		<h2 class="display-2 text-center">Final Review</h2>
            <h5 class="display-5 text-center">Final edits for the Accomplishment Submission</h6>
            <form action="{{route('student_accomplishment.approveSubmission',['accomplishment_uuid' => $accomplishment->accomplishment_uuid,]);}}" method="POST" id="approvedSubmissionForm">   
            	<div class="row justify-content-center pb-1">
                    <div class="col-md-8">
                        <div class="card">
                            <h5 class="card-header card-title text-center">{{ $accomplishment->title }}</h5>
                            <div class="card-body">
                                <h6 class="text-center text-dark font-weight-bold"><span class="bg-warning rounded">Student Details</span></h6>
                                <div class="text-center">
                                    <p>Name: {{ $student->name ?? 'NONE' }}</p>
                                    <p>Student Number: {{$student->student_number ?? 'NONE' }}</p>
                                    <p>Email: {{$student->email ?? 'NONE' }}</p>
                                </div>
                                <hr>
                                <h6 class="text-center text-dark font-weight-bold"><span class="bg-warning rounded">Accomplishment Details</span></h6>
                                <div class="form-group row">
                                    <label for="title" class="col-md-4 col-form-label">Title</label>
                                    <input id="title" 
                                    type="text" 
                                    class="form-control @error('title') is-invalid @enderror" 
                                    name="title" 
                                    value="{{ $accomplishment->title }}" 
                                    required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label">Description</label>    
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" 
                                    name="description"
                                    required>{{ $accomplishment->description }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="date_awarded" class="col-md-4 col-form-label">Date Awarded</label>    
                                    <input type="date" class="form-control" name="date_awarded" min="1992-01-01" max="{{date('Y-m-d')}}" value="{{ $accomplishment->date_awarded }}">
                                    @error('date_awarded')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <hr>
                                <h5 class="text-center text-dark font-weight-bold">Uploaded Evidences</h5>
                                <h6 class="text-center">At least one evidence is required</h6>
                                @php $i = 1;@endphp
                                @foreach($accomplishmentFiles as $file)
                                <div class="form-group row">
                                    <div class=" col text-center">
                                        <div>
                                            <h6>Evidence {{$i}}</h6>
                                        </div>
                                        @if($file->type == 1)
                                        {{-- IMG --}}
                                        <div>
                                            <img src="{{'/storage/'.$file->file}}" style="max-width:200px; max-height:200px;min-width:200px; min-height:200px;">
                                            <p class="text-center">CAPTION: {{$file->caption  ?? 'NONE' }}</p>
                                        </div>
                                        @elseif($file->type == 2)
                                        {{-- PDF --}}
                                        <div>
                                            <iframe src="{{'/storage/'.$file->file}}#toolbar=0" width="100%" style="height:25vh;">
                                            </iframe>
                                            <p class="text-center">CAPTION: {{$file->caption  ?? 'NONE' }}</p>
                                        </div>
                                        @endif
                                        <div>
                                            <label for="{{'evidence' . $i}}" class="@error('evidence'.$i) text-danger @enderror">Include this evidence on final?
                                            </label>
                                            <input type="checkbox" 
                                            class="form-control" 
                                            name="{{'evidence' . $i}}" 
                                            id="{{'evidence' . $i}}" 
                                            @if($i == 1) checked @endif 
                                            onchange="atLeastOneCheckboxIsChecked('evidence{{$i}}')"
                                            >
                                            @error('evidence'.$i)
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                @php $i += 1;@endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-1 w-100">
                            <div class="card-header card-title text-center">Review Remarks</div>
                            <small class="text-center">Include comments for possible improvement for this submission.</small>
                            <div class="card-body">
                                <textarea class="form-control" id="remarks" name="remarks" placeholder="Start Review here..." rows="9" required></textarea>
                            </div>
                        </div>
                        <div class="card card-body text-center">
                            <div class="row mt-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-danger w-100" type="submit" name="decline" id="decline" value="decline">Decline</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-2 justify-content-center">
                                <div class="col">
                                    <button class="btn btn-success w-100" type="submit" name="success" id="success" value="success">Finalize Review</button>
                                </div>
                            </div>
                        </div>
                    </div>
            	</div>
                @csrf
            </form>
        	<hr>
        	<div class="row justify-content-center pt-1">
        		<a href="/s/accomplishments">
        			<button class="btn btn-secondary">Go back</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function atLeastOneCheckboxIsChecked(checkboxId)
        {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
            console.log(checkboxId);
            if(!checkedOne)
            {
                alert ("Atleast one checkbox should be checked");
                document.getElementById(checkboxId).checked = true;
            }
        }
    </script>
@endsection
