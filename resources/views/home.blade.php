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
                    {{ __('You are logged in!') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @position_title('Officer')
            <div class="pb-2">
                <div class="card">
                    <div class="card-header text-center align-middle">
                        <div class="display-5">Welcome Officer</div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <a href="/e/create">
                                <button class="btn btn-primary mr-2">Add Event</button>
                            </a>
                            <a href="/e">
                                <button class="btn btn-primary mr-2">View Events</button>
                            </a>
                            <a href="/e/reports">
                                <button class="btn btn-primary">Year Summary</button>
                            </a>
                        </div>
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
                            <a href="#">
                                <button class="btn btn-primary mr-2">Upload Accomplishment</button>
                            </a>
                            <a href="#">
                                <button class="btn btn-primary">View Accomplishments</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endposition_title
        </div>

    </div>
</div>
@endsection
