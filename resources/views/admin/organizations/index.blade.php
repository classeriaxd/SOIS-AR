@extends('layouts.admin-app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">All Organizations</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Organizations
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Academic Organizations --}}
            <div class="row mt-2 mb-3">
                <div class="col d-flex justify-content-evenly">
                    @if($academicOrganizations->count() > 0)
                        @foreach($academicOrganizations as $organization)
                            <a href="{{ route('admin.organizations.show', ['organizationSlug' => $organization->organization_slug]) }}">
                                <div class="card text-center">   
                                    <span class="position-absolute p-2 top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                        {{ $organization->unread_accomplishment_reports_count ?? 0}}
                                        <span class="visually-hidden">unread notifications</span>
                                    </span>
                                    <img class="card-img-top mx-auto" 
                                        @if($organization->logos->count() !== 0)
                                        src="/storage/{{$organization->logos->first()->file}}" style="max-width: 7em; max-height: 7em; min-height: 7em; min-width: 7em;"
                                        @else
                                        src="/storage/organization_assets/logo/default_logo.png" style="max-width: 7em; max-height: 7em; min-height: 7em; min-width: 7em;"
                                        @endif
                                        >
                                    <div class="card-body text-center bg-maroon text-white fw-bold">
                                        <h5 class="text-center">
                                        {{ $organization->organization_acronym }}
                                        </h5>
                                        <h5 class="card-text d-flex align-items-center text-center">
                                            {{ $organization->events_count ?? 0 }} Events
                                        </h5>
                                        <h5 class="card-text d-flex align-items-center text-center">
                                        {{ $organization->accomplishment_reports_count ?? 0 }} AR
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                    <p class="text-center">
                        No Organization Found. :(
                    </p>
                    @endif
                </div>
            </div>

            {{-- Non-Academic Organizations --}}
            <div class="row my-3">
                <div class="col d-flex justify-content-evenly">
                    @if($nonAcademicOrganizations->count() > 0)
                        @foreach($nonAcademicOrganizations as $organization)
                            <a href="{{ route('admin.organizations.show', ['organizationSlug' => $organization->organization_slug]) }}">
                                <div class="card text-center">   
                                    <span class="position-absolute p-2 top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                        {{ $organization->unread_accomplishment_reports_count ?? 0}}
                                        <span class="visually-hidden">unread notifications</span>
                                    </span>
                                    <img class="card-img-top mx-auto" 
                                        @if($organization->logos->count() !== 0)
                                        src="/storage/{{$organization->logos->first()->file}}" style="max-width: 7em; max-height: 7em; min-height: 7em; min-width: 7em;"
                                        @else
                                        src="/storage/organization_assets/logo/default_logo.png" style="max-width: 7em; max-height: 7em; min-height: 7em; min-width: 7em;"
                                        @endif
                                        >
                                    <div class="card-body text-center bg-maroon text-white fw-bold">
                                        <h5 class="text-center">
                                        {{ $organization->organization_acronym }}
                                        </h5>
                                        <h5 class="card-text d-flex align-items-center text-center">
                                            {{ $organization->events_count ?? 0 }} Events
                                        </h5>
                                        <h5 class="card-text d-flex align-items-center text-center">
                                            {{ $organization->accomplishment_reports_count ?? 0 }} AR
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                    <p class="text-center">
                        No Organization Found. :(
                    </p>
                    @endif
                </div>
            </div>
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
@endsection
