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
                    <div class="flex-row text-center" id="success_alert">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h5 class="display-5 text-center">Event Roles</h5>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Maintenances
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Event Roles
                        </li>
                    </ol>
                </nav>
            </div>
            
            <div class="flex-row my-2 text-center">
                <a href="{{ route('admin.maintenance.eventRoles.create') }}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-plus"></i> Add Event Role
                </a>
            </div>
            
            {{-- Event Roles Table --}}
            @if($eventRoles->isNotEmpty())
                <div class="card w-100">
                    <table class="w-100 table table-bordered table-striped table-hover border border-dark">
                        <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                            <th>#</th>
                            <th>Role</th>
                            <th>Helper</th>
                            <th>Color Scheme</th>
                            <th>Option</th>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach($eventRoles as $role)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $role->event_role }}</td>
                                <td style="width: 50%;">{{ $role->helper }}</td>
                                <td class="text-center align-middle">
                                    <span class="badge rounded-pill fs-6"
                                        style="background-color: {{$role->background_color}}; color: {{$role->text_color}};" >
                                        {{ $role->event_role }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-success text-white" 
                                        href="{{ route('admin.maintenance.eventRoles.show', ['role_id' => $role->event_role_id]) }}" 
                                        role="button">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a class="btn btn-primary text-white" 
                                        href="{{ route('admin.maintenance.eventRoles.edit', ['role_id' => $role->event_role_id]) }}" 
                                        role="button">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>    

                            </tr>
                        @php $i += 1; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">No Event Roles found. :(</p>
            @endif

            {{-- Deleted Event Roles Table --}}
            @if($deletedEventRoles->isNotEmpty())
                <hr>

                <div class="card w-100">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Deleted Event Roles</h5>

                    <table class="w-100 my-1 table table-bordered table-striped table-hover border border-dark">
                        <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                            <th>#</th>
                            <th>Role</th>
                            <th>Helper</th>
                            <th>Color Scheme</th>
                            <th>Option</th>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach($deletedEventRoles as $role)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $role->event_role }}</td>
                                <td style="width: 50%;">{{ $role->helper }}</td>
                                <td class="text-center align-middle">
                                    <span class="badge rounded-pill fs-6"
                                        style="background-color: {{$role->background_color}}; color: {{$role->text_color}};" >
                                        {{ $role->event_role }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-primary text-white" 
                                        href="{{ route('admin.maintenance.eventRoles.show', ['role_id' => $role->event_role_id]) }}" 
                                        role="button">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @php $i += 1; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            
            <div class="flex-row my-2 text-center">
                <a href="{{ route('admin.home') }}"
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
    <script type="text/javascript">
        {{-- LOGIN ALERT TIMEOUT --}}
        window.setTimeout(function() {
            $("#login_alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 3000);
    </script>
    
@endsection
