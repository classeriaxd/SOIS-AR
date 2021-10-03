<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{public_path('css/pdf_css.css') }}" rel="stylesheet" media="screen">
</head>

<body>

    @isset($accomplishment['accomplishment_files'])
    <div class="page-break"></div>
        @php 
            $i = 1; 
            $j = 1;
            $fileCount = count($accomplishment['accomplishment_files']);
        @endphp

        {{-- Prints 2 imgs in a single page --}}
        @foreach($accomplishment['accomplishment_files'] as $accomplishment)
        @if($accomplishment['type'] == 1)
            @if($j == 1)
            <div class="page">
            @endif

            @if($i == 1)
            <div class="event-img-block">
                <p class="block-title">Images</p>
            </div>
                @php $i = 0; @endphp
            @endif

            @if($j <= 2)
            <div class="event-img-block">
                <div class="img-block">
                    <img src="{{ public_path('/storage/'.$accomplishment['file']) }}">
                </div>
            </div>
                @php 
                    $j++;
                    $fileCount -= 1;
                @endphp

            @else
            </div> {{-- end page --}}
                @if($loop->last)
                @else
                <div class="page-break"></div>
                @endif
                @php $j = 1; @endphp
            @endif
        @endif
        @endforeach {{-- endforeach event-img --}}
    @endisset
    <div class="page-break"></div>

</body>
</html>