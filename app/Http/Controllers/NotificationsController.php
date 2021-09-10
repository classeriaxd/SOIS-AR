<?php

namespace App\Http\Controllers;

use App\Models\Notification;

use Illuminate\Http\Request;

use Carbon\Carbon;

class NotificationsController extends Controller
{
    public function markAsRead($notification_id)
    {
        if($notification = Notification::where('notification_id', $notification_id)->first())
        {
            $data = [
                'read_at' => Carbon::now(),
            ];
            $notification->update($data);
        }
        else
            abort(404);
    }
}
