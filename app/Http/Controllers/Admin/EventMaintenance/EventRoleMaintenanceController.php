<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

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
};

use App\Http\Controllers\Controller as Controller;

class EventRoleMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.eventRole.';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $eventRoles = EventRole::all();
        return view($this->viewDirectory . 'index', compact('eventRoles',));
    }
    
    public function create()
    {
        return view($this->viewDirectory . 'create',);
    }

    public function store(EventRoleStoreRequest $request)
    {
        $message = (new EventRoleStoreService())->store($request);

        return redirect()->action(
            [EventRoleMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($role_id)
    {
        $eventRole = $this->checkIfRoleExists($role_id);

        return view($this->viewDirectory . 'edit', compact('eventRole'));
    }

    public function update(EventRoleUpdateRequest $request, $role_id)
    {
        $eventRole = $this->checkIfRoleExists($role_id);

        $message = (new EventRoleUpdateService())->update($eventRole, $request);

        return redirect()->action(
            [EventRoleMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($role_id)
    {
        $eventRole = $this->checkIfRoleExists($role_id);
        
        return view($this->viewDirectory . 'show', compact('eventRole'));
    }

    public function destroy(EventRoleDeleteRequest $request, $role_id)
    {
        $eventRole = $this->checkIfRoleExists($role_id);

        $message = (new EventRoleDeleteService())->delete($eventRole, $request);

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
        abort_if(! $eventRole = EventRole::where('event_role_id', $role_id)->first(), 404);

        return $eventRole;
    }
}
