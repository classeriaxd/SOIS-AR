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
            $accomplishments = StudentAccomplishment::where('user_id', $user_id)
                ->pluck('status');
            $approvedAccomplishmentCount = count($accomplishments->where('status', 1));
            $pendingAccomplishmentCount = count($accomplishments->where('status', 0));
            $disapprovedAccomplishmentCount = count($accomplishments->where('status', 2));

            return view('home', compact('approvedAccomplishmentCount', 'pendingAccomplishmentCount', 'disapprovedAccomplishmentCount'));
        }
        else
            abort(404);

    }
}
