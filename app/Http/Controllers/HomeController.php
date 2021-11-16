<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use App\Models\StudentAccomplishment;
use App\Models\AccomplishmentReport;
use App\Models\Event;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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

        // Remap User Roles with Organization ID
        $userRoles = array();
        foreach ($userRoleCollection as $role) 
        {
            array_push($userRoles, ['role' => $role->role, 'organization_id' => $role->pivot->organization_id]);
        }

        // Array to store variables to send to View
        $compactVariables = array();

        // Get Student Accomplishments Count
        $studentAccomplishmentStatuses = StudentAccomplishment::where('user_id', Auth::user()->user_id)->pluck('status');
        $statusesCount = array_count_values($studentAccomplishmentStatuses->toArray());
            $approvedAccomplishmentCount = $statusesCount[2] ?? 0;
            $pendingAccomplishmentCount = $statusesCount[1] ?? 0;
            $disapprovedAccomplishmentCount = $statusesCount[3] ?? 0;
            array_push($compactVariables, 'approvedAccomplishmentCount', 'pendingAccomplishmentCount', 'disapprovedAccomplishmentCount');

        // If User has AR President Admin role...
        if ( ($userRoleKey = $this->hasRole($userRoles, 'AR President Admin')) !== false ? true : false)
        {
            // Get the Organization from which the user is AR President Admin
            $organization_id = $userRoles[$userRoleKey]['organization_id'];
            
            // Query the number of events, student accomplishments, and accomplishment reports under this Organization
            $eventsCount = Event::where('organization_id', $organization_id)->count();
            $studentAccomplishmentCount = StudentAccomplishment::where('organization_id', $organization_id)->count();
            $accomplishmentReportCount = AccomplishmentReport::where('organization_id', $organization_id)->count();
            $documentCount = NULL;
            array_push($compactVariables, 'eventsCount', 'studentAccomplishmentCount', 'accomplishmentReportCount', 'documentCount');
        }

        // If User has AR Officer Admin role...
        if( ($userRoleKey = $this->hasRole($userRoles, 'AR Officer Admin')) !== false ? true : false)
        {
            // Get the Organization from which the user is AR President Admin
            $organization_id = $userRoles[$userRoleKey]['organization_id'];

            // Query the number of events, student accomplishments, and accomplishment reports under this Organization
            $eventsCount = Event::where('organization_id', $organization_id)->count();
            $studentAccomplishmentCount = StudentAccomplishment::where('organization_id', $organization_id)->count();
            $accomplishmentReportCount = AccomplishmentReport::where('organization_id', $organization_id)->count();
            $documentCount = NULL;
            array_push($compactVariables, 'eventsCount', 'studentAccomplishmentCount', 'accomplishmentReportCount', 'documentCount');
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
