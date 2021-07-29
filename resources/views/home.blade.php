@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
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
            <div>
                <div class="text-center">
                    <a href="/pdf">
                        <button class="btn-primary btn">PDF</button>
                    </a>
                </div>
            </div>
            <div class="pb-2">
                <div class="card">
                    <div class="card-header text-center align-middle">
                        <div class="display-5">General Options</div>
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
            <div class="pb-2">
                <div class="card">
                    <div class="card-header text-center align-middle">
                        <div class="display-5">Event Quick View</div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center pb-2">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header text-center align-middle">
                                        <div class="display-6">January</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column">
                                            <button class="btn btn-primary m-1">Sample</button>
                                            <button class="btn btn-primary m-1">Sample</button>
                                            <button class="btn btn-primary m-1">Sample</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header text-center align-middle">
                                        <div class="display-6">February</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column">
                                            <button class="btn btn-primary m-1">Sample</button>
                                            <button class="btn btn-primary m-1">Sample</button>
                                            <button class="btn btn-primary m-1">Sample</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header text-center align-middle">
                                        <div class="display-6">March</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column">
                                            <button class="btn btn-primary m-1">Sample</button>
                                            <button class="btn btn-primary m-1">Sample</button>
                                            <button class="btn btn-primary m-1">Sample</button>
                                        </div>
                                    </div>
                                </div>
                            </div>               
                        </div>
                        <div class="row justify-content-center pb-2">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header text-center align-middle">
                                        <div class="display-6">January</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column">
                                            <button class="btn btn-primary m-1">Sample</button>
                                            <button class="btn btn-primary m-1">Sample</button>
                                            <button class="btn btn-primary m-1">Sample</button>
                                        </div>
                                    </div>
                                </div>
                            </div>              
                        </div>
                    </div>
                </div>
            </div>
            
            
            
        </div>

    </div>
</div>
@endsection
