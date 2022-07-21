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
                <h2 class="display-7 text-left text-break">System Housekeeping</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            System Maintenance
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Housekeeping
                        </li>
                    </ol>
                </nav>
            </div>


            {{-- Backups Table --}}
            <div class="row my-2">
                @if($arBackups->isNotEmpty())

                <table class="table table-striped table-hover table-bordered border border-dark" id="arBackupTable">
                    <thead class="text-white fw-bold bg-maroon">
                        <th class="text-center" scope="col">#</th>
                        <th class="text-center" scope="col">School Year</th>
                        <th class="text-center" scope="col">Timestamps</th>
                        <th class="text-center" scope="col">Options</th>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($arBackups as $backup)
                        <tr>
                            <td scope="row" class="text-center">{{ $i }}</td>
                            <td class="text-center">{{ $backup->start_year . ' - ' . $backup->end_year }}</td>
                            <td class="text-break">Created at: {{ $backup->created_at }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.maintenance.system.housekeeping.downloadBackup', ['arBackupID' => $backup->ar_backup_id,]) }}" enctype="multipart/form-data"
                                    onsubmit="document.getElementById('downloadBackup').disabled=true;"
                                    method="POST">
                                    <button id="downloadBackup" type="submit" class="btn btn-primary text-white w-100">
                                        <i class="fas fa-download"></i> Download Backup
                                    </button>
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @php $i += 1; @endphp
                        @endforeach
                    </tbody>
                </table>

                @else
                <p class="text-center">
                    No Backups Found. :(
                </p>
                @endif
            </div>

            <hr>

            <div class="row my-2">
                {{-- School Year Select --}}
                <h3 class="text-center">Create Backup</h3>
                <p class="text-danger text-center fw-bold">This erases the Events and Student Accomplishments from the storage and only compiles the Accomplishment Reports for archiving.</p>
                <form action="{{route('admin.maintenance.system.housekeeping.create')}}" enctype="multipart/form-data" method="POST" id="createBackupForm"
                    onsubmit="document.getElementById('submitButton').disabled=true;
                    document.getElementById('submitButtonText').hidden=true;
                    document.getElementById('submitSpinner').hidden=false;
                    document.getElementById('submitMessage').hidden=false;">
                    <div class="d-flex flex-column align-items-center">
                        @if( $schoolYears->count() > 0)
                        <select class="form-select w-50" name="school_year">
                            @php $i = 1; @endphp
                            @foreach($schoolYears as $year)
                                <option @if ($loop->last) selected @endif
                                    value="{{ $year->school_year_id }}">
                                {{ $year->year_start . ' - ' . $year->year_end}}
                                </option>	
                            @endforeach
                        </select>
                        <button id="submitButton" class="btn btn-danger text-center text-white w-25" type="submit">
                            <span id="submitButtonText">Backup</span>
                            <span id="submitSpinner" hidden>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" ></span>
                                Please wait, this might take a while...
                            </span>
                        </button>
                        <p class="text-center" id="submitMessage" hidden>
                            Please wait while your backup is being generated. You will be automatically redirected after it is done.
                        </p>
                        @else
                            <p class="bg-danger">NO OPTION AVAILABLE</p>
                        @endif
                    </div>
                    @csrf
                </form>
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
