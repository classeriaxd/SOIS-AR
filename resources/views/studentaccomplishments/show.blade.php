@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
    		<h2 class="display-2 text-center">Accomplishment</h2>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-8">
                    <div class="card">
                        <h5 class="card-header card-title text-center">{{ $accomplishment->title }}</h5>
                        <div class="card-body">
                        @if($accomplishment->status == 0)
                            <h6 class="text-center text-dark font-weight-bold"><span class="bg-warning rounded">Status: PENDING</span></h6>
                            <p class="text-center">{{ $accomplishment->description }}</p>
                            <p class="text-center">{{ date_format(date_create($accomplishment->date_awarded), 'F d, Y') }}</p>
                            <hr>
                            <h6 class="text-center text-dark font-weight-bold">Uploaded Evidences</h6>
                            
                        @elseif ($accomplishment->status == 1)
                            <h6 class="text-center text-white font-weight-bold"><span class="bg-success rounded">Status: APPROVED</span></h6>
                            <p class="text-center">{{ $accomplishment->description }}</p>
                            <hr>
                            <h6 class="text-center text-dark font-weight-bold">Evidences</h6>

                        @else
                            <h6 class="text-center text-white font-weight-bold"><span class="bg-danger rounded">Status: DISAPPROVED</span></h6>
                            <p class="text-center">{{ $accomplishment->description }}</p>
                            <hr>
                            <p class="text-center">REMARKS</p>
                            <p class="text-center">{{$accomplishment->remarks}}</p>
                            <hr>
                            <h6 class="text-center text-dark font-weight-bold">Uploaded Evidences</h6>
                            
                        @endif

                        @foreach($accomplishmentFiles as $file)
                            @if($file->type == 1)
                            {{-- IMG --}}
                            <div class="row justify-content-center mb-2">
                                <img src="{{'/storage/'.$file->file}}" style="max-width:600px; max-height:300px;min-width:600px; min-height:300px;">
                                <br>
                            </div>
                            @elseif($file->type == 2)
                            {{-- PDF --}}
                            <div class="row justify-content-center mb-2">
                                <iframe src="{{'/storage/'.$file->file}}#toolbar=0" width="100%" style="height:25vh;">
                                </iframe>
                                <br>
                            </div>
                            @endif
                            <div class="row justify-content-center">
                                <p class="text-center">{{$file->caption}}</p>
                            </div>
                        @endforeach
                        </div>
                    </div>
        		</div>
        	</div>
            @isset($newAccomplishment)
            @if($newAccomplishment)
            <hr>
            <div class="row justify-content-center pt-1">
                <a href="/s/accomplishments/create">
                    <button class="btn btn-primary">Submit Another</button>
                </a>
            </div>
            @endif
            @endisset
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
