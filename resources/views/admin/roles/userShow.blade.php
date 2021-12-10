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
                    {{-- User Details --}}
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
                    <hr>

                    {{-- User Permissions --}}
                    <div class="row my-1">
                        <h3 class="text-center fw-bold">
                            Permissions 
                            <a role="button"
                                data-bs-toggle="popover"
                                data-bs-container="body"
                                title="Permission Toggle" 
                                data-bs-content="You can click on the buttons to toggle permissions"
                                data-bs-trigger="hover focus"
                                data-bs-placement="right">
                                <i class="far fa-question-circle"></i>
                            </a>
                        </h3>

                        {{-- Assigned Permissions --}}
                        <div class="row">
                            @foreach($user->permissions as $permission)
                                <detach-permission
                                    route="{{route('admin.maintenance.users.detachPermission', ['user_id' => $user->user_id, 'permission_id' => $permission->permission_id])}}"
                                    refresh-route="{{route('admin.maintenance.users.show', ['user_id' => $user->user_id])}}"
                                    permission-name="{{$permission->name}}">
                                </detach-permission>
                                @if((($loop->index+1) % 4 === 0))
                                    <div class="w-100 my-1"></div>
                                @endif
                            @endforeach
                        </div>

                        {{-- Unassigned Permissions --}}
                        <div class="row mt-2 mb-1">
                            @foreach($unassignedPermissions as $permission)
                                <attach-permission
                                    route="{{route('admin.maintenance.users.attachPermission', ['user_id' => $user->user_id, 'permission_id' => $permission->permission_id])}}"
                                    refresh-route="{{route('admin.maintenance.users.show', ['user_id' => $user->user_id])}}"
                                    permission-name="{{$permission->name}}">
                                </attach-permission>
                                @if((($loop->index+1) % 4 === 0))
                                    <div class="w-100 my-1"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <hr>

                    {{-- Options --}}
                    <div class="row my-1">
                        <h3 class="text-center fw-bold">Options</h3>
                        <div class="flex-row text-center">
                            <a href="{{route('admin.maintenance.users.roles.index', ['user_id' => $user->user_id])}}"
                                class="btn btn-primary text-white"
                                role="button">
                                    <i class="fas fa-user-circle"></i> Manage Roles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="flex-row my-2 text-center">
                <a href="{{route('admin.maintenance.roles.index')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-arrow-left"></i> Go back to Roles
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

@section('scripts')
    {{-- Enable Popovers --}}
    <script type="text/javascript" src="{{ asset('js/bootstrap_related_js/enablePopover.js') }}"></script>
@endsection