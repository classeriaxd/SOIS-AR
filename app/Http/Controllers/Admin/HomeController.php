<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

use Carbon\Carbon;
use DateTime;

use App\Http\Controllers\Controller as Controller;

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
        $loginAlert = $this->showLoginAlert();
        $calendarEvents = collect();
        $allEvents = Event::all();
        $calendarEventID = 1;
        foreach ($allEvents as $event) 
        {
            if((new DateTime($event->start_date))->diff(new DateTime($event->end_date))->d > 0)
            {
                $eventLengthInDays = (new DateTime($event->start_date))->diff(new DateTime($event->end_date))->d + 1;

                for ($i = 0; $i < $eventLengthInDays; $i++) 
                { 
                    $arr = array(
                        'id' => $calendarEventID,
                        'title' => $event->title,
                        'allDay' => false,
                        'start' => Carbon::parse(strtotime($event->start_date . $event->start_time))->addDays($i),
                        'end' => Carbon::parse(strtotime($event->start_date . $event->end_time))->addDays($i),
                        'url' => route('event.show', ['event_slug' => $event->slug]),
                    );
                    $calendarEvents->push($arr);
                    $calendarEventID+=1;
                }
            }
            else
            {
                $arr = array(
                    'id' => $calendarEventID,
                    'title' => $event->title,
                    'allDay' => false,
                    'start' => Carbon::parse(strtotime($event->start_date . $event->start_time)),
                    'end' => Carbon::parse(strtotime($event->end_date . $event->end_time)),
                    'url' => route('event.show', ['event_slug' => $event->slug]),
                );
               
                $calendarEvents->push($arr);
                $calendarEventID+=1;
            }

        }
        //dd($calendarEvents);
        $loadJSWithoutDefer = false;
        return view('admin.home', compact('loginAlert', 'calendarEvents', 'loadJSWithoutDefer'));
        
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
