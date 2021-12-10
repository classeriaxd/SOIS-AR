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
                        {{-- Image Type > 0 = Poster | 1 = Evidence --}}

                        <div class="event-img-block">
                            @if($eventImage['image_type'] == 0)
                                <div class="img-block-poster">
                                    <img class="img-poster" src="{{ public_path('/storage/'. $eventImage['image']) }}"
                                    style="
                                        min-height: auto;
                                        min-width: auto;
                                        max-height: 676px;
                                        max-width: 480px;
                                        border: 1px solid black;
                                    ">
                                    {{-- Inline CSS cause idk why pdf_css.css doesnt apply :) --}}
                                </div>
                            @elseif($eventImage['image_type'] == 1)
                                <div class="img-block-evidence">
                                    <img class="img-evidence" src="{{ public_path('/storage/'. $eventImage['image']) }}"
                                    style="
                                        min-height: auto;
                                        min-width: auto;
                                        max-height: 480px;
                                        max-width: 676px;
                                        border: 1px solid black;
                                    ">
                                    {{-- Inline CSS cause idk why pdf_css.css doesnt apply :) --}}
                                </div>
                            @endif
                            
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