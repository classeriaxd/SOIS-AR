<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AccomplishmentReport;
use App\Models\Event;
use App\Models\Organization;

use Carbon\Carbon;

use App\Services\PermissionServices\PermissionCheckingService;
use App\Http\Controllers\Controller as Controller;

class AdminAccomplishmentReportsController extends Controller
{
    protected $viewDirectory = 'admin.accomplishmentReports.';
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
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        $accomplishmentReports = AccomplishmentReport::with(
                'accomplishmentReportType',
                'organization:organization_id,organization_acronym,organization_slug')
            ->orderBy('created_at', 'DESC')
            ->paginate(30);

        $organizations = Organization::with('logos:organization_id,file')
            ->orderBy('organization_type_id', 'ASC')
            ->get();

        return view($this->viewDirectory . 'index', 
            compact(
                'accomplishmentReports',
                'organizations',
            ));
        
    }
    public function organizationIndex($organizationSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        abort_if(($organization = Organization::where('organization_slug', $organizationSlug)->select('organization_id', 'organization_acronym')->first()) !== NULL ? false : true, 404);

        $organizationLogo = $organization->logo->file;

        $accomplishmentReports = AccomplishmentReport::with(
                'accomplishmentReportType',
                'organization:organization_id,organization_acronym,organization_slug')
            ->orderBy('read_at', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->where('organization_id', $organization->organization_id)
            ->paginate(30);

        return view($this->viewDirectory . 'organizationIndex', 
            compact(
                'accomplishmentReports',
                'organization',
                'organizationLogo',
            ));
    }
    public function show($organizationSlug, $accomplishmentReportUUID)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        abort_if(($organization_id = Organization::where('organization_slug', $organizationSlug)->value('organization_id')) !== NULL ? false : true, 404);
        abort_if(! AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->where('organization_id', $organization_id)->exists(), 404);
        
        $accomplishmentReport = AccomplishmentReport::with(
                'accomplishmentReportType',
                'creator',
                'reviewer',
                'organization:organization_id,organization_acronym,organization_slug',
                'organization.logo:organization_id,file',)
            ->where('accomplishment_report_uuid', $accomplishmentReportUUID)
            ->where('organization_id', $organization_id)
            ->first();
        if ($accomplishmentReport->read_at == NULL) 
        {
            $data = ['read_at' => Carbon::now(),];
            $accomplishmentReport->update($data);
        }
        return view($this->viewDirectory . 'show', 
            compact(
                'accomplishmentReport',
            ));
    }

    public function redirectFromNotification($accomplishmentReportUUID)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Accomplishment_Report'), 403);
        abort_if(! AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->exists(), 404);

        $accomplishmentReport = AccomplishmentReport::with('organization:organization_id,organization_slug')
            ->where('accomplishment_report_uuid', $accomplishmentReportUUID)
            ->first();
        return redirect()->action(
            [AdminAccomplishmentReportsController::class, 'show'], ['organizationSlug' => $accomplishmentReport->organization->organization_slug, 'accomplishmentReportUUID' => $accomplishmentReportUUID]);
    }

}
