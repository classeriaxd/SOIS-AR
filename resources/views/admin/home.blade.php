@extends('layouts.admin-app')

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
        {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h5 class="display-5 text-center">Welcome, Admin!</h5>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item active" aria-current="page">
                            Home
                        </li>
                    </ol>
                </nav>
            </div>
        <div class="row">
            <a href="{{ route('admin.events.index') }}">
                <p class="text-primary border border-dark">Accomplished Event Count: {{ $eventCount ?? 0 }}</p>
            </a>
            <a href="{{ route('admin.organizations.index') }}">
                <p class="text-primary border border-dark">Organization Count: {{ $organizationCount ?? 0 }}</p>
            </a>
            <a href="{{ route('admin.accomplishmentReports.index') }}">
                <p class="text-primary border border-dark">AR Count: {{ $accomplishmentReportCount ?? 0 }}</p>
            </a>
        </div>
        <div class="card w-100">
            <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Maintenance</h5>
            <div class="card-body">
                <div class="flex-row text-center my-1">
                    <a href="{{ route('admin.maintenance.eventCategories.index') }}"
                    role="button"
                    class="btn btn-primary text-white">
                        Event Categories
                    </a>
                    <a href="{{ route('admin.maintenance.eventRoles.index') }}"
                    role="button"
                    class="btn btn-primary text-white">
                        Event Roles
                    </a>
                    <a href="{{ route('admin.maintenance.eventNatures.index') }}"
                    role="button"
                    class="btn btn-primary text-white">
                        Event Natures
                    </a>
                    <a href="{{ route('admin.maintenance.eventClassifications.index') }}"
                    role="button"
                    class="btn btn-primary text-white">
                        Event Classifications
                    </a>
                    <a href="{{ route('admin.maintenance.eventDocumentTypes.index') }}"
                    role="button"
                    class="btn btn-primary text-white">
                        Event Document Types
                    </a>
                </div>
                <div class="flex-row text-center my-1">
                    <a href="{{ route('admin.maintenance.levels.index') }}"
                    role="button"
                    class="btn btn-primary text-white">
                        Levels
                    </a>
                    <a href="{{ route('admin.maintenance.fundSources.index') }}"
                    role="button"
                    class="btn btn-primary text-white">
                        Fund Sources
                    </a>
                    <a href="#"
                    role="button"
                    class="btn btn-primary text-white disabled">
                        School Years
                    </a>
                    <a href="#"
                    role="button"
                    class="btn btn-primary text-white disabled">
                        Organization Document Types
                    </a>
                </div>
                <div class="flex-row text-center my-1">
                    <a href="{{ route('admin.maintenance.tabularTables.index') }}"
                    role="button"
                    class="btn btn-primary text-white">
                        Tabular AR Tables
                    </a>
                </div>
                <div class="flex-row text-center my-1">
                    <a href="{{ route('admin.maintenance.roles.index') }}"
                    role="button"
                    class="btn btn-primary text-white">
                        Roles
                    </a>
                </div>
                
            </div>
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
