<?php

namespace App\Http\Controllers\Admin\AccomplishmentReportMaintenance;

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
};

use App\Http\Controllers\Controller as Controller;

class TabularTableMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.accomplishmentReport.tabularTable.';

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
        $tabularTables = TabularTable::all();
        return view($this->viewDirectory . 'index', compact('tabularTables',));
    }
    
    public function create()
    {
        return view($this->viewDirectory . 'create',);
    }

    public function store(TabularTableStoreRequest $request)
    {
        $message = (new TabularTableStoreService())->store($request);

        return redirect()->action(
            [TabularTableMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($tabular_table_id)
    {
        $tabularTable = $this->checkIfTabularTableExists($tabular_table_id);

        return view($this->viewDirectory . 'edit', compact('tabularTable'));
    }

    public function update(TabularTableUpdateRequest $request, $tabular_table_id)
    {
        $tabularTable = $this->checkIfTabularTableExists($tabular_table_id);

        $message = (new TabularTableUpdateService())->update($tabularTable, $request);

        return redirect()->action(
            [TabularTableMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($tabular_table_id)
    {
        $tabularTable = $this->checkIfTabularTableExists($tabular_table_id);

        $tabularColumns = TabularColumn::where('tabular_table_id', $tabular_table_id)->get();
        return view($this->viewDirectory . 'show', compact('tabularTable', 'tabularColumns'));
    }

    public function destroy(TabularTableDeleteRequest $request, $tabular_table_id)
    {
        $tabularTable = $this->checkIfTabularTableExists($tabular_table_id);

        $message = (new TabularTableDeleteService())->delete($tabularTable, $request);

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
        abort_if(! $tabularTable = TabularTable::where('tabular_table_id', $tabular_table_id)->first(), 404);

        return $tabularTable;
    }
}
