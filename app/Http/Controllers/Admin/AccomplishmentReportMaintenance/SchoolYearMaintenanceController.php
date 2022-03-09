<?php

namespace App\Http\Controllers\Admin\AccomplishmentReportMaintenance;

use Illuminate\Support\Facades\Auth;

use App\Models\SchoolYear;

use App\Http\Requests\Admin\AccomplishmentReportMaintenance\SchoolYear\{
    SchoolYearStoreRequest,
    SchoolYearUpdateRequest,
};
use App\Services\Admin\AccomplishmentReportMaintenance\SchoolYear\{
    SchoolYearStoreService,
    SchoolYearUpdateService,
};

use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\DataLogServices\DataLogService;

use App\Http\Controllers\Controller as Controller;

class SchoolYearMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.accomplishmentReport.schoolYear.';
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
        $schoolYears = SchoolYear::orderBy('year_start', 'DESC')->get();
        return view($this->viewDirectory . 'index', compact('schoolYears'));
    }
    
    public function create()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        return view($this->viewDirectory . 'create',);
    }

    public function store(SchoolYearStoreRequest $request)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);

        $message = (new SchoolYearStoreService())->store($request);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Added a School Year.');

        return redirect()->action(
            [SchoolYearMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($school_year_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        $schoolYear = $this->checkIfSchoolYearExists($school_year_id);

        return view($this->viewDirectory . 'edit', compact('schoolYear'));
    }

    public function update(SchoolYearUpdateRequest $request, $school_year_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        $schoolYear = $this->checkIfSchoolYearExists($school_year_id);

        $message = (new SchoolYearUpdateService())->update($schoolYear, $request);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Updated a School Year');

        return redirect()->action(
            [SchoolYearMaintenanceController::class, 'index'])
            ->with($message);
    }

    /**
     * @param Integer $school_year_id
     * Function to check if a school year id exists, sends 404 if not
     * @return Collection
     */ 
    private function checkIfSchoolYearExists($school_year_id)
    {
        abort_if(! $schoolYear = SchoolYear::where('school_year_id', $school_year_id)->first(), 404);

        return $schoolYear;
    }
}
