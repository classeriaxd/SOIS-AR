<?php

namespace App\Http\Controllers\Admin\AccomplishmentReportMaintenance;

use Illuminate\Support\Facades\Auth;

use App\Models\TabularTable;
use App\Models\TabularColumn;

use App\Http\Requests\Admin\AccomplishmentReportMaintenance\TabularTable\{
    TabularTableStoreRequest,
    TabularTableUpdateRequest,
    TabularTableDeleteRequest,
};
use App\Services\Admin\AccomplishmentReportMaintenance\TabularTable\{
    TabularTableStoreService,
    TabularTableUpdateService,
    TabularTableDeleteService,
    TabularTableRestoreService,
};

use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\DataLogServices\DataLogService;

use App\Http\Controllers\Controller as Controller;

class TabularTableMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.accomplishmentReport.tabularTable.';
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
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        $tabularTables = TabularTable::all();
        $deletedTabularTables = TabularTable::onlyTrashed()->get();
        return view($this->viewDirectory . 'index', compact('tabularTables','deletedTabularTables'));
    }
    
    public function create()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        return view($this->viewDirectory . 'create',);
    }

    public function store(TabularTableStoreRequest $request)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        $message = (new TabularTableStoreService())->store($request);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Created a Tabular AR Table.');

        return redirect()->action(
            [TabularTableMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($tabular_table_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        $tabularTable = $this->checkIfTabularTableExists($tabular_table_id);

        return view($this->viewDirectory . 'edit', compact('tabularTable'));
    }

    public function update(TabularTableUpdateRequest $request, $tabular_table_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        $tabularTable = $this->checkIfTabularTableExists($tabular_table_id);

        $message = (new TabularTableUpdateService())->update($tabularTable, $request);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Updated a Tabular AR Table.');

        return redirect()->action(
            [TabularTableMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($tabular_table_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        $tabularTable = $this->checkIfTabularTableExists($tabular_table_id);

        $tabularColumns = TabularColumn::where('tabular_table_id', $tabular_table_id)->get();
        $deletedTabularColumns = TabularColumn::onlyTrashed()->where('tabular_table_id', $tabular_table_id)->get();
        
        return view($this->viewDirectory . 'show', compact('tabularTable', 'tabularColumns', 'deletedTabularColumns'));
    }

    public function destroy(TabularTableDeleteRequest $request, $tabular_table_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        $tabularTable = $this->checkIfTabularTableExists($tabular_table_id);

        $message = (new TabularTableDeleteService())->delete($tabularTable, $request);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Admin Deleted a Tabular AR Table.');

        return redirect()->action(
            [TabularTableMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function restore($tabular_table_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        $tabularTable = $this->checkIfTabularTableExists($tabular_table_id);

        $message = (new TabularTableRestoreService())->restore($tabularTable);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Restored a Tabular AR Table.');

        return redirect()->action(
            [TabularTableMaintenanceController::class, 'index'])
            ->with($message);
    }

    /**
     * @param Integer $tabular_table_id
     * Function to check if a tabular table id exists, sends 404 if not
     * @return Collection
     */ 
    private function checkIfTabularTableExists($tabular_table_id)
    {
        abort_if(! $tabularTable = TabularTable::withTrashed()->where('tabular_table_id', $tabular_table_id)->first(), 404);

        return $tabularTable;
    }
}
