@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                @position_title('Member')
                <h4 class="display-5 text-center">My Accomplishments</h4>
                @elseposition_title('Officer')
                <h4 class="display-5 text-center">Accomplishment Submissions</h4>
                @endposition_title
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Student Accomplishments
                        </li>
                    </ol>
                </nav>
            </div>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-8">
                    @position_title('Member')
                    <div class="mb-2 text-center">
                        <a href="{{route('studentAccomplishment.create')}}"
                        class="btn btn-primary text-white"
                        role="button">
                            Submit an Accomplishment
                        </a>
                    </div>
                    <div class="card mb-1">
                        <h5 class="card-header card-title text-center bg-primary text-white">My Accomplishments</h5>
                        <div class="card-body">
                            @if($approvedAccomplishments->count()>0)
                            @foreach($approvedAccomplishments as $accomplishment)
                            <a href="/s/accomplishment/{{$accomplishment->accomplishment_uuid}}">
                                <div class="row justify-content-center text-white bg-success rounded border border-dark mb-1">
                                    <p class="font-weight-bold my-auto">{{$accomplishment->title}}</p>
                                </div>
                            </a>
                            @endforeach
                            @else
                            <p class="text-center">No accomplishment found.</p>
                            @endif
                        </div>
                    </div>
                    <div class="card mb-1">
                        <h5 class="card-header card-title text-center bg-primary text-white">Pending Accomplishments</h5>
                        <div class="card-body">
                            @if($pendingAccomplishments->count()>0)
                            @foreach($pendingAccomplishments as $accomplishment)
                            <a href="/s/accomplishment/{{$accomplishment->accomplishment_uuid}}">
                                <div class="row justify-content-center text-dark bg-warning rounded border border-dark mb-1">
                                    <p class="font-weight-bold my-auto">{{$accomplishment->title}}</p>
                                </div>
                            </a>
                            @endforeach
                            @else
                            <p class="text-center">No accomplishment found.</p>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header card-title text-center bg-primary text-white">Disapproved Accomplishments</h5>
                        <div class="card-body">
                            @if($disapprovedAccomplishments->count()>0)
                            @foreach($disapprovedAccomplishments as $accomplishment)
                            <a href="/s/accomplishment/{{$accomplishment->accomplishment_uuid}}">
                                <div class="row justify-content-center text-white bg-danger rounded border border-dark mb-1">
                                    <p class="font-weight-bold my-auto">{{$accomplishment->title}}</p>
                                </div>
                            </a>
                            @endforeach
                            @else
                            <p class="text-center">No accomplishment found.</p>
                            @endif
                        </div>
                    </div>
                    <hr>
                    @elseposition_title('Officer')
                    <div class="card mb-1">
                        <h5 class="card-header card-title text-center bg-primary text-white">Student Accomplishment Submissions</h5>
                        <div class="card-body">
                            @if($accomplishmentSubmissions->count()>0)
                            @foreach($accomplishmentSubmissions as $accomplishment)
                            <a href="/s/accomplishment/{{$accomplishment->accomplishment_uuid}}/review">
                                <div class="row justify-content-center text-white bg-info rounded border border-dark mb-1">
                                    <p class="font-weight-bold my-auto">{{$accomplishment->student_name . ' - ' . $accomplishment->title}}</p>
                                </div>
                            </a>
                            @endforeach
                            <div class="row justify-content-center">
                                {{ $accomplishmentSubmissions->links() }}
                            </div>
                            @else
                            <p class="text-center">No submissions found!</p>
                            @endif
                        </div>
                    </div>
                    <hr>
                    @endposition_title
        		</div>
        	</div>
        	<hr>
        	<div class="row justify-content-center pt-1">
        		<a href="/home">
        			<button class="btn btn-secondary">Go back</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection
