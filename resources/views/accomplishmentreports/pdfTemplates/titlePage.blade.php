<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{public_path('css/pdf_css.css') }}" rel="stylesheet" media="screen">
</head>

<body>

    <div class="page">
        <div class="intro-title-block vertical-center">

            <img src="{{public_path('/storage/'. $organization->logo->file) }}">
            <h2>Republic of the Philippines<br>
            <strong>POLYTECHNIC UNIVERSITY OF THE PHILIPPINES</strong><br>
            <strong>TAGUIG CITY BRANCH</strong><br>
            <strong><span style="text-transform: uppercase;">{{$organization->organization_name}}</span></strong></h2> 
            <br>
            <h2>
                @switch($rangeTitle)
                    @case(1)
                        SEMESTRAL ACCOMPLISHMENT REPORT OF
                        @break
                    @case(2)
                        QUARTERLY ACCOMPLISHMENT REPORT OF
                        @break
                    @case(3)
                        ACCOMPLISHMENT REPORT OF
                        @break
                @endswitch
                <br>
                <span style="text-transform: uppercase;">{{$organization->organization_name}}</span>
                <br>
                CENTRAL BODY
            </h2>
            <h3>({{ $startDate .' — '. $endDate }})</h3>
        </div>
    </div>
</body>
</html>