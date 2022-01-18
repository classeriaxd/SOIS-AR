@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h2 class="display-2 text-center">Current {{$organization->organization_acronym}} Officer Signatures</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{$organization->organization_acronym}}
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Officer Signatures
                        </li>
                    </ol>
                </nav>
            </div>

            @if($positionTitles->isNotEmpty())
                <div class="card w-100 my-2">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Officer Signatures</h5>

                    <table class="table table-striped table-hover table-bordered border border-dark" id="officerSignatureTable">
                        <thead class="text-white fw-bold bg-maroon">
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Position Title</th>
                            <th class="text-center" scope="col">Officer</th>
                            <th class="text-center" scope="col">Signature</th>
                            <th class="text-center" scope="col" data-sortable="false">Options</th>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($positionTitles as $positionTitle)
                            <tr>
                                <td scope="row" class="text-center">{{ $i }}</td>
                                <td>{{ $positionTitle->position_title }}</td>
                                <td>{{ $positionTitle->officers->first()->full_name }}</td>
                                <td class="align-middle">
                                    @if($positionTitle->officers->first()->signature != NULL)
                                        <div class="d-flex justify-content-center">
                                            <img src="/storage/{{$positionTitle->officers->first()->signature}}" style="max-width: 10em; max-height: 5em; min-height: 5em; min-width: 10em;">
                                        </div>
                                    @else
                                        <span class="text-center">No Signature Uploaded</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{route('maintenances.officerSignatures.create', ['officerID' => $positionTitle->officers->first()->officer_id, 'organizationSlug' => $organization->organization_slug])}}" 
                                        class="btn btn-primary text-white" 
                                        role="button">
                                            <i class="fas fa-edit"></i> Update Signature
                                    </a>
                                </td>
                            </tr>
                            @php $i += 1; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>    
            @else
                <p class="text-center text-danger fw-bold">
                    This Organization has no Position Titles.
                </p>
            @endif
        </div>
    </div>

    <hr>
    
    <div class="flex-row my-2 text-center">
        <a href="{{route('home')}}"
        class="btn btn-secondary text-white"
        role="button">
            <i class="fas fa-home"></i> Go Home
        </a>
    </div>

</div>
@endsection