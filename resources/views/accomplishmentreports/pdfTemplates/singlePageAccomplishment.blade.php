<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{public_path('css/pdf_css.css') }}" rel="stylesheet" media="screen">
</head>

<body>

    <div class="page">
        <div class="event-title-block vertical-center">
            <p class="block-title">{{ $accomplishment['title'] }}</p>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="page">
        <div class="event-info-block vertical-center">
            <p class="block-title">Accomplishment Description</p>
            <p class="block-desc">{{ $accomplishment['description'] }}</p>
            <br>
            <h4 class="block-title">Student Details</h4>
            <p class="block-title">Student Name</p>
            <p class="block-desc">{{$accomplishment['user']['last_name'] . ', '. $accomplishment['user']['first_name'] . ' ' . $accomplishment['user']['middle_name']}}</p>
            <p class="block-title">Student Number</p>
            <p class="block-desc">{{$accomplishment['user']['student_number']}}</p>
        </div>
    </div>

</body>
</html>