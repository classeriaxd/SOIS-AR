<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table>
        <tbody>

            {{-- TABLE VII. Students Awards/ Recognitions from  Reputable Organizations --}}
            <tr>
                <th scope="col" colspan="7" style="text-align: center;">{{ $table1Columns->tabular_table_name }}</th>
            </tr>
            <tr>
                <th scope="col">{{ $table1Columns->tabularColumns[0]->tabular_column_name }}</th>
                <th scope="col">{{ $table1Columns->tabularColumns[1]->tabular_column_name }}</th>
                <th scope="col">{{ $table1Columns->tabularColumns[2]->tabular_column_name }}</th>
                <th scope="col">{{ $table1Columns->tabularColumns[3]->tabular_column_name }}</th>
                <th scope="col">{{ $table1Columns->tabularColumns[4]->tabular_column_name }}</th>
                <th scope="col">{{ $table1Columns->tabularColumns[5]->tabular_column_name }}</th>
                <th scope="col">{{ $table1Columns->tabularColumns[6]->tabular_column_name }}</th>
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

        {{-- ROW BREAK --}}
        <tr></tr>

        {{-- TABLE VIII. Community Relation and Outreach Program --}}
        <tr>
            <th scope="col" colspan="7" style="text-align: center;">{{ $table2Columns->tabular_table_name }}</th>
        </tr>
        <tr>
            <th scope="col">{{ $table2Columns->tabularColumns[0]->tabular_column_name }}</th>
            <th scope="col">{{ $table2Columns->tabularColumns[1]->tabular_column_name }}</th>
            <th scope="col">{{ $table2Columns->tabularColumns[2]->tabular_column_name }}</th>
            <th scope="col">{{ $table2Columns->tabularColumns[3]->tabular_column_name }}</th>
            <th scope="col">{{ $table2Columns->tabularColumns[4]->tabular_column_name }}</th>
            <th scope="col">{{ $table2Columns->tabularColumns[5]->tabular_column_name }}</th>
            <th scope="col">{{ $table2Columns->tabularColumns[6]->tabular_column_name }}</th>
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

        {{-- ROW BREAK --}}
        <tr></tr>

        {{-- TABLE IX. STUDENTS TRAININGS AND SEMINARS --}}
        <tr>
            <th scope="col" colspan="15" style="text-align: center;">{{ $table3Columns->tabular_table_name }}</th>
        </tr>
        <tr>
            <th scope="col">{{ $table3Columns->tabularColumns[0]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[1]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[2]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[3]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[4]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[5]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[6]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[7]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[8]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[9]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[10]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[11]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[12]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[13]->tabular_column_name }}</th>
            <th scope="col">{{ $table3Columns->tabularColumns[14]->tabular_column_name }}</th>
        </tr>

            @php $i = 1; @endphp
            @foreach($table3 as $trainingAndSeminar)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $trainingAndSeminar['organization']->organization_acronym }}</td>
                <td> - </td>
                <td>{{ $trainingAndSeminar['title'] }}</td>
                <td>{{ $trainingAndSeminar['eventClassification']->classification }} </td>
                <td>{{ $trainingAndSeminar['eventNature']->nature }} </td>
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

        {{-- ROW BREAK --}}
        <tr></tr>

        {{-- TABLE X. OTHER STUDENT ACTIVITIES --}}
        <tr>
            <th scope="col" colspan="15" style="text-align: center;">{{ $table4Columns->tabular_table_name }}</th>
        </tr>
        <tr>
            <th scope="col">{{ $table4Columns->tabularColumns[0]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[1]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[2]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[3]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[4]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[5]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[6]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[7]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[8]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[9]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[10]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[11]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[12]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[13]->tabular_column_name }}</th>
            <th scope="col">{{ $table4Columns->tabularColumns[14]->tabular_column_name }}</th>
        </tr>

            @php $i = 1; @endphp
            @foreach($table4 as $otherStudentActivity)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $otherStudentActivity['organization']->organization_acronym }}</td>
                <td> - </td>
                <td>{{ $otherStudentActivity['title'] }}</td>
                <td>{{ $otherStudentActivity['eventClassification']->classification }} </td>
                <td>{{ $otherStudentActivity['eventNature']->nature }} </td>
                <td>{{ $otherStudentActivity['budget'] ?? 'NONE' }} </td>
                <td>{{ $otherStudentActivity['eventFundSource']->fund_source }} </td>
                <td>{{ $otherStudentActivity['organization']->organization_acronym }} </td>
                <td>{{ $otherStudentActivity['eventLevel']->level }}</td>
                <td>{{ $otherStudentActivity['venue'] }}</td>
                <td>{{ date_format(date_create($otherStudentActivity['start_date']), 'm-d-Y') }}</td>
                <td>{{ date_format(date_create($otherStudentActivity['end_date']), 'm-d-Y') }}</td>
                <td>
                    {{
                        (date_create($otherStudentActivity['start_date'])->diff(date_create($otherStudentActivity['end_date']))->format("%a") + 1)
                        * round(abs(strtotime($otherStudentActivity['end_time']) - strtotime($otherStudentActivity['start_time'])) / 3600, 2)
                        . ' hours'
                    }}
                </td>
            </tr>
            @php $i += 1; @endphp
            @endforeach 

        </tbody>

    </table>

</body>
</html>

