@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!--<div id="login_alert">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    @if (session('status'))
                        {{ session('status') }}
                    @endif
                    {{ __('You are logged in! :)') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>-->
        @position_title('Officer')

        <div class="row">
          <div class="col-md-12">
            <h4>Dashboard</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white h-100">
              <div class="card-body py-5">Primary Card</div>
              <div class="card-footer d-flex">
                View Details
                <span class="ms-auto">
                    <i class="fas fa-home"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark h-100">
              <div class="card-body py-5">Warning Card</div>
              <div class="card-footer d-flex">
                View Details
                <span class="ms-auto">
                    <i class="fas fa-home"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-success text-white h-100">
              <div class="card-body py-5">Success Card</div>
              <div class="card-footer d-flex">
                View Details
                <span class="ms-auto">
                    <i class="fas fa-home"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white h-100">
              <div class="card-body py-5">Danger Card</div>
              <div class="card-footer d-flex">
                View Details
                <span class="ms-auto">
                    <i class="fas fa-home"></i>
                </span>
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
                    <div class="row justify-content-center">
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
