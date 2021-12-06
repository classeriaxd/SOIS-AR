<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{public_path('css/pdf_css.css') }}" rel="stylesheet" media="screen">
</head>

<body>
    <div class="page">
        <div class="event-prep-block vertical-center">
            <div class="prep-presented">
                <p class="prep-text">Presented by:</p>
                <p class="prep-org">{{$organization->organization_name}}<br>CENTRAL BODY</p>
            </div>
            <br>

            {{-- Prepared by: --}}
            <div class="prep-prepared">
                @if($documentationSignatory->isNotEmpty())
                <p class="prep-text">Prepared by:</p>
                    @foreach($documentationSignatory as $signatory)

                        {{-- Signature --}}
                        @if($signature)
                            @if($signatory->signature !== NULL)
                                <img src="{{ public_path('/storage/'. $signatory->signature) }}" class="prep-signature">
                            @else
                                <p class="prep-signature"></p>
                            @endif
                        @else
                             <p class="prep-signature"></p>
                        @endif
                        
                        {{-- Details --}}
                        <p class="prep-officer">{{ $signatory->full_name }}</p>
                        <p class="prep-officer-title">{{ $organization->organization_acronym . ' ' . $signatory->positionTitle->position_title }}</p>
                    @endforeach
                @endif
            </div>

            <br>

            {{-- Approved by: --}}
            <div class="prep-approved">
                @if($presidentSignatory->isNotEmpty())
                <p class="prep-text">Approved by:</p>
                {{-- Signature --}}
                    @if($signature)
                        @if($presidentSignatory->signature !== NULL)
                            <img src="{{ public_path('/storage/'. $presidentSignatory->signature) }}" class="prep-signature">
                        @else
                            <p class="prep-signature"></p>
                        @endif                  
                    @else
                        <p class="prep-signature"></p>
                    @endif

                {{-- Details --}}
                <p class="prep-officer">{{ $presidentSignatory->full_name }}</p>
                <p class="prep-officer-title">{{ $organization->organization_acronym . ' ' . $presidentSignatory->positionTitle->position_title }}</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
