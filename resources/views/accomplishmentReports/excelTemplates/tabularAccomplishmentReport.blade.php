<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
{{-- For Maintenance, you'd have to edit this thing almost entirely, goodluck :)))) --}}
{{-- Some data are on Collection, some are on Array, please dd() to review --}}
<body>
    <table>
        <tbody>
            {{-- Excel Table Format for Tabular AR  --}}

            {{-- TABLE VII. Students Awards/ Recognitions from  Reputable Organizations --}}
            <tr>
                <th scope="col" colspan="7" style="text-align: center;">{{ $table1Columns->tabular_table_name }}</th>
            </tr>
            <tr>
                {{-- # --}}
                <th scope="col">{{ $table1Columns->tabularColumns[0]->tabular_column_name }}</th>
                {{-- Name of Award --}}
                <th scope="col">{{ $table1Columns->tabularColumns[1]->tabular_column_name }}</th>
                {{-- Certifying Body --}}
                <th scope="col">{{ $table1Columns->tabularColumns[2]->tabular_column_name }}</th>
                {{-- Place --}}
                <th scope="col">{{ $table1Columns->tabularColumns[3]->tabular_column_name }}</th>
                {{-- Date(mm/dd/yyyy) --}}
                <th scope="col">{{ $table1Columns->tabularColumns[4]->tabular_column_name }}</th>
                {{-- Level --}}
                <th scope="col">{{ $table1Columns->tabularColumns[5]->tabular_column_name }}</th>
                {{-- Description of Supporting Documents Submitted --}}
                <th scope="col">{{ $table1Columns->tabularColumns[6]->tabular_column_name }}</th>
            </tr>
            @php $i = 1; @endphp
            @foreach($table1 as $accomplishment)
                <tr>
                    {{-- # --}}
                    <td>{{ $i }}</td>
                    {{-- Name of Award --}}
                    <td>{{ $accomplishment['title'] }}</td>
                    {{-- Certifying Body --}}
                    <td>{{ $accomplishment['organizer'] }}</td>
                    {{-- Place --}}
                    <td>{{ $accomplishment['venue'] }}</td>
                    {{-- Date(mm/dd/yyyy) --}}
                    <td>{{ date_format(date_create($accomplishment['end_date']), 'm-d-Y') }}</td>
                    {{-- Level --}}
                    <td>{{ $accomplishment['level']->level }}</td>
                    {{-- Description of Supporting Documents Submitted --}}
                    <td>
                        @if($accomplishment['accomplishmentFiles']->count() > 0)
                            @php $documentTitleTypes = ''; @endphp
                            @foreach($accomplishment['accomplishmentFiles'] as $document)
                                @php $documentTitleTypes .= $document->documentType->document_type; @endphp
                                @if(! $loop->last)
                                    @php $documentTitleTypes .= ', '; @endphp
                                    
                                @endif
                            @endforeach
                            {{ $documentTitleTypes }}
                        @else
                        -
                        @endif
                    </td>
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
            {{-- # --}}
            <th scope="col">{{ $table2Columns->tabularColumns[0]->tabular_column_name }}</th>
            {{-- Title of Program --}}
            <th scope="col">{{ $table2Columns->tabularColumns[1]->tabular_column_name }}</th>
            {{-- Place --}}
            <th scope="col">{{ $table2Columns->tabularColumns[2]->tabular_column_name }}</th>
            {{-- Date(mm/dd/yyy) --}}
            <th scope="col">{{ $table2Columns->tabularColumns[3]->tabular_column_name }}</th>
            {{-- Level --}}
            <th scope="col">{{ $table2Columns->tabularColumns[4]->tabular_column_name }}</th>
            {{-- Number of Beneficiaries --}}
            <th scope="col">{{ $table2Columns->tabularColumns[5]->tabular_column_name }}</th>
            {{-- Description of Supporting Documents Submitted --}}
            <th scope="col">{{ $table2Columns->tabularColumns[6]->tabular_column_name }}</th>
        </tr>

        {{-- TABLE VIII ROWS --}}
        @php $i = 1; @endphp
        @foreach($table2 as $communityOutreach)
            <tr>
                {{-- # --}}
                <td>{{ $i }}</td>
                {{-- Title of Program --}}
                <td>{{ $communityOutreach['title'] }}</td>
                {{-- Place --}}
                <td>{{ $communityOutreach['venue'] }}</td>
                {{-- Date(mm/dd/yyy) --}}
                <td>{{ date_format(date_create($communityOutreach['end_date']), 'm-d-Y') }}</td>
                {{-- Level --}}
                <td>{{ $communityOutreach['eventLevel']->level }}</td>
                {{-- Number of Beneficiaries --}}
                <td>{{ 
                        $communityOutreach['total_beneficiary'] . " " .
                        $communityOutreach['beneficiaries'] 
                    }}
                </td>
                {{-- Description of Supporting Documents Submitted --}}
                <td>
                    @if($communityOutreach['eventDocuments']->count() > 0)
                    @php $documentTitleTypes = ''; @endphp
                        @foreach($communityOutreach['eventDocuments'] as $document)
                        @php $documentTitleTypes .= $document->documentType->document_type; @endphp
                        @if(! $loop->last)
                            @php $documentTitleTypes .= ', '; @endphp
                            
                        @endif
                    @endforeach

                    {{ $documentTitleTypes }}
                    @else
                    -
                    @endif
                </td>
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
            {{-- # --}}
            <th scope="col">{{ $table3Columns->tabularColumns[0]->tabular_column_name }}</th>
            {{-- Department --}}
            <th scope="col">{{ $table3Columns->tabularColumns[1]->tabular_column_name }}</th>
            {{-- Name of Student (Surname, First Name, Middle Initial) --}}
            <th scope="col">{{ $table3Columns->tabularColumns[2]->tabular_column_name }}</th>
            {{-- Title --}}
            <th scope="col">{{ $table3Columns->tabularColumns[3]->tabular_column_name }}</th>
            {{-- Classification --}}
            <th scope="col">{{ $table3Columns->tabularColumns[4]->tabular_column_name }}</th>
            {{-- Nature --}}
            <th scope="col">{{ $table3Columns->tabularColumns[5]->tabular_column_name }}</th>
            {{-- Budget (in PhP) --}}
            <th scope="col">{{ $table3Columns->tabularColumns[6]->tabular_column_name }}</th>
            {{-- Source of Fund --}}
            <th scope="col">{{ $table3Columns->tabularColumns[7]->tabular_column_name }}</th>
            {{-- Organizer --}}
            <th scope="col">{{ $table3Columns->tabularColumns[8]->tabular_column_name }}</th>
            {{-- Level --}}
            <th scope="col">{{ $table3Columns->tabularColumns[9]->tabular_column_name }}</th>
            {{-- Venue --}}
            <th scope="col">{{ $table3Columns->tabularColumns[10]->tabular_column_name }}</th>
            {{-- To (mm/dd/yy) --}}
            <th scope="col">{{ $table3Columns->tabularColumns[11]->tabular_column_name }}</th>
            {{-- To (mm/dd/yy) --}}
            <th scope="col">{{ $table3Columns->tabularColumns[12]->tabular_column_name }}</th>
            {{-- Total No. of Hours --}}
            <th scope="col">{{ $table3Columns->tabularColumns[13]->tabular_column_name }}</th>
            {{-- Description of Supporting Documents Submitted (MOA/MOU, Certificate of Recognitions/Appreciations) --}}
            <th scope="col">{{ $table3Columns->tabularColumns[14]->tabular_column_name }}</th>
        </tr>

        {{-- TABLE IX ROWS --}}
        @php $i = 1; @endphp
        @foreach($table3 as $trainingAndSeminar)
            <tr>
                {{-- # --}}
                <td>{{ $i }}</td>
                {{-- Department --}}
                <td>{{ $trainingAndSeminar['organization']->organization_acronym }}</td>
                {{-- Name of Student (Surname, First Name, Middle Initial) --}}
                <td>{{ 
                        $trainingAndSeminar['total_beneficiary'] . " " .
                        $trainingAndSeminar['beneficiaries'] 
                    }}
                </td>
                {{-- Title --}}
                <td>{{ $trainingAndSeminar['title'] }}</td>
                {{-- Classification --}}
                <td>{{ $trainingAndSeminar['eventClassification']->classification }} </td>
                {{-- Nature --}}
                <td>{{ $trainingAndSeminar['eventNature']->nature }} </td>
                {{-- Budget (in PhP) --}}
                <td>{{ $trainingAndSeminar['budget'] ?? 'NONE' }} </td>
                {{-- Source of Fund --}}
                <td>{{ $trainingAndSeminar['eventFundSource']->fund_source }} </td>
                {{-- Organizer --}}
                <td>{{ $trainingAndSeminar['organization']->organization_acronym }} </td>
                {{-- Level --}}
                <td>{{ $trainingAndSeminar['eventLevel']->level }}</td>
                {{-- Venue --}}
                <td>{{ $trainingAndSeminar['venue'] }}</td>
                {{-- From (mm/dd/yy)--}}
                <td>{{ date_format(date_create($trainingAndSeminar['start_date']), 'm-d-Y') }}</td>
                {{-- To (mm/dd/yy)--}}
                <td>{{ date_format(date_create($trainingAndSeminar['end_date']), 'm-d-Y') }}</td>
                {{-- Total No. of Hours --}}
                <td>
                    {{
                        (date_create($trainingAndSeminar['start_date'])->diff(date_create($trainingAndSeminar['end_date']))->format("%a") + 1)
                        * round(abs(strtotime($trainingAndSeminar['end_time']) - strtotime($trainingAndSeminar['start_time'])) / 3600, 2)
                        . ' hours'
                    }}
                </td>
                {{-- Description of Supporting Documents Submitted (MOA/MOU, Certificate of Recognitions/Appreciations) --}}
                <td>
                    @if($trainingAndSeminar['eventDocuments']->count() > 0)
                        @php $documentTitleTypes = ''; @endphp
                        @foreach($trainingAndSeminar['eventDocuments'] as $document)
                            @php $documentTitleTypes .= $document->documentType->document_type; @endphp
                            @if(! $loop->last)
                                @php $documentTitleTypes .= ', '; @endphp
                                
                            @endif
                        @endforeach
                    
                        {{ $documentTitleTypes }}
                    @else
                    -
                    @endif
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
            {{-- # --}}
            <th scope="col">{{ $table4Columns->tabularColumns[0]->tabular_column_name }}</th>
            {{-- Department --}}
            <th scope="col">{{ $table4Columns->tabularColumns[1]->tabular_column_name }}</th>
            {{-- Name of Student (Surname, First Name, Middle Initial) --}}
            <th scope="col">{{ $table4Columns->tabularColumns[2]->tabular_column_name }}</th>
            {{-- Title --}}
            <th scope="col">{{ $table4Columns->tabularColumns[3]->tabular_column_name }}</th>
            {{-- Classification --}}
            <th scope="col">{{ $table4Columns->tabularColumns[4]->tabular_column_name }}</th>
            {{-- Nature --}}
            <th scope="col">{{ $table4Columns->tabularColumns[5]->tabular_column_name }}</th>
            {{-- Budget (in PhP) --}}
            <th scope="col">{{ $table4Columns->tabularColumns[6]->tabular_column_name }}</th>
            {{-- Source of Fund --}}
            <th scope="col">{{ $table4Columns->tabularColumns[7]->tabular_column_name }}</th>
            {{-- Organizer --}}
            <th scope="col">{{ $table4Columns->tabularColumns[8]->tabular_column_name }}</th>
            {{-- Level --}}
            <th scope="col">{{ $table4Columns->tabularColumns[9]->tabular_column_name }}</th>
            {{-- Venue --}}
            <th scope="col">{{ $table4Columns->tabularColumns[10]->tabular_column_name }}</th>
            {{-- From (mm/dd/yy)--}}
            <th scope="col">{{ $table4Columns->tabularColumns[11]->tabular_column_name }}</th>
            {{-- To (mm/dd/yy)--}}
            <th scope="col">{{ $table4Columns->tabularColumns[12]->tabular_column_name }}</th>
            {{-- Total No. of Hours --}}
            <th scope="col">{{ $table4Columns->tabularColumns[13]->tabular_column_name }}</th>
            {{-- Description of Supporting Documents Submitted (MOA/MOU, Certificate of Recognitions/Appreciations) --}}
            <th scope="col">{{ $table4Columns->tabularColumns[14]->tabular_column_name }}</th>
        </tr>

        {{-- TABLE X ROWS --}}
        @php $i = 1; @endphp
        @foreach($table4 as $otherStudentActivity)
            <tr>
                {{-- # --}}
                <td>{{ $i }}</td>
                {{-- Department --}}
                <td>{{ $otherStudentActivity['organization']->organization_acronym }}</td>
                {{-- Name of Student (Surname, First Name, Middle Initial) --}}
                <td>{{ 
                        $otherStudentActivity['total_beneficiary'] . " " .
                        $otherStudentActivity['beneficiaries'] 
                    }}
                </td>
                {{-- Title --}}
                <td>{{ $otherStudentActivity['title'] }}</td>
                {{-- Classification --}}
                <td>{{ $otherStudentActivity['eventClassification']->classification }} </td>
                {{-- Nature --}}
                <td>{{ $otherStudentActivity['eventNature']->nature }} </td>
                {{-- Budget (in PhP) --}}
                <td>{{ $otherStudentActivity['budget'] ?? 'NONE' }} </td>
                {{-- Source of Fund --}}
                <td>{{ $otherStudentActivity['eventFundSource']->fund_source }} </td>
                {{-- Organizer --}}
                <td>{{ $otherStudentActivity['organization']->organization_acronym }} </td>
                {{-- Level --}}
                <td>{{ $otherStudentActivity['eventLevel']->level }}</td>
                {{-- Venue --}}
                <td>{{ $otherStudentActivity['venue'] }}</td>
                {{-- From (mm/dd/yy)--}}
                <td>{{ date_format(date_create($otherStudentActivity['start_date']), 'm-d-Y') }}</td>
                {{-- To (mm/dd/yy)--}}
                <td>{{ date_format(date_create($otherStudentActivity['end_date']), 'm-d-Y') }}</td>
                {{-- Total No. of Hours --}}
                <td>
                    {{
                        (date_create($otherStudentActivity['start_date'])->diff(date_create($otherStudentActivity['end_date']))->format("%a") + 1)
                        * round(abs(strtotime($otherStudentActivity['end_time']) - strtotime($otherStudentActivity['start_time'])) / 3600, 2)
                        . ' hours'
                    }}
                </td>
                {{-- Description of Supporting Documents Submitted (MOA/MOU, Certificate of Recognitions/Appreciations) --}}
                <td>
                    @if($otherStudentActivity['eventDocuments']->count() > 0)
                        @php $documentTitleTypes = ''; @endphp
                        @foreach($otherStudentActivity['eventDocuments'] as $document)
                            @php $documentTitleTypes .= $document->documentType->document_type; @endphp
                            @if(! $loop->last)
                                @php $documentTitleTypes .= ', '; @endphp
                                
                            @endif
                        @endforeach
                    
                        {{ $documentTitleTypes }}
                    @else
                    -
                    @endif
                </td>
            </tr>
            @php $i += 1; @endphp
        @endforeach 

        </tbody>
    </table>
</body>
</html>