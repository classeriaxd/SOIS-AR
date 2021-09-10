<?php

namespace App\Http\Controllers;

use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class NotificationsController extends Controller
{
    public function show()
    {
        if(Auth::check() && $user = Auth::user())
        {
            $allNotifications = Notification::where('user_id', $user->user_id)
                ->orderBy('created_at', 'DESC')
                ->orderBy('read_at', 'ASC')
                ->paginate(5);
            return view('notifications.show', compact('allNotifications'));
        }
    }
    public function markAllAsRead()
    {
        if(Auth::check() && $user = Auth::user())
        {
            $allUnreadNotifications = Notification::where('user_id', $user->user_id)
                ->whereNull('read_at')
                ->get();
            foreach($allUnreadNotifications as $notification)
            {
                $data = ['read_at' => Carbon::now(),];
                $notification->update($data);
            }
            return redirect()->action(
                [NotificationsController::class, 'show']);
        }
    }
    public function markAsRead($notification_id)
    {
        if($notification = Notification::where('notification_id', $notification_id)->first())
        {
            $data = ['read_at' => Carbon::now(),];
            $notification->update($data);
        }
        else
            abort(404);
    }
}
