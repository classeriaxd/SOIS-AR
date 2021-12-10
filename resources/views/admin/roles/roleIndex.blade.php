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
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.maintenance.roles.index')}}" class="text-decoration-none">Roles</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $breadcrumbRole }}
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Users Table --}}
            <div class="card w-100">
                <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">{{ $breadcrumbRole }}</h5>
                <h5 class="text-center my-1 fw-bold">{{$role->description}}</h5>

                <table class="w-100 my-1 table table-bordered table-striped table-hover border border-dark" id="userTable">
                    <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                        <th>#</th>
                        <th>User</th>
                        <th>Organization</th>
                        <th>Student Number</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach($role->usersWithOrganization as $user)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$user->full_name}}</td>
                            <td>{{$user->organization_acronym}}</td>
                            <td>{{$user->student_number}}</td>
                            <td class="text-center">
                                <a class="btn btn-success text-white" 
                                    href="{{ route('admin.maintenance.users.show', ['user_id' => $user->user_id]) }}" 
                                    role="button">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @php $i += 1; @endphp
                    @endforeach
                    </tbody>
                </table>
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

@push('scripts')
    {{-- Import Datatables --}}
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
@endpush

@section('scripts')
    <script type="module">
        // Simple-DataTables
        // https://github.com/fiduswriter/Simple-DataTables
        window.addEventListener('DOMContentLoaded', event => {
            const dataTable = new simpleDatatables.DataTable("#userTable", {
                searchable: true,
                labels: {
                    placeholder: "Search Users...",
                    noRows: "No user to display in this page or try in the next page.",
                },
            });
        });
    </script>
@endsection