<?php

namespace App\Http\Controllers;

use \App\Models\User;
use \App\Models\Event;
use \App\Models\EventImage;

use Illuminate\Http\Request;

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
            $start_date = strftime("%G-%m-%d",strtotime(request('start_date')));
            $end_date = strftime("%G-%m-%d",strtotime(request('end_date')));
        }
        else
            return view('eventreports.index');
        
        // Get all Events within $start_date and $end_date, 
        // then grabs all of their child Event Images
        // All sorted ASC on date and image_type respectively
    	$events = Event::with(['eventImages' => function ($query) {
                    $query->orderBy('image_type', 'ASC');}])
            ->whereBetween('date', [$start_date, $end_date])
    		->orderBy('date', 'ASC')
    		->get();

        $start = Carbon::parse($start_date)->format('F Y');
        $end = Carbon::parse($end_date)->format('F Y');
        $dompdf = PDF::loadView('eventreports.pdf', compact('events', 'start', 'end'));
        //return $dompdf->download("tite".'Document.pdf');
        return $dompdf->stream();
    }
}
