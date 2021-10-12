@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="login_alert">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    @if (session('status'))
                        {{ session('status') }}
                    @endif
                    {{ __('You are logged in! :)') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @position_title('Officer')
            <div class="card my-1">
                <div class="card-header text-center align-middle">
                    <div class="display-5">Welcome Officer</div>
                </div>
                <div class="card-body">
                    <div class="justify-content-around d-flex flex-row">
                        <a href="{{route('event.create')}}">
                            <button class="btn btn-primary mr-2">Add Event</button>
                        </a>
                        <a href="{{route('event.index')}}">
                            <button class="btn btn-primary mr-2">View Events</button>
                        </a>
                        <a href="{{route('accomplishmentreports.create')}}">
                            <button class="btn btn-primary">Year Summary</button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card my-1">
                <div class="card-header text-center align-middle">
                    <div class="display-5">Accomplishment Reports</div>
                </div>
                <div class="card-body">
                    <div class="justify-content-center d-flex flex-row">
                        <a href="{{route('accomplishmentreports.index')}}">
                            <button class="btn btn-primary">Report Submissions<span class="badge badge-pill badge-warning">{{$pendingARSubmissionCount ?? "0"}}</span></button>
                        </a>
                    </div>
                </div>
            </div>

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

            <div class="card my-1">
                <div class="card-header text-center align-middle">
                    <div class="display-5">Student Accomplishments</div>
                </div>
                <div class="card-body">
                    <div class="justify-content-center d-flex flex-row">
                        <a href="/s/accomplishments">
                            <button class="btn btn-primary">Accomplishment Submissions<span class="badge badge-pill badge-light">{{$submissionCount ?? "0"}}</span></button>
                        </a>
                    </div>
                </div>
            </div>
        @elseposition_title('Member')
            <div class="pb-2">
                <div class="card">
                    <div class="card-header text-center align-middle">
                        <div class="display-5">Welcome Member</div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <a href="/s/accomplishments">
                                <button class="btn btn-primary">My Accomplishments <span class="badge badge-pill badge-success">{{$approvedAccomplishmentCount ?? "0"}}</span> <span class="badge badge-pill badge-warning">{{$pendingAccomplishmentCount ?? "0"}}</span> <span class="badge badge-pill badge-danger">{{$disapprovedAccomplishmentCount ?? "0"}}</span></button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseposition_title('President')
            <div class="card mb-2">
                <div class="card-header text-center align-middle">
                    <div class="display-5">Welcome President</div>
                </div>
                <div class="card-body">
                    <div class="justify-content-around d-flex">
                        <a href="{{route('accomplishmentreports.index')}}">
                            <button class="btn btn-primary mr-2">View Pending Accomplishment Reports <span class="badge badge-pill badge-warning">{{ $pendingARSubmissionCount ?? "0" }}</span></button>
                        </a>
                        <a href="#">
                            <button class="btn btn-primary mr-2">View Accomplishment Report Archive</button>
                        </a>
                    </div>
                </div>
            </div>
        @endposition_title
        </div>
    </div>
</div>
@endsection
