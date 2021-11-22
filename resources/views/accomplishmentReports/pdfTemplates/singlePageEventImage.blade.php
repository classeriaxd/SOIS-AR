<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{public_path('css/pdf_css.css') }}" rel="stylesheet" media="screen">
</head>

<body>

    {{-- Event Images --}}
    @isset($event['event_images'])
        @if($event['event_images'] != NULL)
            @foreach($event['event_images'] as $eventImage)

                <div class="page">
                    <div class="vertical-center">
                        {{-- Title --}}
                        @if($loop->first)
                            <div class="event-img-block">
                                <p class="block-title">Event Images</p>
                            </div>
                        @endif

                        {{-- Image --}}
                        <div class="event-img-block">
                            <div class="img-block">
                                <img src="{{ public_path('/storage/'. $eventImage['image']) }}">
                            </div>
                            <div class="info-block">
                                <p class="block-desc">{{ $eventImage['caption'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- If not Last Page --}}
                @if(!($loop->last))
                    <div class="page-break"></div>
                @endif

            @endforeach 
        @endif
    @endisset

</body>
</html>