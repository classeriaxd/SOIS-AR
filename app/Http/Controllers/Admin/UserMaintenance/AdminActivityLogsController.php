<?php

namespace App\Http\Controllers\Admin\UserMaintenance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DataLog;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use App\Services\PermissionServices\PermissionCheckingService;
use App\Http\Controllers\Controller as Controller;

class AdminActivityLogsController extends Controller
{
    protected $viewDirectory = 'admin.activityLogs.';
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
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Roles_and_Permissions'), 403);

        $activityLogs = DataLog::with('user:user_id,course_id,first_name,middle_name,last_name,suffix,student_number',
            'user.course:course_id,organization_id,course_acronym',
            'user.course.organization:organization_id,organization_acronym')
            ->orderBy('created_at', 'DESC')
            ->paginate(30, ['*'], 'activityLog');

        $organizations = Organization::with('logos:organization_id,file')
            ->orderBy('organization_type_id', 'ASC')
            ->get();

        return view($this->viewDirectory . 'index', 
            compact(
                'activityLogs',
                'organizations',
            ));
        
    }

    public function organizationIndex($organizationSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Roles_and_Permissions'), 403);
        abort_if(($organization = Organization::where('organization_slug', $organizationSlug)->select('organization_id', 'organization_acronym')->first()) !== NULL ? false : true, 404);

        $organizationLogo = $organization->logo->file;

        $activityLogs = DataLog::with('user:user_id,course_id,first_name,middle_name,last_name,suffix,student_number',
            'user.course:course_id,organization_id,course_acronym',
            'user.course.organization:organization_id,organization_acronym')
            ->whereHas('user.course', function (Builder $query) use ($organization) {
                    $query->where('organization_id', $organization->organization_id);})
            ->orderBy('created_at', 'DESC')
            ->paginate(30, ['*'], 'activityLog');
        
        return view($this->viewDirectory . 'organizationIndex', 
            compact(
                'activityLogs',
                'organization',
                'organizationLogo',
            ));
    }

}
