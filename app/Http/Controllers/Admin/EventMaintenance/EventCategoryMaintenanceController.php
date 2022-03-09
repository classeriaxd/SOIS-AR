<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

use Illuminate\Support\Facades\Auth;

use App\Models\EventCategory;

use App\Http\Requests\Admin\EventMaintenance\EventCategory\{
    EventCategoryStoreRequest,
    EventCategoryUpdateRequest,
    EventCategoryDeleteRequest,
};
use App\Services\Admin\EventMaintenance\EventCategory\{
    EventCategoryStoreService,
    EventCategoryUpdateService,
    EventCategoryDeleteService,
    EventCategoryRestoreService,
};
use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\DataLogServices\DataLogService;

use App\Http\Controllers\Controller as Controller;

class EventCategoryMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.eventCategory.';
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
        $eventCategories = EventCategory::all();
        $deletedEventCategories = EventCategory::onlyTrashed()->get();
        
        return view($this->viewDirectory . 'index', compact('eventCategories','deletedEventCategories'));
    }
    
    public function create()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        return view($this->viewDirectory . 'create',);
    }

    public function store(EventCategoryStoreRequest $request)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $message = (new EventCategoryStoreService())->store($request);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Created an Event Category.');
        
        return redirect()->action(
            [EventCategoryMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($category_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventCategory = $this->checkIfCategoryExists($category_id);

        return view($this->viewDirectory . 'edit', compact('eventCategory'));
    }

    public function update(EventCategoryUpdateRequest $request, $category_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventCategory = $this->checkIfCategoryExists($category_id);

        $message = (new EventCategoryUpdateService())->update($eventCategory, $request);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Updated an Event Category.');

        return redirect()->action(
            [EventCategoryMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($category_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventCategory = $this->checkIfCategoryExists($category_id);
        
        return view($this->viewDirectory . 'show', compact('eventCategory'));
    }

    public function destroy(EventCategoryDeleteRequest $request, $category_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventCategory = $this->checkIfCategoryExists($category_id);

        $message = (new EventCategoryDeleteService())->delete($eventCategory, $request);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Deleted an Event Category.');

        return redirect()->action(
            [EventCategoryMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function restore($category_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $eventCategory = $this->checkIfCategoryExists($category_id);

        $message = (new EventCategoryRestoreService())->restore($eventCategory);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Restored an Event Category.');

        return redirect()->action(
            [EventCategoryMaintenanceController::class, 'index'])
            ->with($message);

    }

    /**
     * @param Integer $category_id
     * Function to check if a category id exists, sends 404 if not
     * @return Collection
     */ 
    private function checkIfCategoryExists($category_id)
    {
        abort_if(! $eventCategory = EventCategory::withTrashed()->where('event_category_id', $category_id)->first(), 404);

        return $eventCategory;
    }
}
