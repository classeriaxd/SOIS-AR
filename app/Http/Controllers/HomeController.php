<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\StudentAccomplishment;
use App\Models\AccomplishmentReport;

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
        if (Auth::check() && $user_id = Auth::user()->user_id) 
        {
            $userPositionTitles = Auth::user()->positionTitles;
            // Array because of Laravel Collection, maybe revise this sometime?
            $orgCurrentPositionArray = $userPositionTitles->where('organization_id', Auth::user()->course->organization_id)->pluck('position_title');
            $orgCurrentPosition = $orgCurrentPositionArray[0];
            $document_officers = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];

            $loginAlert = $this->showLoginAlert();
            $loadHomeCSS = true;
            if ($orgCurrentPosition == 'Member')
            {
                $accomplishments = StudentAccomplishment::where('user_id', $user_id)
                    ->pluck('status') ?? false;
                $accomplishments = ($accomplishments) ? array_count_values($accomplishments->toArray()) : NULL;
                $approvedAccomplishmentCount = $accomplishments[2] ?? 0;
                $pendingAccomplishmentCount = $accomplishments[1] ?? 0;
                $disapprovedAccomplishmentCount = $accomplishments[3] ?? 0;
                return view('home', compact('loginAlert', 'approvedAccomplishmentCount', 'pendingAccomplishmentCount', 'disapprovedAccomplishmentCount', 'loadHomeCSS'));

            }

            // Organization President
            else if($orgCurrentPosition == 'President') 
            {
                $pendingARSubmissionCount = AccomplishmentReport::where('status', 1)
                    ->where('organization_id', Auth::user()->course->organization_id)
                    ->count();

                return view('home', compact('loginAlert', 'pendingARSubmissionCount', 'loadHomeCSS'));
            }

            // Other Documentation Officers
            else if(in_array($orgCurrentPosition, $document_officers))
            {
                $submissionCount = StudentAccomplishment::where('status', 1)
                    ->where('organization_id', Auth::user()->course->organization_id)
                    ->count();
                $pendingARSubmissionCount = AccomplishmentReport::where('status', 1)
                    ->where('organization_id', Auth::user()->course->organization_id)
                    ->count();
                return view('home', compact('loginAlert', 'submissionCount', 'pendingARSubmissionCount', 'loadHomeCSS'));
            }

            else
                abort(404);
        }
        else
            abort(404);
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
