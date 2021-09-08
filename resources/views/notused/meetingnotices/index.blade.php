@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

@php
$currentYear = 0; $currentMonth = 0; $yearStart = 1; $monthStart = 1; $monthEnd = true;
foreach ($notices as $notice):
    $cDate = strtotime($notice->creation_date); $cMonth = date('m', $cDate); $cYear = date('Y', $cDate);
    if ($currentYear != $cYear):
        $currentYear = $cYear;
        if (($monthEnd) == false):
            $monthEnd = true;
            $monthStart = 1;
@endphp
                                        </div>
                                    </div>
                                </div>
                            </div>
@php            
        endif;
        if ($yearStart != 1):
@endphp
                        </div>
                    </div>
                </div>
            </div>
@php
        else:
            $yearStart--;
        endif;
@endphp
            <div class="pb-2">
                <div class="card">
                    <div class="card-header text-center align-middle">
                        <div class="display-5">{{ $currentYear }}</div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
@php
    endif;
    if ($currentMonth != $cMonth):
        $currentMonth = $cMonth;
        if ($monthStart != 1):
@endphp
                                        </div>
                                    </div>
                                </div>
                            </div>
@php
        else:
            $monthStart--;
        endif;
@endphp
                            <div class="col-md-4 pb-2">
                                <div class="card">
                                    <div class="card-header text-center align-middle">
                                        <div class="display-6">{{date('F', mktime(0,0,0,$cMonth+1,0,0))}}</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center">

@php
    $monthEnd = false;
    endif;//Current Month End
@endphp
                                            <a href="/n/{{ $notice->notice_uuid }}">
                                                <button class="btn btn-primary m-1" id="{{'btn-event-'.$notice->meetingnotice_id}}">{{$notice->for.' - '.$notice->meeting_date}}</button>
                                            </a>
@php
endforeach;
@endphp
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <a href="/home">
            <button class="btn btn-secondary">Go back</button>
        </a>
    </div>
</div>
@endsection
