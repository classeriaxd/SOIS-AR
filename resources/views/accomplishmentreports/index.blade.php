@extends('layouts.app')

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
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Accomplishment Reports</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Accomplishment Reports
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Accomplishment Reports Page --}}
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-12">

                    {{-- If User has AR Officer role... --}}
                    @role('AR Officer Admin')
                        <div class="card w-100 my-3">
                            <h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Organization Accomplishment Reports</h4>
                            <div class="card-body">

                                {{-- Organization Accomplishment Reports Table --}}
                                @if($organizationAccomplishmentReports->total() > 0)
                                    <table class="w-100 table table-bordered table-striped table-hover border border-dark" id="organizationAccomplishmentTable">
                                        <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Title</th>
                                            <th>Inclusive Date</th>
                                            <th>Status</th>
                                            <th>Option</th>
                                        </thead>
                                        <tbody>
                                            @php $i = 1; @endphp
                                            @foreach($organizationAccomplishmentReports as $organizationAccomplishmentReport)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $organizationAccomplishmentReport->accomplishmentReportType->accomplishment_report_type }}</td>
                                                    <td>
                                                        {{ $organizationAccomplishmentReport->title }}
                                                    </td>
                                                    <td>
                                                        {{ 
                                                            date_format(date_create($organizationAccomplishmentReport->start_date), 'F d, Y') . ' - ' . 
                                                            date_format(date_create($organizationAccomplishmentReport->end_date), 'F d, Y') 
                                                        }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if($organizationAccomplishmentReport->status == 1)
                                                            <span class="badge rounded-pill fs-6 bg-warning text-dark">Pending</span>
                                                        @elseif($organizationAccomplishmentReport->status == 2)
                                                            <span class="badge rounded-pill fs-6 bg-success text-white">Approved</span>
                                                        @elseif($organizationAccomplishmentReport->status == 3)
                                                            <span class="badge rounded-pill fs-6 bg-danger text-white">Disapproved</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="btn btn-success text-white" 
                                                            href="{{route('accomplishmentReport.show', ['accomplishmentReportUUID' => $organizationAccomplishmentReport->accomplishment_report_uuid])}}" 
                                                            role="button">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @php $i += 1; @endphp
                                            @endforeach
                                        
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-center">No Accomplishment Reports found :(. You can create one <a href="{{route('accomplishmentReports.create')}}"><u>here</u></a>.</p>
                                @endif

                                {{-- Organization Accomplishment Reports Table Pager --}}
                                @if($organizationAccomplishmentReports->total() > 0)
                                    <div class="d-flex justify-content-center">
                                        {{ $organizationAccomplishmentReports->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endrole

                    {{-- If User has AR President role... --}}
                    @role('AR President Admin')
                        <div class="card w-100 my-3">
                            <h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Pending Accomplishment Reports</h4>
                            <div class="card-body">

                                {{-- Pending Accomplishment Reports Table --}}
                                @if($pendingAccomplishmentReports->total() > 0)
                                    <table class="w-100 table table-bordered table-striped table-hover border border-dark" id="organizationAccomplishmentTable">
                                        <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Title</th>
                                            <th>Inclusive Date</th>
                                            <th>Status</th>
                                            <th>Option</th>
                                        </thead>
                                        <tbody>
                                            @php $i = 1; @endphp
                                            @foreach($pendingAccomplishmentReports as $pendingAccomplishmentReport)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $pendingAccomplishmentReport->accomplishmentReportType->accomplishment_report_type }}</td>
                                                    <td>
                                                        {{ $pendingAccomplishmentReport->title }}
                                                    </td>
                                                    <td>
                                                        {{ 
                                                            date_format(date_create($pendingAccomplishmentReport->start_date), 'F d, Y') . ' - ' . 
                                                            date_format(date_create($pendingAccomplishmentReport->end_date), 'F d, Y') 
                                                        }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if($pendingAccomplishmentReport->status == 1)
                                                            <span class="badge rounded-pill fs-6 bg-warning text-dark">Pending</span>
                                                        @elseif($pendingAccomplishmentReport->status == 2)
                                                            <span class="badge rounded-pill fs-6 bg-success text-white">Approved</span>
                                                        @elseif($pendingAccomplishmentReport->status == 3)
                                                            <span class="badge rounded-pill fs-6 bg-danger text-white">Disapproved</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="btn btn-success text-white" 
                                                            href="{{route('accomplishmentReport.show', ['accomplishmentReportUUID' => $pendingAccomplishmentReport->accomplishment_report_uuid])}}" 
                                                            role="button">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @php $i += 1; @endphp
                                            @endforeach
                                        
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-center">No Accomplishment Report Submissions found!</p>
                                @endif

                                {{-- Organization Accomplishments Table Pager --}}
                                @if($pendingAccomplishmentReports->total() > 0)
                                    <div class="d-flex justify-content-center">
                                        {{ $pendingAccomplishmentReports->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endrole

        		</div>
        	</div>

        	<hr>

            <div class="flex-row my-2 text-center">
                <a href="{{route('home')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-home"></i> Home
                </a>
                @role('AR President Admin')
                    <span>or</span>

                    <a href="{{route('home')}}"
                        class="btn btn-primary text-white"
                        role="button">
                            <i class="fas fa-clipboard-list"></i> Create Accomplishment Report
                    </a>
                @endrole
                
            </div>
            
        </div>
    </div>
</div>
@endsection
