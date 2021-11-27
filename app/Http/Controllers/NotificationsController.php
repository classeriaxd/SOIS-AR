<?php

namespace App\Http\Controllers;

use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Services\PermissionServices\PermissionCheckingService;

class NotificationsController extends Controller
{
    protected $permissionChecker;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->permissionChecker = new PermissionCheckingService();
    }

    public function show()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Notification'), 403);
       
        $allNotifications = Notification::where('user_id', Auth::user()->user_id)
            ->orderBy('created_at', 'DESC')
            ->orderBy('read_at', 'ASC')
            ->paginate(10);

        return view('notifications.show', compact('allNotifications'));
    }
    
    public function markAllAsRead()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Read_Notification'), 403);

        $allUnreadNotifications = Notification::where('user_id', Auth::user()->user_id)
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

    public function markAsRead($notification_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Read_Notification'), 403);
        abort_if(! Notification::where('notification_id', $notification_id)->exists(), 404);

        $notification = Notification::where('notification_id', $notification_id)->first();
        $data = ['read_at' => Carbon::now(),];
        $notification->update($data);
    }
}
