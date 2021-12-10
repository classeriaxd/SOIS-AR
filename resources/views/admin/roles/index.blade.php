@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Roles</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Maintenance
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Roles
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Count Cards --}}
            <div class="row d-flex justify-content-evenly">
                {{-- Member Count Card --}}
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{route('admin.maintenance.roles.roleIndex', ['roleName' => 'members'])}}">
                        <div class="card card-stats">
                            <div class="card-header">
                                <div class="icon icon-warning">
                                    <span class="material-icons">group</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <p class="category"><strong>Members</strong></p>
                                <h3 class="card-title">{{ $memberCount->users_count ?? 0 }}</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <a href="{{route('admin.maintenance.roles.roleIndex', ['roleName' => 'members'])}}">More info
                                        <i class="material-icons more-info">arrow_circle_right</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Documentation Officer Count Card --}}
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{route('admin.maintenance.roles.roleIndex', ['roleName' => 'officers'])}}">
                        <div class="card card-stats">
                            <div class="card-header">
                                <div class="icon icon-success">
                                    <span class="material-icons">menu_book</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <p class="category"><strong>Documentation Officers</strong></p>
                                <h3 class="card-title">{{ $officerCount->users_count ?? 0 }}</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <a href="{{route('admin.maintenance.roles.roleIndex', ['roleName' => 'officers'])}}">More info
                                        <i class="material-icons more-info">arrow_circle_right</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- President Count Card --}}
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{route('admin.maintenance.roles.roleIndex', ['roleName' => 'presidents'])}}">
                        <div class="card card-stats">
                            <div class="card-header">
                                <div class="icon icon-rose">
                                <span class="material-icons">engineering</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <p class="category"><strong>Presidents</strong></p>
                                <h3 class="card-title">{{ $presidentCount->users_count ?? 0 }}</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <a href="{{route('admin.maintenance.roles.roleIndex', ['roleName' => 'presidents'])}}">More info
                                        <i class="material-icons more-info">arrow_circle_right</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <hr>
            <div class="flex-row my-2 text-center">
                <a href="{{route('admin.home')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-home"></i> Go Home
                </a>            
            </div>
        </div>
    </div>
</div>
@endsection