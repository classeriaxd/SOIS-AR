@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
    		<h2 class="display-2 text-center">Notifications</h2>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-8">
                    <div class="row mb-2">
                        <div class="col  text-center">
                            <form method="POST" action="{{route('notifications.markAllAsRead')}}">
                                <button type="submit" class="btn btn-primary">Mark all as Read</button>
                                @csrf
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header card-title text-center" id="notification-header">All Notifications</h5>
                        <div class="card-body">
                        <div class="row justify-content-center">
                            {{ $allNotifications->links() }}
                        </div>
                        @if($allNotifications->count() > 0)
                        @foreach($allNotifications as $notification)
                            <a href="
                                    @if($notification->type == 3)
                                        {{-- Student Accomplishments --}}
                                        {{route('student_accomplishment.show', ['accomplishmentUUID' => $notification->link])}}
                                    @elseif($notification->type == 4)
                                        {{-- Accomplishment Reports --}}
                                        {{route('accomplishmentReport.show', ['accomplishmentReportUUID' => $notification->link])}}
                                    @endif" 
                                class="text-dark ">
                                <div class="row m-2 p-1 border border-dark">
                                    <div class="col">
                                        <h5 class="text-center font-weight-bold">
                                            {{$notification->title}}
                                            @if($notification->read_at == NULL)
                                            <span class="badge badge-pill badge-primary">New</span>
                                            @endif
                                        </h5>
                                        <p class="text-center">{{$notification->description}}</p>
                                        <p class="text-center">{{date_format(date_create($notification->created_at), 'F d, Y - h:i A')}}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        <div class="row justify-content-center">
                            {{ $allNotifications->links() }}
                        </div>
                        @else
                            <h6 class="text-center">No notifications found!</h6>
                        @endif
                        </div>
                    </div>
        		</div>
        	</div>
        	<hr>
        	<div class="row justify-content-center pt-1">
        		<a href="/home">
        			<button class="btn btn-secondary">Go back</button>
        		</a>
        	</div>
        </div>
    </div>
</div>
@endsection
