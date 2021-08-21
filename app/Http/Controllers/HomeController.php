<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\StudentAccomplishment;

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
            if ($orgCurrentPosition == 'Member')
            {
                $accomplishments = StudentAccomplishment::where('user_id', $user_id)
                    ->pluck('status') ?? false;
                $approvedAccomplishmentCount = ($accomplishments) ? $accomplishments->where('status', 1)->count() : 0;
                $pendingAccomplishmentCount = ($accomplishments) ? $accomplishments->where('status', 0)->count() : 0;
                $disapprovedAccomplishmentCount = ($accomplishments) ? $accomplishments->where('status', 2)->count() : 0;

                return view('home', compact('approvedAccomplishmentCount', 'pendingAccomplishmentCount', 'disapprovedAccomplishmentCount'));
            }
            // Organization President
            else if($orgCurrentPosition == 'President') {}
            // Other Documentation Officers
            else if(in_array($orgCurrentPosition, $document_officers))
            {
                $submissionCount = StudentAccomplishment::where('status', 0)
                    ->where('organization_id', Auth::user()->course->organization_id)
                    ->count();
                return view('home', compact('submissionCount',));
            }
            else
                abort(404);
        }
        else
            abort(404);

    }
}
