<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{public_path('css/pdf_css.css') }}" rel="stylesheet" media="screen">
</head>

<body>

    <div class="page">
        <div class="event-img-block">
            <p class="block-title">Image</p>
        </div>
        <div class="event-img-block">
            <div class="img-block">
                <img src="{{ public_path('/storage/'.$file['file']) }}">
            </div>
            <div class="info-block">
                <p class="block-desc">{{ $file['caption'] }}</p>
            </div>
        </div>
    </div>

</body>
</html>