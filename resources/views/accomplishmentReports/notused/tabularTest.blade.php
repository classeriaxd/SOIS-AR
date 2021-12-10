@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
    		<h2 class="display-2 text-center">Tabular Report</h2>
            @if($table1->isNotEmpty())
            <h4 class="text-center">STUDENTS AWARDS / RECOGNITIONS FROM REPUTABLE ORGANIZATIONS</h4>
            <table class="w-100 table-bordered">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Name of Award</th>
                    <th scope="col">Certifying Body</th>
                    <th scope="col">Date(mm/dd/yyyy)</th>
                    <th scope="col">Level</th>
                </thead>
                @php $i = 1; @endphp
                <tbody>
                @foreach($table1 as $accomplishment)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $accomplishment->title }}</td>
                        <td>{{ $accomplishment->organizer }}</td>
                        <td>{{ date_format(date_create($accomplishment->end_date), 'm-d-Y') }}</td>
                        <td>{{ $accomplishment->level->level }}</td>
                    </tr>
                @php $i += 1; @endphp
                @endforeach
                </tbody>
            </table>
            @else
                <p>NO TABLE 1!!!!</p>
            @endif

            <br>

            <h4 class="text-center">COMMUNITY RELATION AND OUTREACH PROGRAM</h4>
            <table class="w-100 table-bordered">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Title of Program</th>
                    <th scope="col">Place</th>
                    <th scope="col">Date(mm/dd/yyyy)</th>
                    <th scope="col">Level</th>
                    <th scope="col">No. of Beneficiaries</th>
                </thead>
                @php $i = 1; @endphp
                <tbody>
                    @foreach($table2 as $communityOutreach)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $communityOutreach->title }}</td>
                        <td>{{ $communityOutreach->venue }}</td>
                        <td>{{ date_format(date_create($communityOutreach->end_date), 'm-d-Y') }}</td>
                        <td>{{ $communityOutreach->eventLevel->level }}</td>
                        <td>{{ $communityOutreach->total_beneficiary }}</td>
                    </tr>
                    @php $i += 1; @endphp
                    @endforeach 
                </tbody>
            </table>

            <br>

            <h4 class="text-center">STUDENT TRAININGS AND SEMINARS</h4>
            <table class="w-100 table-bordered">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Department</th>
                    <th scope="col">Name of Student</th>
                    <th scope="col">Title</th>
                    <th scope="col">Classification</th>
                    <th scope="col">Nature</th>
                    <th scope="col">Budget(in PhP)</th>
                    <th scope="col">Source of Fund</th>
                    <th scope="col">Organizer</th>
                    <th scope="col">Level</th>
                    <th scope="col">Venue</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Total No. of Hours</th>
                </thead>
                @php $i = 1; @endphp
                <tbody>
                    @foreach($table3 as $trainingAndSeminar)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $trainingAndSeminar->organization->organization_acronym }}</td>
                        <td> - </td>
                        <td>{{ $trainingAndSeminar->title }}</td>
                        <td> - </td>
                        <td> - </td>
                        <td>{{ $trainingAndSeminar->budget ?? 'NONE' }} </td>
                        <td>{{ $trainingAndSeminar->eventFundSource->fund_source }} </td>
                        <td>{{ $trainingAndSeminar->organization->organization_acronym }} </td>
                        <td>{{ $trainingAndSeminar->eventLevel->level }}</td>
                        <td>{{ $trainingAndSeminar->venue }}</td>
                        <td>{{ date_format(date_create($trainingAndSeminar->start_date), 'm-d-Y') }}</td>
                        <td>{{ date_format(date_create($trainingAndSeminar->end_date), 'm-d-Y') }}</td>
                        <td>
                            {{
                                (date_create($trainingAndSeminar->start_date)->diff(date_create($trainingAndSeminar->end_date))->format("%a") + 1)
                                * round(abs(strtotime($trainingAndSeminar->end_time) - strtotime($trainingAndSeminar->start_time)) / 3600, 2)
                                . ' hours'
                            }}
                        </td>
                    </tr>
                    @php $i += 1; @endphp
                    @endforeach 
                </tbody>
            </table>            
        	<hr>
        	<div class="row justify-content-center pt-1">
        		<a href="{{route('accomplishmentreports.index')}}">
        			<button class="btn btn-secondary">Go Back</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection
