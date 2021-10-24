@extends('layouts.app')

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
                        <a href="#"
                        role="button"
                        class="btn btn-primary text-white">
                            Event Document Types
                        </a>
                    </div>
                    <div class="flex-row text-center my-1">
                        <a href="#"
                        role="button"
                        class="btn btn-primary text-white">
                            Levels
                        </a>
                        <a href="#"
                        role="button"
                        class="btn btn-primary text-white">
                            School Years
                        </a>
                        <a href="#"
                        role="button"
                        class="btn btn-primary text-white">
                            Organization Document Types
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
