<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AccomplishmentReport;
use App\Models\Event;
use App\Models\Organization;

use App\Services\PermissionServices\PermissionCheckingService;
use App\Http\Controllers\Controller as Controller;

class AdminOrganizationsController extends Controller
{
    protected $viewDirectory = 'admin.organizations.';
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
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Organization'), 403);
        $organizations = Organization::withCount(['events', 'accomplishmentReports','unreadAccomplishmentReports'])
            ->with('logos')
            ->get();
        return view($this->viewDirectory . 'index', 
            compact(
                'organizations',
            ));
        
    }
    public function show($organizationSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Organization'), 403);
        abort_if(($organization = Organization::with('logo')->where('organization_slug', $organizationSlug)->first()) !== NULL ? false : true, 404);
        
        $organizationLogo = $organization->logo->file;

        $events = Event::with(
                'eventRole:event_role_id,event_role,background_color,text_color',
                'eventCategory:event_category_id,category,background_color,text_color',
                'eventFundSource:fund_source_id,fund_source',
                'eventLevel:level_id,level',
                'eventClassification:event_classification_id,classification',
                'eventNature:event_nature_id,nature')
            ->where('organization_id', $organization->organization_id)
            ->orderBy('start_date', 'DESC')
            ->limit(5)
            ->get();

        $accomplishmentReports = AccomplishmentReport::with('accomplishmentReportType')
            ->where('organization_id', $organization->organization_id)
            ->orderBy('read_at', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        return view($this->viewDirectory . 'show', 
            compact(
                'organization',
                'events',
                'accomplishmentReports',
           ));
    }

}
