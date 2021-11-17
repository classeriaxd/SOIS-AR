@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
            {{-- Title and Breadcrumbs --}}
            <div class="d-flex justify-content-between align-items-center">
                {{-- Title --}}
                <h2 class="display-7 text-left text-break">Student Accomplishments</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb align-items-center">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Student Accomplishments
                        </li>
                    </ol>
                </nav>
            </div>

            {{-- Student Accomplishment Page --}}
        	<div class="row justify-content-center pb-1">
        		<div class="col">

                    {{-- If User has User role... --}}
                    @role('User')

                        {{-- My Accomplishments Table --}}
                        <div class="card w-100 mb-3">
                            <h4 class="card-header card-title text-center bg-maroon text-white fw-bold">My Accomplishments</h4>
                            <div class="card-body">

                                <div class="mb-2 text-center">
                                    <a href="{{route('studentAccomplishment.create')}}"
                                    class="btn btn-primary text-white"
                                    role="button">
                                        <i class="fas fa-award"></i> Submit an Accomplishment
                                    </a>
                                </div>

                                <table class="w-100 table table-bordered table-striped table-hover border border-dark" id="myAccomplishmentTable">
                                    <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Date and Time</th>
                                        <th>Option</th>
                                    </thead>
                                    <tbody>
                                    @if($studentAccomplishments->total() > 0)

                                        @php $i = 1; @endphp
                                        @foreach($studentAccomplishments as $studentAccomplishment)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $studentAccomplishment->title }}</td>
                                                <td>
                                                    @if($studentAccomplishment->status == 1)
                                                        <span class="badge rounded-pill fs-6 bg-warning text-dark">Pending</span>
                                                    @elseif($studentAccomplishment->status == 2)
                                                        <span class="badge rounded-pill fs-6 bg-success text-white">Approved</span>
                                                    @elseif($studentAccomplishment->status == 3)
                                                        <span class="badge rounded-pill fs-6 bg-danger text-white">Disapproved</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($studentAccomplishment->start_date == $studentAccomplishment->end_date)
                                                    {{
                                                        date_format(date_create($studentAccomplishment->start_date), 'F d, Y')
                                                    }}
                                                    @else
                                                    {{
                                                        date_format(date_create($studentAccomplishment->start_date), 'F d, Y') . ' - ' . date_format(date_create($studentAccomplishment->end_date), 'F d, Y')
                                                    }}
                                                    @endif
                                                    -
                                                    @if($studentAccomplishment->start_time == $studentAccomplishment->end_time)
                                                    {{
                                                        date_format(date_create($studentAccomplishment->start_time), 'h:i A')
                                                    }}
                                                    @else
                                                    {{
                                                        date_format(date_create($studentAccomplishment->start_time), 'h:i A') . ' - ' . date_format(date_create($studentAccomplishment->end_time), 'h:i A')
                                                    }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-success text-white" 
                                                        href="{{ route('studentAccomplishment.show', ['accomplishmentUUID' => $studentAccomplishment->accomplishment_uuid]) }}" 
                                                        role="button">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @php $i += 1; @endphp
                                        @endforeach

                                    @else
                                        <tr>
                                            <td colspan="5">No Accomplishment found :(. You can create one <a href="{{route('studentAccomplishment.create')}}"><u>here</u></a>.</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>

                                {{-- My Accomplishments Table Pager --}}
                                @if($studentAccomplishments->total() > 0)
                                    <div class="d-flex justify-content-center">
                                        @role('AR Officer Admin')
                                            {{ $studentAccomplishments->appends([
                                                'myAccomplishments' => $studentAccomplishments->currentPage(),
                                                'pendingAccomplishments' => $accomplishmentSubmissions->currentPage(),
                                            ])->links() }}
                                        @else
                                            {{ $studentAccomplishments->links() }}
                                        @endrole
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endrole

                    {{-- If User has AR Officer role... --}}
                    @role('AR Officer Admin')

                        {{-- Accomplishment Submissions Table --}}
                        <div class="card w-100 my-3">
                            <h4 class="card-header card-title text-center bg-maroon text-white fw-bold">Pending Accomplishment Submissions</h4>
                            <div class="card-body">
                                <table class="w-100 table table-bordered table-striped table-hover border border-dark" id="accomplishmentSubmissionTable">
                                    <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Date and Time</th>
                                        <th>Option</th>
                                    </thead>
                                    <tbody>
                                    @if($accomplishmentSubmissions->total() > 0)
                                        @php $i = 1; @endphp
                                        @foreach($accomplishmentSubmissions as $accomplishmentSubmission)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $accomplishmentSubmission->student->full_name }}</td>
                                                <td>{{ $accomplishmentSubmission->title }}</td>
                                                <td>
                                                    @if($accomplishmentSubmission->status == 1)
                                                        <span class="badge rounded-pill fs-6 bg-warning text-dark">Pending</span>
                                                    @elseif($accomplishmentSubmission->status == 2)
                                                        <span class="badge rounded-pill fs-6 bg-success text-white">Approved</span>
                                                    @elseif($accomplishmentSubmission->status == 3)
                                                        <span class="badge rounded-pill fs-6 bg-danger text-white">Disapproved</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($accomplishmentSubmission->start_date == $accomplishmentSubmission->end_date){{
                                                        date_format(date_create($accomplishmentSubmission->start_date), 'F d, Y')
                                                    }}
                                                    @else
                                                    {{
                                                        date_format(date_create($accomplishmentSubmission->start_date), 'F d, Y') . ' - ' . date_format(date_create($accomplishmentSubmission->end_date), 'F d, Y')
                                                    }}
                                                    @endif
                                                    -
                                                    @if($accomplishmentSubmission->start_time == $accomplishmentSubmission->end_time){{
                                                        date_format(date_create($accomplishmentSubmission->start_time), 'h:i A')
                                                    }}
                                                    @else
                                                    {{
                                                        date_format(date_create($accomplishmentSubmission->start_time), 'h:i A') . '-' . date_format(date_create($accomplishmentSubmission->end_time), 'h:i A')
                                                    }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-success text-white" 
                                                        href="{{ route('studentAccomplishment.show', ['accomplishmentUUID' => $accomplishmentSubmission->accomplishment_uuid]) }}" 
                                                        role="button">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @php $i += 1; @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No Accomplishment Submission found!</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>

                                {{-- Accomplishment Submissions Table Pager --}}
                                @if($accomplishmentSubmissions->total() > 0)
                                    <div class="d-flex justify-content-center">
                                        @role('User')
                                            {{ $accomplishmentSubmissions->appends([
                                                'myAccomplishments' => $studentAccomplishments->currentPage(),
                                                'pendingAccomplishments' => $accomplishmentSubmissions->currentPage(),
                                            ])->links() }}
                                        @else
                                            {{ $accomplishmentSubmissions->links() }}
                                        @endrole
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endrole
        		</div>
        	</div>

        	<hr>

            <div class="flex-row my-2 text-center">
                <a href="{{ route('home') }}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-arrow-left"></i> Go Back
                </a>

                @role('User')
                    <span>or</span>

                    <a href="{{ route('studentAccomplishment.create') }}"
                        class="btn btn-primary text-white"
                        role="button">
                            <i class="fas fa-award"></i> Submit an Accomplishment
                    </a>
                @endrole
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
        // Datatables JS
        const dataTable = new simpleDatatables.DataTable("#myAccomplishmentTable", {
            searchable: true,
            labels: {
            placeholder: "Search Accomplishments...",
            perPage: "Show {select} accomplishment per page",
            noRows: "No accomplishment to display or try the next page",
            info: "Showing {start} to {end} of {rows} accomplishment (Page {page} of {pages} pages)",
            },
        });
        const dataTable2 = new simpleDatatables.DataTable("#accomplishmentSubmissionTable", {
            searchable: true,
            labels: {
            placeholder: "Search Accomplishments...",
            perPage: "Show {select} accomplishment per page",
            noRows: "No accomplishment to display or try the next page",
            info: "Showing {start} to {end} of {rows} accomplishment (Page {page} of {pages} pages)",
            },
        });
    </script>
@endsection
