<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{public_path('css/pdf_css.css') }}" rel="stylesheet" media="screen">
</head>

<body>

    <div class="page">
        <div class="event-title-block vertical-center">
            <p class="block-desc">Title</p>
            <p class="block-title">{{ $accomplishment['title'] }}</p>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="page">
        <div class="event-info-block vertical-center">
            <p class="block-title">Description</p>
            <p class="block-desc">{{ $accomplishment['description'] }}</p>
            <br>
            <p class="block-title">Objectives</p>
            <p class="block-desc">{{ $accomplishment['objective'] }}</p>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="page">
        <div class="event-info-block vertical-center">
            <p class="block-title">Date and Time</p>
            <p class="block-desc">
                @if($accomplishment['start_date'] == $accomplishment['end_date'])
                {{date_format(date_create($accomplishment['start_date']), 'F d, Y')}}
                @else
                {{date_format(date_create($accomplishment['start_date']), 'F d, Y') . ' - ' . date_format(date_create($accomplishment['end_date']), 'F d, Y')}}
                @endif
                 | 
                @if($accomplishment['start_time'] == $accomplishment['end_time'])
                {{date_format(date_create($accomplishment['start_time']), 'h:i A')}}
                @else
                {{date_format(date_create($accomplishment['start_time']), 'h:i A') . ' - ' . date_format(date_create($accomplishment['end_time']), 'h:i A')}}
                @endif
            </p>
            <p class="block-title">Venue</p>
            <p class="block-desc">{{ $accomplishment['venue'] }}</p>

            <p class="block-title">Activity Type</</p>
            <p class="block-desc">{{ $accomplishment['activity_type'] }}</p>

            <p class="block-title">Event Beneficiaries</p>
            <p class="block-desc">{{ $accomplishment['beneficiaries'] }}</p>

            <p class="block-title">Organizer</p>
            <p class="block-desc">{{ $accomplishment['organizer'] }}</p>

            <p class="block-title">Student Details</p>
            <p class="block-desc">
                {{$accomplishment['student']['last_name'] . ', '. $accomplishment['student']['first_name'] . ' ' . $accomplishment['student']['middle_name']}}
                <br>
                {{$accomplishment['student']['student_number']}}
            </p>
        </div>
    </div>

</body>
</html>
