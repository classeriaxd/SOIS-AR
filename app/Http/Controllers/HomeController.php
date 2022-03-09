<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use App\Models\StudentAccomplishment;
use App\Models\AccomplishmentReport;
use App\Models\Event;
use App\Models\Organization;
use App\Models\OrganizationDocument;
use App\Models\UpcomingEvent;
use App\Models\Role;
use App\Models\DataLog;

use Illuminate\Database\Eloquent\Builder;
use App\Services\PermissionServices\PermissionCheckingService;

class HomeController extends Controller
{
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Pluck all User Roles
        $userRoleCollection = Auth::user()->roles;

        // Remap User Roles into array with Organization ID
        $userRoles = array();
        foreach ($userRoleCollection as $role) 
        {
            array_push($userRoles, ['role' => $role->role, 'organization_id' => $role->pivot->organization_id]);
        }

        // Array to store variables to send to View
        $compactVariables = array();

        // If AR-related roles are lost in User-only Home
        if ($this->naliligawSiguroYungAdmin($userRoles))
            return redirect()->action(
                [Admin\HomeController::class, 'index']);

        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Home'), 403);

        // If User has a User/Member role...
        if ( ($userRoleKey = $this->hasRole($userRoles, 'User')) !== false ? true : false)
        {
            // Get Student Accomplishments Count
            $studentAccomplishmentStatuses = StudentAccomplishment::where('user_id', Auth::user()->user_id)->pluck('status');
            $statusesCount = array_count_values($studentAccomplishmentStatuses->toArray());
                $approvedAccomplishmentCount = $statusesCount[2] ?? 0;
                $pendingAccomplishmentCount = $statusesCount[1] ?? 0;
                $disapprovedAccomplishmentCount = $statusesCount[3] ?? 0;
                array_push($compactVariables, 'approvedAccomplishmentCount', 'pendingAccomplishmentCount', 'disapprovedAccomplishmentCount');
        }
        

        // If User has AR President Admin role...
        if ( ($userRoleKey = $this->hasRole($userRoles, 'AR President Admin')) !== false ? true : false)
        {
            // Get the Organization from which the user is AR President Admin
            $organizationID = $userRoles[$userRoleKey]['organization_id'];
            
            // Query the number of events, student accomplishments, and accomplishment reports under this Organization
            $eventCount = Event::where('organization_id', $organizationID)
                ->count();
            $studentAccomplishmentCount = StudentAccomplishment::where('organization_id', $organizationID)
                ->count();
            $accomplishmentReportCount = AccomplishmentReport::where('organization_id', $organizationID)
                ->where('status', 2)
                ->count();
            $documentCount = OrganizationDocument::whereHas(
                    'documentType.organization', function(Builder $query) use($organizationID){
                        $query->where('organization_id', $organizationID);},)
                ->count();
            $latestEvents = Event::with('eventRole')
                ->where('organization_id', $organizationID)
                ->orderBy('start_date', 'DESC')
                ->limit(10)
                ->get();
            array_push($compactVariables, 'eventCount', 'studentAccomplishmentCount', 'accomplishmentReportCount', 'documentCount', 'latestEvents');
        }

        // If User has AR Officer Admin role...
        if( ($userRoleKey = $this->hasRole($userRoles, 'AR Officer Admin')) !== false ? true : false)
        {
            // Get the Organization from which the user is AR Officer Admin
            $organizationID = $userRoles[$userRoleKey]['organization_id'];

            // Query the number of events, student accomplishments, and accomplishment reports under this Organization
            $eventCount = Event::where('organization_id', $organizationID)
                ->count();
            $studentAccomplishmentCount = StudentAccomplishment::where('organization_id', $organizationID)
                ->count();
            $accomplishmentReportCount = AccomplishmentReport::where('organization_id', $organizationID)
                ->where('status', 2)
                ->count();
            $documentCount = OrganizationDocument::whereHas(
                    'documentType.organization', function(Builder $query) use($organizationID){
                        $query->where('organization_id', $organizationID);},)
                ->count();
            $accomplishedEventsCount = UpcomingEvent::whereNull('accomplished_event_id')
                ->where('organization_id', $organizationID)
                ->where('advisers_approval', 'approved')
                ->where('studAffairs_approval', 'approved')
                ->where('completion_status', 'accomplished')
                ->count();
            $pendingStudentAccomplishmentCount = StudentAccomplishment::where('organization_id', $organizationID)
                ->where('status', 1)
                ->count();
            $latestEvents = Event::with('eventRole')
                ->where('organization_id', $organizationID)
                ->orderBy('start_date', 'DESC')
                ->limit(10)
                ->get();
            array_push($compactVariables, 'eventCount', 'studentAccomplishmentCount', 'accomplishmentReportCount', 'documentCount', 'accomplishedEventsCount', 'pendingStudentAccomplishmentCount','latestEvents');
        }
        // Query Activity Logs
        $activityLogs = DataLog::where('user_id', Auth::user()->user_id)
            ->orderBy('created_at', 'DESC')
            ->limit(6)
            ->get();
        array_push($compactVariables, 'activityLogs');

        // Show Login Alert on View and Activity Log once
        $loginAlert = $this->showLoginAlert();
        $showActivityLog = true;
        array_push($compactVariables, 'loginAlert', 'showActivityLog');

        // Boolean to determine whether to load Home CSS
        $loadHomeCSS = true;
        array_push($compactVariables, 'loadHomeCSS');
                
        return view('home', compact($compactVariables));
    }

    /**
     * @param Collection $userRoles
     * Function that checks if a Role is lost in User-only Home
     * @return Boolean
     */ 
    private function naliligawSiguroYungAdmin($userRoles)
    {
        // If User is Super Admin role then redirect
        if ( ($userRoleKey = $this->hasRole($userRoles, 'Super Admin')) !== false ? true : false)
            return true;

        // If User is Head of Student Services role then redirect
        if ( ($userRoleKey = $this->hasRole($userRoles, 'Head of Student Services')) !== false ? true : false)
            return true;

        // If User is Director role then redirect
        if ( ($userRoleKey = $this->hasRole($userRoles, 'Director')) !== false ? true : false)
            return true;
        return false;
    }

    /**
     * @param Array $roles, String $role
     * Function to search for a role under 'role' column in $roles Array 
     * Return Array Key if found, False if not
     * @return True: Integer, False: Boolean
     */ 
    private function hasRole($roles, $role)
    {
        return array_search($role, array_column($roles, 'role'));
    }

    public function showLoginAlert()
    {
        $loginAlert = NULL;
        
        if(session()->get('showLoginAlert') == 1)
        {
            $loginAlert =  'You are logged in! :)';
            session()->decrement('showLoginAlert');
        }

        return $loginAlert;
    }
}
