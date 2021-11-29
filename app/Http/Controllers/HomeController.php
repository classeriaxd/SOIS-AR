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
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Home'), 403);
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

        // If User is Super Admin role then redirect
        if ( ($userRoleKey = $this->hasRole($userRoles, 'Super Admin')) !== false ? true : false)
            return redirect()->action(
                [Admin\HomeController::class, 'index']);

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
            $eventCount = Event::where('organization_id', $organizationID)->count();
            $studentAccomplishmentCount = StudentAccomplishment::where('organization_id', $organizationID)->count();
            $accomplishmentReportCount = AccomplishmentReport::where('organization_id', $organizationID)->count();
            $documentCount = OrganizationDocument::whereHas(
                    'documentType.organization', function(Builder $query) use($organizationID){
                        $query->where('organization_id', $organizationID);},)
                ->count();
            array_push($compactVariables, 'eventCount', 'studentAccomplishmentCount', 'accomplishmentReportCount', 'documentCount');
        }

        // If User has AR Officer Admin role...
        if( ($userRoleKey = $this->hasRole($userRoles, 'AR Officer Admin')) !== false ? true : false)
        {
            // Get the Organization from which the user is AR Officer Admin
            $organizationID = $userRoles[$userRoleKey]['organization_id'];

            // Query the number of events, student accomplishments, and accomplishment reports under this Organization
            $eventCount = Event::where('organization_id', $organizationID)->count();
            $studentAccomplishmentCount = StudentAccomplishment::where('organization_id', $organizationID)->count();
            $accomplishmentReportCount = AccomplishmentReport::where('organization_id', $organizationID)->count();
            $documentCount = OrganizationDocument::whereHas(
                    'documentType.organization', function(Builder $query) use($organizationID){
                        $query->where('organization_id', $organizationID);},)
                ->count();
            $organization = Organization::where('organization_id', $organizationID)->first();
            array_push($compactVariables, 'eventCount', 'studentAccomplishmentCount', 'accomplishmentReportCount', 'documentCount','organization');
        }

        // Show Login Alert on View once
        $loginAlert = $this->showLoginAlert();
        array_push($compactVariables, 'loginAlert');

        // Boolean to determine whether to load Home CSS
        $loadHomeCSS = true;
        array_push($compactVariables, 'loadHomeCSS');
                
        return view('home', compact($compactVariables));
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
