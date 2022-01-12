<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

use Illuminate\Support\Facades\Auth;

use App\Models\FundSource;

use App\Http\Requests\Admin\EventMaintenance\FundSource\{
    FundSourceStoreRequest,
    FundSourceUpdateRequest,
    FundSourceDeleteRequest,
};
use App\Services\Admin\EventMaintenance\FundSource\{
    FundSourceStoreService,
    FundSourceUpdateService,
    FundSourceDeleteService,
    FundSourceRestoreService,
};

use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\DataLogServices\DataLogService;

use App\Http\Controllers\Controller as Controller;

class FundSourceMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.fundSource.';
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
        $fundSources = FundSource::all();
        $deletedFundSources = FundSource::onlyTrashed()->get();
        return view($this->viewDirectory . 'index', compact('fundSources','deletedFundSources'));
    }
    
    public function create()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        return view($this->viewDirectory . 'create',);
    }

    public function store(FundSourceStoreRequest $request)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $message = (new FundSourceStoreService())->store($request);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Created an Event Fund Source.');

        return redirect()->action(
            [FundSourceMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($fund_source_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $fundSource = $this->checkIfFundSourceExists($fund_source_id);

        return view($this->viewDirectory . 'edit', compact('fundSource'));
    }

    public function update(FundSourceUpdateRequest $request, $fund_source_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $fundSource = $this->checkIfFundSourceExists($fund_source_id);

        $message = (new FundSourceUpdateService())->update($fundSource, $request);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Updated an Event Fund Source.');

        return redirect()->action(
            [FundSourceMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($fund_source_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $fundSource = $this->checkIfFundSourceExists($fund_source_id);
        
        return view($this->viewDirectory . 'show', compact('fundSource'));
    }

    public function destroy(FundSourceDeleteRequest $request, $fund_source_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $fundSource = $this->checkIfFundSourceExists($fund_source_id);

        $message = (new FundSourceDeleteService())->delete($fundSource, $request);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Deleted an Event Fund Source.');

        return redirect()->action(
            [FundSourceMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function restore($fund_source_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $fundSource = $this->checkIfFundSourceExists($fund_source_id);

        $message = (new FundSourceRestoreService())->restore($fundSource);

        $this->dataLogger->log(Auth::user()->user_id, 'Super Admin Restored an Event Fund Source.');

        return redirect()->action(
            [FundSourceMaintenanceController::class, 'index'])
            ->with($message);
    }

    /**
     * @param Integer $fund_source_id
     * Function to check if a fund source id exists, sends 404 if not
     * @return Collection
     */ 
    private function checkIfFundSourceExists($fund_source_id)
    {
        abort_if(! $fundSource = FundSource::withTrashed()->where('fund_source_id', $fund_source_id)->first(), 404);

        return $fundSource;
    }
}
