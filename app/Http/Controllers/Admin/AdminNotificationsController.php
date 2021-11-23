<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Notification;
use App\Models\Organization;

use App\Http\Requests\Admin\NotificationStoreRequest
;
use App\Services\Admin\NotificationStoreService;
use Carbon\Carbon;

use App\Http\Controllers\Controller as Controller;

class AdminNotificationsController extends Controller
{
    protected $viewDirectory = 'admin.notifications.';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $organizations = Organization::select('organization_id', 'organization_acronym', 'organization_name')
            ->orderBy('organization_type_id', 'ASC')
            ->orderBy('organization_name', 'ASC')
            ->get();

        return view($this->viewDirectory . 'create', compact('organizations'));
    }

    public function store(NotificationStoreRequest $request)
    {
        $message = (new NotificationStoreService())->store($request);

        return redirect()->action(
            [AdminNotificationsController::class, 'index'])
            ->with($message);
    }
    public function index()
    {
        $allNotifications = Notification::where('user_id', Auth::user()->user_id)
            ->orderBy('created_at', 'DESC')
            ->orderBy('read_at', 'ASC')
            ->paginate(5);

        return view($this->viewDirectory . 'index', compact('allNotifications'));
       
    }

    public function markAllAsRead()
    {
        
        $allUnreadNotifications = Notification::where('user_id', Auth::user()->user_id)
            ->whereNull('read_at')
            ->get();
        foreach($allUnreadNotifications as $notification)
        {
            $data = ['read_at' => Carbon::now(),];
            $notification->update($data);
        }
        return redirect()->action(
            [AdminNotificationsController::class, 'index']);
       
    }

    // Vue Function: AdminReadNotification Component
    public function markAsRead($notification_id)
    {
        abort_if(($notification = Notification::where('notification_id', $notification_id)->first()) !== NULL ? false : true, 404);
        
        $data = ['read_at' => Carbon::now(),];
        $notification->update($data);
        
    }

}
