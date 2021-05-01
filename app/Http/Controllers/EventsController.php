<?php

namespace App\Http\Controllers;

use \App\Models\User;
use \App\Models\Event;
use \App\Models\EventImage;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class EventsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }
    public function index()
    {
        // Select events authored by authenticated user
        $events = Event::whereIn('user_id', auth()->user())
            ->orderByRaw('YEAR(`date`) DESC, MONTH(`date`) ASC, DATE ASC')
            ->get();

        return view('events.index', compact('events'));
    }
    public function show(Event $event)
    {
        $eventImages = EventImage::where('event_id', $event->id)->get();
        return view('events.show',compact('event', 'eventImages'));
    }
    public function edit(Event $event)
    {
        return view('events.edit',compact('event'));
    }
    public function update(Event $event)
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'objective' => 'required',
            'date' => 'required|date',
            'start_time' => 'date_format:H:i',
            'end_time' => 'date_format:H:i|after:start_time',
            'venue' => 'required',
            'activity_type' => 'required',
            'beneficiaries' => 'required',
            'sponsors' => 'required',
            'budget' => '',
        ]);
        $event->update($data);
        return redirect("/e/{$event->id}");
    }
    public function destroy(Event $event)
    {
        $event->delete($event);
        return redirect("/e");
    }
    public function create()
    {
    	return view('events.create');
    }
    public function store()
    {
    	$data = request()->validate([
    		'title' => 'required',
    		'description' => 'required',
    		'objective' => 'required',
    		'date' => 'required|date',
    		'start_time' => 'date_format:H:i',
    		'end_time' => 'date_format:H:i|after:start_time',
    		'venue' => 'required',
    		'activity_type' => 'required',
    		'beneficiaries' => 'required',
    		'sponsors' => 'required',
    		'budget' => '',
            'poster' => 'image|file|max:2048',
            'poster_caption' => '',
            'evidence' => 'image|file|max:2048',
            'evidence_caption' => '',
    	]);

    	$event_id = auth()->user()->events()->create([
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
    	])->id;

    	return redirect('/e/'.$event_id);

    }
}
