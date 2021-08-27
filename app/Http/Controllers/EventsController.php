<?php

namespace App\Http\Controllers;

use \App\Models\User;
use \App\Models\Event;
use \App\Models\EventImage;
use \App\Models\EventCategory;
use \App\Models\EventRole;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Intervention\Image\Facades\Image;

use Carbon\Carbon;

class EventsController extends Controller
{
    public function index()
    {
        $allEventYears = Event::selectRaw('YEAR(`start_date`) as year')
            ->where('organization_id', Auth::user()->course->organization_id,)
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
        $orgAcronym = Auth::user()->course->organization->organization_acronym;
        $events = array();
        foreach($allEventYears as $year) 
        {
            $yearEvents = Event::whereRaw('YEAR(`start_date`) = ?', $year->year)
                ->where('organization_id', Auth::user()->course->organization_id,)
                ->orderByRaw('MONTH(`start_date`) ASC, `start_date` ASC')
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
        $event_categories = EventCategory::all();
        $event_roles = EventRole::all();
    	return view('events.create', compact('event_categories', 'event_roles'));
    }
    public function store()
    {
    	$data = request()->validate([
    		'title' => 'required|string|min:2|max:255',
    		'description' => 'required|string',
    		'objective' => 'required|string',
    		'start_date' => 'required|date|date_format:Y-m-d|before_or_equal:now|after:1992-01-01',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date|before_or_equal:now|after:1992-01-01',
    		'start_time' => 'date_format:H:i',
    		'end_time' => 'date_format:H:i|after_or_equal:start_time',
    		'venue' => 'required|string',
    		'activity_type' => 'required|string',
    		'beneficiaries' => 'required|string',
    		'sponsors' => 'required|string',
    		'budget' => 'nullable|numeric',
            'event_role' => 'required|exists:event_roles,event_role_id',
            'event_category' => 'required|exists:event_categories,event_category_id',
    	]);

    	$event_slug = Event::create([
            'organization_id' => Auth::user()->course->organization_id,
            'event_role_id' => $data['event_role'],
            'event_category_id' => $data['event_category'],
    		'title' => $data['title'],
    		'description' => $data['description'],
    		'objective' => $data['objective'],
    		'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
    		'start_time' => $data['start_time'],
    		'end_time' => $data['end_time'],
    		'venue' => $data['venue'],
    		'activity_type' => $data['activity_type'],
    		'beneficiaries' => $data['beneficiaries'],
    		'sponsors' => $data['sponsors'],
    		'budget' => $data['budget'],
            'slug' => Str::slug($data['title'], '-') . '-' . Carbon::parse($data['start_date'])->format('Y') . '-' . Str::uuid(),
    	])->slug;
        dd($event_slug);
        return redirect()->route('event.show',['event_slug' => $event_slug,]);
    }
}
