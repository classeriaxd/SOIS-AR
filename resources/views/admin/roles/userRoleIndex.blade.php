@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Success Alert --}}
                @if (session()->has('success'))
                    <div class="flex-row text-center" id="success_alert">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            {{-- Error Alert --}}
                @if (session()->has('error'))
                    <div class="flex-row text-center" id="error_alert">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Attach/Detach Roles</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Maintenance
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.maintenance.roles.index')}}" class="text-decoration-none">Roles</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{$user->full_name}}
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- User Card --}}
            <div class="card w-100">
                <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">User</h5>
                <div class="card-body">

                    {{-- User --}}
                    <div class="row text-center my-1">
                        <h3 class="fw-bold">{{ $user->full_name }}</h3>
                        <p class="text-center">{{ $user->student_number }}</p>
                    </div>
                    <hr>

                    {{-- User Roles --}}
                    <div class="row text-center my-1">
                        <h3 class="fw-bold">Roles</h3>
                        <div class="d-flex justify-content-evenly">
                            @foreach($user->rolesWithOrganization as $role)
                                <div class="col">
                                    <h4><span class="badge bg-primary text-white rounded-pill">{{ $role->organization_acronym . ' ' .$role->role }}</span></h4>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    {{-- Attachable Roles with Organization --}}
                    @if($allowAttachRole)
                        <hr>
                        <div class="row text-center my-1">
                            <h3 class="fw-bold">Attach a Role with Organization</h3>
                            <form action="{{route('admin.maintenance.users.roles.attach', ['user_id' => $user->user_id])}}" method="POST"
                                onsubmit="document.getElementById('attachButton').disabled=true;">

                                {{-- Role Select --}}
                                <div class="form-group flex-row my-1">
                                    <select class="form-select text-center fw-bold" name="role" id="role" aria-label="roleSelect" required>
                                        <option selected disabled value="">Select a role to attach...</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->role_id}}">{{$role->role}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Organization Select --}}
                                <div class="form-group flex-row my-1">
                                    <select class="form-select text-center fw-bold" name="organization" id="organization" aria-label="organizationSelect" required>
                                        <option selected disabled value="">Select an organization...</option>
                                        @foreach($organizations as $organization)
                                            <option value="{{$organization->organization_id}}">{{$organization->organization_acronym . ' - ' . $organization->organization_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @csrf
                                <button id="attachButton" class="btn btn-primary text-white" type="submit">Attach Role</button>

                                {{-- Error Messages --}}
                                @error('role')
                                    <div class="row">
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    </div>
                                @enderror
                                @error('organization')
                                    <div class="row">
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    </div>
                                @enderror
                            </form>
                        </div>
                    @endif
                    
                    {{-- Detachable Roles --}}
                    @if(! $allowAttachRole)
                        <hr>
                        <div class="row text-center my-1">
                            <h3 class="fw-bold">Detach Role</h3>
                            <form action="{{route('admin.maintenance.users.roles.detach', ['user_id' => $user->user_id])}}" method="POST"
                                onsubmit="document.getElementById('detachButton').disabled=true;">

                                {{-- Role Select --}}
                                <div class="form-group flex-row my-1">
                                    <select class="form-select text-center fw-bold" name="role" id="role" aria-label="roleSelect" required>
                                        <option selected disabled value="">Select a role to detach...</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->role_id}}">{{$role->organization_acronym . ' ' . $role->role}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @csrf
                                <button id="detachButton" class="btn btn-danger text-white" type="submit">Detach Role</button>
                                @error('role')
                                    <div class="row">
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    </div>
                                @enderror
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex-row my-2 text-center">
                <a href="{{ route('admin.maintenance.users.show', ['user_id' => $user->user_id]) }}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-arrow-left"></i> Go back to User
                </a>
                
                <span>or</span>
                
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