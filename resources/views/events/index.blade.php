@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

@php
$currentYear = 0; $currentMonth = 0; $yearStart = 1; $monthStart = 1; $monthEnd = true;
foreach ($events as $event):
    $eventDate = strtotime($event->date); $eventMonth = date('m', $eventDate); $eventYear = date('Y', $eventDate);
    if ($currentYear != $eventYear):
        $currentYear = $eventYear;
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
    if ($currentMonth != $eventMonth):
        $currentMonth = $eventMonth;
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
                                        <div class="display-6">{{date('F', mktime(0,0,0,$eventMonth+1,0,0))}}</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center">

@php
    $monthEnd = false;
    endif;//Current Month End
@endphp
                                            <a href="/e/{{ $event->id }}">
                                                <button class="btn btn-primary m-1">{{$event->title}}</button>
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
</div>
@endsection
