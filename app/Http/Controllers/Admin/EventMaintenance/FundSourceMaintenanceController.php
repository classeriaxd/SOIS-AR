<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

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
};
use App\Services\PermissionServices\PermissionCheckingService;

use App\Http\Controllers\Controller as Controller;

class FundSourceMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.fundSource.';
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
        $fundSources = FundSource::all();
        return view($this->viewDirectory . 'index', compact('fundSources',));
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
        abort_if(! $fundSource = FundSource::where('fund_source_id', $fund_source_id)->first(), 404);

        return $fundSource;
    }
}
