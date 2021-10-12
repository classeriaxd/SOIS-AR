@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        {{-- Login Alert --}}
            @if ($loginAlert != NULL)
                <div id="login_alert" style="position:fixed; top:0; right:0; width:20%;">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $loginAlert }}
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        @position_title('Officer')
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h4 class="display-5 text-center">Welcome Officer!</h4>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item active" aria-current="page">
                            Home
                        </li>
                    </ol>
                </nav>
            </div>
            
            <div class="card my-2 border border-dark">
                <h4 class="card-header card-text text-center align-middle bg-maroon text-white fw-bold">
                    Events
                </h4>
                <div class="card-body">
                    <div class="flex-row d-flex justify-content-center">
                        <a href="{{route('event.create')}}" 
                        class="btn btn-primary m-1 text-white" 
                        role="button">
                            Add Event
                        </a>
                        <a href="{{route('event.index')}}" 
                        class="btn btn-primary m-1 text-white" 
                        role="button">
                            View Events
                        </a>
                        
                    </div>
                </div>
            </div>

            <div class="card my-2 border border-dark">
                <h4 class="card-header card-text text-center align-middle bg-maroon text-white fw-bold">
                    Accomplishment Reports
                </h4>
                <div class="card-body">
                    <div class="flex-row d-flex justify-content-center">
                        <a href="{{route('accomplishmentreports.create')}}" 
                        class="btn btn-primary m-1 text-white" 
                        role="button">
                            Create Accomplishment Report
                        </a>
                        <a href="{{route('accomplishmentreports.index')}}" 
                        class="btn btn-primary m-1 text-white"
                        role="button">
                            Report Submissions
                            <span class="badge rounded-pill bg-warning text-dark">
                                {{$pendingARSubmissionCount ?? "0"}}
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card my-2 border border-dark">
                <h4 class="card-header card-text text-center align-middle bg-maroon text-white fw-bold">
                    Student Accomplishments
                </h4>
                <div class="card-body">
                    <div class="flex-row d-flex justify-content-center">
                        <a href="{{route('studentAccomplishment.index')}}"
                        class="btn btn-primary text-white"
                        role="button">
                            Accomplishment Submissions
                            <span class="badge rounded-pill bg-light text-dark">
                                {{$submissionCount ?? "0"}}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        @elseposition_title('Member')
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h4 class="display-5 text-center">Welcome Member!</h4>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item active" aria-current="page">
                            Home
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="pb-2">
                <div class="card my-2 border border-dark">
                    <h4 class="card-header card-text text-center align-middle bg-maroon text-white fw-bold">
                        Accomplishments
                    </h4>
                    <div class="card-body">
                        <div class="flex-row d-flex justify-content-center">
                            <a href="{{route('studentAccomplishment.index')}}" class="btn btn-primary text-white" role="button">
                                My Accomplishments 
                                <span class="badge rounded-pill bg-success text-white">{{$approvedAccomplishmentCount ?? "0"}}</span> 
                                <span class="badge rounded-pill bg-warning text-dark">{{$pendingAccomplishmentCount ?? "0"}}</span> 
                                <span class="badge rounded-pill bg-danger text-white">{{$disapprovedAccomplishmentCount ?? "0"}}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseposition_title('President')
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h4 class="display-5 text-center">Welcome President!</h4>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item active" aria-current="page">
                            Home
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="card my-2 border border-dark">
                <h4 class="card-header card-text text-center align-middle bg-maroon text-white fw-bold">
                    Accomplishment Reports
                </h4>
                <div class="card-body">
                    <div class="flex-row d-flex justify-content-center">
                        <a href="{{route('accomplishmentreports.index')}}"
                        class="btn btn-primary m-1 text-white"
                        role="button">
                            View Pending Accomplishment Reports 
                            <span class="badge rounded-pill bg-warning text-dark">
                                {{ $pendingARSubmissionCount ?? "0" }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        @endposition_title
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        {{-- LOGIN ALERT TIMEOUT --}}
        window.setTimeout(function() {
            $("#login_alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 3000);
    </script>
@endsection
    {{-- <div class="card my-1">
        <div class="card-header text-center align-middle">
            <div class="display-5">Organization Documents</div>
        </div>
        <div class="card-body">
            <div class="row justify-content-center mb-2">
                <a href="/o/documents/create">
                    <button class="btn btn-primary mr-2" disabled>Add Organization Documents</button>
                </a>
                <a href="o/documents">
                    <button class="btn btn-primary mr-2" disabled>View Organization Documents</button>
                </a>
            </div>
        </div>
    </div> --}}