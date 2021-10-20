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
        return view('admin.home', compact('loginAlert',));
        
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
    private function calendarSample()
    {
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
                        'start' => Carbon::parse(strtotime($event->start_date . $event->start_time))
                            ->setTimeZone('Asia/Manila')
                            ->addDays($i),
                        'end' => Carbon::parse(strtotime($event->start_date . $event->end_time))
                            ->setTimeZone('Asia/Manila')
                            ->addDays($i),
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
                    'start' => Carbon::parse(strtotime($event->start_date . $event->start_time))
                        ->setTimeZone('Asia/Manila'),
                    'end' => Carbon::parse(strtotime($event->end_date . $event->end_time))
                        ->setTimeZone('Asia/Manila'),
                    'url' => route('event.show', ['event_slug' => $event->slug]),
                );
               
                $calendarEvents->push($arr);
                $calendarEventID+=1;
            }
        }
        $calendarOptions = collect();
        /*
        <div class="row">
            <div class="col">
                <div id="calendar"></div>
            </div>
        </div>

        <script type="text/javascript">
            {{-- FullCalendar JS --}}
            var calendar;
            document.addEventListener("DOMContentLoaded", function(event) { 
                var calendarEl = document.getElementById('calendar')
                calendar = new FullCalendar.Calendar(calendarEl,
                {
                    "headerToolbar":
                        {
                            "start": 'title',
                            "center": '',
                            "end": "today prev,next dayGridMonth timeGridWeek timeGridDay",
                            
                        },
                    "footerToolbar":
                        {
                            "center": 'today prev,next dayGridMonth timeGridWeek timeGridDay',
                        },
                    "eventLimit":true,
                    "timeZone": "Asia/Manila",
                    "locale":"en",
                    "firstDay": 0,
                    "displayEventTime":true,
                    "selectable":true,
                    "initialView":"dayGridMonth",
                    "validRange": 
                        {
                            "start": '2020-12-31',
                            "end": '2021-12-31',
                    "events":
                            JSON.parse('{{ $calendarEvents }}'.replace(/(&quot;)+/g, '"')),

                            
                },);
                calendar.render();
            });
        </script>
        */
    }
}
