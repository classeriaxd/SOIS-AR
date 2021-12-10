<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

use App\Models\Level;
use App\Http\Requests\Admin\EventMaintenance\Level\{
    LevelStoreRequest,
    LevelUpdateRequest,
    LevelDeleteRequest,
};
use App\Services\Admin\EventMaintenance\Level\{
    LevelStoreService,
    LevelUpdateService,
    LevelDeleteService,
    LevelRestoreService,
};
use App\Services\PermissionServices\PermissionCheckingService;

use App\Http\Controllers\Controller as Controller;

class LevelMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.level.';
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

    public function index()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $levels = Level::all();
        $deletedLevels = Level::onlyTrashed()->get();
        return view($this->viewDirectory . 'index', compact('levels','deletedLevels'));
    }
    
    public function create()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        return view($this->viewDirectory . 'create',);
    }

    public function store(LevelStoreRequest $request)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $message = (new LevelStoreService())->store($request);

        return redirect()->action(
            [LevelMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($level_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $level = $this->checkIfLevelExists($level_id);

        return view($this->viewDirectory . 'edit', compact('level'));
    }

    public function update(LevelUpdateRequest $request, $level_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $level = $this->checkIfLevelExists($level_id);

        $message = (new LevelUpdateService())->update($level, $request);

        return redirect()->action(
            [LevelMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($level_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $level = $this->checkIfLevelExists($level_id);
        
        return view($this->viewDirectory . 'show', compact('level'));
    }

    public function destroy(LevelDeleteRequest $request, $level_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $level = $this->checkIfLevelExists($level_id);

        $message = (new LevelDeleteService())->delete($level, $request);

        return redirect()->action(
            [LevelMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function restore($level_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $level = $this->checkIfLevelExists($level_id);

        $message = (new LevelRestoreService())->restore($level);

        return redirect()->action(
            [LevelMaintenanceController::class, 'index'])
            ->with($message);
    }

    /**
     * @param Integer $level_id
     * Function to check if a level id exists, sends 404 if not
     * @return Collection
     */ 
    private function checkIfLevelExists($level_id)
    {
        abort_if(! $level = Level::withTrashed()->where('level_id', $level_id)->first(), 404);

        return $level;
    }
}
