<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Organization;
use App\Models\OrganizationAsset;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use Barryvdh\DomPDF\Facade;
use PDF;

class EventReportsController extends Controller
{
    public function index()
    {
    	return view('eventreports.index');
    }

    public function show()
    {
    	if(request('first'))
    	{
    		$start_date = date('Y').'-01-01';
    		$end_date = date('Y').'-03-31';
    	}
    	else if(request('second'))
    	{
    		$start_date = date('Y').'-04-01';
    		$end_date = date('Y').'-06-30';
    	}
    	else if(request('third'))
    	{
    		$start_date = date('Y').'-07-01';
    		$end_date = date('Y').'-09-30';
    	}
    	else if(request('fourth'))
    	{
    		$start_date = date('Y').'-10-01';
    		$end_date = date('Y').'-12-31';
    	}
        else if(request('custom'))
        {
            $data = request()->validate([
                'start_date' => 'date',
                'end_date' => 'date|after:start_date',
                ]);
            $start_date = Carbon::parse($data['start_date']);
            $end_date = Carbon::parse($data['end_date']);
        }
        else
        {
            return view('eventreports.index');
        }

        // Fetch organization and assets
        $organization = Organization::where('organization_id', Auth::user()->course->organization_id)
            ->first();
        $organization_logo = OrganizationAsset::where('organization_id', $organization->organization_id)
            ->where('type', '1')
            ->select('image')
            ->first();
        
        // Get all Events within $start_date and $end_date, 
        // then grabs all of their child Event Images
        // All sorted ASC on date and image_type respectively
    	$events = Event::with(['eventImages' => function ($query) {
                    $query->orderBy('image_type', 'ASC');}])
            ->where('organization_id', $organization->organization_id)
            ->whereBetween('date', [$start_date, $end_date])
    		->orderBy('date', 'ASC')
    		->get();

        $start = Carbon::parse($start_date)->format('F Y');
        $end = Carbon::parse($end_date)->format('F Y');

        if(0)
        {
            // normal view
            $view = true;
            return view('eventreports.pdf', compact('events', 'start', 'end', 'view', 'organization', 'organization_logo'));
        }
        else
        {
            //dompdf views
            $view = false;
            $dompdf = PDF::loadView('eventreports.pdf', compact('events', 'start', 'end', 'view', 'organization', 'organization_logo'));  
            return $dompdf->stream();
        }

        

        //download
        //return $dompdf->download("yeet".'Document.pdf');
    }
}
