<?php

namespace App\Http\Controllers;

use \App\Models\User;
use \App\Models\Event;
use \App\Models\EventImage;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use \App\Rules\EventTitle;

use Intervention\Image\Facades\Image;

use Carbon\Carbon;

class EventsController extends Controller
{
    public function index()
    {
        $allEventYears = Event::selectRaw('YEAR(`date`) as year')
            ->where('organization_id', Auth::user()->course->organization_id,)
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
        $orgAcronym = Auth::user()->course->organization->organization_acronym;
        $events = array();
        foreach($allEventYears as $year) 
        {
            $yearEvents = Event::whereRaw('YEAR(`date`) = ?', $year->year)
                ->where('organization_id', Auth::user()->course->organization_id,)
                ->orderByRaw('MONTH(`date`) ASC, DATE ASC')
                ->get();
            $events[$year->year] = $yearEvents; 
        }

        return view('events.index', compact('events', 'orgAcronym'));
    }
    public function show($event_slug)
    {
        if($event = Event::where('slug', $event_slug)->first())
        {
            $eventImages = EventImage::where('event_id', $event->event_id)->get();
            return view('events.show',compact('event', 'eventImages'));
        }
        else
            abort(404);
    }
    public function edit($event_slug)
    {
        if($event = Event::where('slug', $event_slug)->first())
            return view('events.edit',compact('event'));
        else
            abort(404);
    }
    public function update($event_slug)
    {
        $data = request()->validate([
            'title' => ['required','regex:/^[\w\-\s]+$/','min:2','max:255', new EventTitle($event_slug)],
            'description' => 'required',
            'objective' => 'required',
            'date' => 'required|date',
            'start_time' => 'date_format:H:i',
            'end_time' => 'date_format:H:i|after:start_time',
            'venue' => 'required',
            'activity_type' => 'required',
            'beneficiaries' => 'required',
            'sponsors' => 'required',
            'budget' => 'nullable|numeric',
        ]);
        $event_data = [
            'title' => $data['title'],
            'description' => $data['description'],
            'objective' => $data['objective'],
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'venue' => $data['venue'],
            'activity_type' => $data['activity_type'],
            'beneficiaries' => $data['beneficiaries'],
            'sponsors' => $data['sponsors'],
            'budget' => $data['budget'],
            'slug' => Str::replace(' ', '-', $data['title']).'-'.Carbon::createFromFormat('Y-m-d', $data['date'])->format('Y'),
        ];

        $old_event = Event::where('slug', $event_slug)->first();
        if (Event::where('event_id', $old_event->event_id)->update($event_data))
        {
            $event_slug = Event::where('event_id', $old_event->event_id)->value('slug');
            return redirect()->route('event.show',['event_slug' => $event_slug,]);
        }
        // todo: db error handling
        else
            abort(404);
    }
    public function destroy($event_slug)
    {
        if ($event = Event::where('slug', $event_slug)->first())
        {
            if ($event->delete())
                return redirect()->route('event.index');
            else
               abort(404); 
        }
        else
            abort(404);
    }
    public function create()
    {
    	return view('events.create');
    }
    public function store()
    {
    	$data = request()->validate([
    		'title' => 'required|regex:/^[\w\-\s]+$/|min:2|max:255,unique:events,title',
    		'description' => 'required',
    		'objective' => 'required',
    		'date' => 'required|date',
    		'start_time' => 'date_format:H:i',
    		'end_time' => 'date_format:H:i|after:start_time',
    		'venue' => 'required',
    		'activity_type' => 'required',
    		'beneficiaries' => 'required',
    		'sponsors' => 'required',
    		'budget' => 'nullable|numeric',
    	]);
        
    	$event_id = Event::create([
            'organization_id' => Auth::user()->course->organization_id,
    		'title' => $data['title'],
    		'description' => $data['description'],
    		'objective' => $data['objective'],
    		'date' => $data['date'],
    		'start_time' => $data['start_time'],
    		'end_time' => $data['end_time'],
    		'venue' => $data['venue'],
    		'activity_type' => $data['activity_type'],
    		'beneficiaries' => $data['beneficiaries'],
    		'sponsors' => $data['sponsors'],
    		'budget' => $data['budget'],
            'slug' => Str::replace(' ', '-', $data['title']).'-'.Carbon::createFromFormat('Y-m-d', $data['date'])->format('Y'),
    	])->event_id;
        
        $event_slug = Event::where('event_id', $event_id)->value('slug');

        return redirect()->route('event.show',['event_slug' => $event_slug,]);
        
    	
    }
}
