@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h2 class="display-2 text-center">Notifications</h2>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Notifications
                        </li>
                    </ol>
                </nav>
            </div>
        	<div class="row justify-content-center pb-1">
        		<div class="col-md-8">
                    
                    <div class="card">
                        <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">All Notifications</h5>
                        <div class="card-body">
                        @if($allNotifications->isNotEmpty())
                        <div class="row mb-2">
                            <div class="col text-center">
                                <form method="POST" action="{{route('notifications.markAllAsRead')}}">
                                    <button type="submit" class="btn btn-primary text-white">Mark all as Read</button>
                                    @csrf
                                </form>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            {{ $allNotifications->links() }}
                        </div>
                        
                        @foreach($allNotifications as $notification)
                            <a href="
                                    @if($notification->type == 3)
                                        {{-- Student Accomplishments --}}
                                        {{route('studentAccomplishment.show', ['accomplishmentUUID' => $notification->link])}}
                                    @elseif($notification->type == 4)
                                        {{-- Accomplishment Reports --}}
                                        {{route('accomplishmentReport.show', ['accomplishmentReportUUID' => $notification->link])}}
                                    @else
                                        #
                                    @endif" 
                            class="text-decoration-none text-dark">
                                <div class="row m-2 p-1 border border-dark">
                                    <div class="col">
                                        <h5 class="text-center font-weight-bold">
                                            {{$notification->title}}
                                            @if($notification->read_at == NULL)
                                            <span class="badge rounded-pill bg-primary text-white">New</span>
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

        	<div class="flex-row my-2 text-center">
                    <a href="{{route('home')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        Go Home
                    </a>
            </div>
        </div>
    </div>
</div>
@endsection
