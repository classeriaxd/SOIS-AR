<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

use Illuminate\Support\Facades\Auth;

use App\Models\EventRole;

use App\Http\Requests\Admin\EventMaintenance\EventRole\{
    EventRoleStoreRequest,
    EventRoleUpdateRequest,
    EventRoleDeleteRequest,
};
use App\Services\Admin\EventMaintenance\EventRole\{
    EventRoleStoreService,
    EventRoleUpdateService,
    EventRoleDeleteService,
    EventRoleRestoreService,
};

use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\DataLogServices\DataLogService;

use App\Http\Controllers\Controller as Controller;

class EventRoleMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.eventRole.';
    protected $permissionChecker;
    protected $dataLogger;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->permissionChecker = new PermissionCheckingService();
        $this->dataLogger = new DataLogService();
    }

    public function index()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventRoles = EventRole::all();
        $deletedEventRoles = EventRole::onlyTrashed()->get();
        return view($this->viewDirectory . 'index', compact('eventRoles','deletedEventRoles'));
    }
    
    public function create()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        return view($this->viewDirectory . 'create',);
    }

    public function store(EventRoleStoreRequest $request)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $message = (new EventRoleStoreService())->store($request);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Created an Event Role.');

        return redirect()->action(
            [EventRoleMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($role_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventRole = $this->checkIfRoleExists($role_id);

        return view($this->viewDirectory . 'edit', compact('eventRole'));
    }

    public function update(EventRoleUpdateRequest $request, $role_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventRole = $this->checkIfRoleExists($role_id);

        $message = (new EventRoleUpdateService())->update($eventRole, $request);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Updated an Event Role.');

        return redirect()->action(
            [EventRoleMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($role_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventRole = $this->checkIfRoleExists($role_id);
        
        return view($this->viewDirectory . 'show', compact('eventRole'));
    }

    public function destroy(EventRoleDeleteRequest $request, $role_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventRole = $this->checkIfRoleExists($role_id);

        $message = (new EventRoleDeleteService())->delete($eventRole, $request);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Deleted an Event Role.');

        return redirect()->action(
            [EventRoleMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function restore($role_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventRole = $this->checkIfRoleExists($role_id);

        $message = (new EventRoleRestoreService())->restore($eventRole);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Restored an Event Role.');

        return redirect()->action(
            [EventRoleMaintenanceController::class, 'index'])
            ->with($message);
    }

    /**
     * @param Integer $role_id
     * Function to check if a category id exists, sends 404 if not
     * @return Collection
     */ 
    private function checkIfRoleExists($role_id)
    {
        abort_if(! $eventRole = EventRole::withTrashed()->where('event_role_id', $role_id)->first(), 404);

        return $eventRole;
    }
}
