<table>
    <tbody>
        <tr>
            <th scope="col" colspan="7" style="text-align: center;">STUDENTS AWARDS / RECOGNITIONS FROM REPUTABLE ORGANIZATIONS</th>
        </tr>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name of Award</th>
            <th scope="col">Certifying Body</th>
            <th scope="col">Place</th>
            <th scope="col">Date(mm/dd/yyyy)</th>
            <th scope="col">Level</th>
            <th scope="col">Description of Supporting Documents Submitted</th>
        </tr>
        @php $i = 1; @endphp
        @foreach($table1 as $accomplishment)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $accomplishment['title'] }}</td>
            <td>{{ $accomplishment['organizer'] }}</td>
            <td>{{ $accomplishment['venue'] }}</td>
            <td>{{ date_format(date_create($accomplishment['end_date']), 'm-d-Y') }}</td>
            <td>{{ $accomplishment['level']->level }}</td>
            <td>-</td>
        </tr>
        @php $i += 1; @endphp
        @endforeach

    <tr></tr>

    <tr>
        <th scope="col" colspan="7" style="text-align: center;">COMMUNITY RELATION AND OUTREACH PROGRAM</th>
    </tr>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Title of Program</th>
        <th scope="col">Place</th>
        <th scope="col">Date(mm/dd/yyyy)</th>
        <th scope="col">Level</th>
        <th scope="col">No. of Beneficiaries</th>
        <th scope="col">Description of Supporting Documents Submitted</th>
    </tr>

        @php $i = 1; @endphp
        @foreach($table2 as $communityOutreach)
    <tr>
        <td>{{ $i }}</td>
        <td>{{ $communityOutreach['title'] }}</td>
        <td>{{ $communityOutreach['venue'] }}</td>
        <td>{{ date_format(date_create($communityOutreach['end_date']), 'm-d-Y') }}</td>
        <td>{{ $communityOutreach['eventLevel']->level }}</td>
        <td>{{ $communityOutreach['total_beneficiary'] }}</td>
        <td>-</td>
    </tr>
        @php $i += 1; @endphp
        @endforeach 

    <tr></tr>

    <tr>
        <th scope="col" colspan="15" style="text-align: center;">STUDENT TRAININGS AND SEMINARS</th>
    </tr>
    <tr>
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
        <th scope="col">Description of Supporting Documents Submitted<br>(MOA/MOU, Certificate of Recognitions/Appreciations)</th>
    </tr>

        @php $i = 1; @endphp
        @foreach($table3 as $trainingAndSeminar)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $trainingAndSeminar['organization']->organization_acronym }}</td>
            <td> - </td>
            <td>{{ $trainingAndSeminar['title'] }}</td>
            <td> - </td>
            <td> - </td>
            <td>{{ $trainingAndSeminar['budget'] ?? 'NONE' }} </td>
            <td>{{ $trainingAndSeminar['eventFundSource']->fund_source }} </td>
            <td>{{ $trainingAndSeminar['organization']->organization_acronym }} </td>
            <td>{{ $trainingAndSeminar['eventLevel']->level }}</td>
            <td>{{ $trainingAndSeminar['venue'] }}</td>
            <td>{{ date_format(date_create($trainingAndSeminar['start_date']), 'm-d-Y') }}</td>
            <td>{{ date_format(date_create($trainingAndSeminar['end_date']), 'm-d-Y') }}</td>
            <td>
                {{
                    (date_create($trainingAndSeminar['start_date'])->diff(date_create($trainingAndSeminar['end_date']))->format("%a") + 1)
                    * round(abs(strtotime($trainingAndSeminar['end_time']) - strtotime($trainingAndSeminar['start_time'])) / 3600, 2)
                    . ' hours'
                }}
            </td>
        </tr>
        @php $i += 1; @endphp
        @endforeach 

    </tbody>

</table>

