<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

use Illuminate\Support\Facades\Auth;

use App\Models\EventNature;

use App\Http\Requests\Admin\EventMaintenance\EventNature\{
    EventNatureStoreRequest,
    EventNatureUpdateRequest,
    EventNatureDeleteRequest,
};
use App\Services\Admin\EventMaintenance\EventNature\{
    EventNatureStoreService,
    EventNatureUpdateService,
    EventNatureDeleteService,
    EventNatureRestoreService,
};

use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\DataLogServices\DataLogService;

use App\Http\Controllers\Controller as Controller;

class EventNatureMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.eventNature.';
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
        $eventNatures = EventNature::all();
        $deletedEventNatures = EventNature::onlyTrashed()->get();
        return view($this->viewDirectory . 'index', compact('eventNatures','deletedEventNatures'));
    }
    
    public function create()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        return view($this->viewDirectory . 'create',);
    }

    public function store(EventNatureStoreRequest $request)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);

        $message = (new EventNatureStoreService())->store($request);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Created an Event Nature.');

        return redirect()->action(
            [EventNatureMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($nature_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventNature = $this->checkIfNatureExists($nature_id);

        return view($this->viewDirectory . 'edit', compact('eventNature'));
    }

    public function update(EventNatureUpdateRequest $request, $nature_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventNature = $this->checkIfNatureExists($nature_id);

        $message = (new EventNatureUpdateService())->update($eventNature, $request);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Updated an Event Nature.');

        return redirect()->action(
            [EventNatureMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($nature_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventNature = $this->checkIfNatureExists($nature_id);
        
        return view($this->viewDirectory . 'show', compact('eventNature'));
    }

    public function destroy(EventNatureDeleteRequest $request, $nature_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventNature = $this->checkIfNatureExists($nature_id);

        $message = (new EventNatureDeleteService())->delete($eventNature, $request);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Deleted an Event Nature.');

        return redirect()->action(
            [EventNatureMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function restore($nature_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventNature = $this->checkIfNatureExists($nature_id);

        $message = (new EventNatureRestoreService())->restore($eventNature);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Restored an Event Nature.');

        return redirect()->action(
            [EventNatureMaintenanceController::class, 'index'])
            ->with($message);

    }

    /**
     * @param Integer $nature_id
     * Function to check if a nature id exists, sends 404 if not
     * @return Collection
     */ 
    private function checkIfNatureExists($nature_id)
    {
        abort_if(! $eventNature = EventNature::withTrashed()->where('event_nature_id', $nature_id)->first(), 404);

        return $eventNature;
    }
}
