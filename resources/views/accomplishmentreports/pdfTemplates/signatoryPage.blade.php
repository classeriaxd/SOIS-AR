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
            <div class="prep-prepared">
                <p class="prep-text">Prepared by:</p>
                @foreach($documentationSignatory as $signatory)
                    @foreach($signatory->users as $user)
                        @if($user->count() > 0)
                @if($signature)                    
                <p class="prep-signature">signature</p>
                @else
                <p class="prep-signature">&nbsp;</p>
                @endif
                <p class="prep-officer">{{ $user->full_name }}</p>
                <p class="prep-officer-title">{{ $organization->organization_acronym . $signatory->position_title }}</p>
                        @endif
                    @endforeach
                @endforeach

            </div>
            <br>
            <div class="prep-approved">
                <p class="prep-text">Approved by:</p>
                @foreach($presidentSignatory->users as $user)
                    @if($user->count() > 0)
                @if($signature)                    
                <p class="prep-signature">signature</p>
                @else
                <p class="prep-signature">&nbsp;</p>
                @endif
                <p class="prep-officer">{{ $user->full_name }}</p>
                <p class="prep-officer-title">{{ $organization->organization_acronym . $signatory->position_title }}</p>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>