<?php

namespace App\Http\Controllers;

use \App\Models\User;
use \App\Models\Event;
use \App\Models\EventImage;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class EventImagesController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }
    public function edit(Event $event, EventImage $eventImage)
    {
    	return view('eventimages.edit', compact('event', 'eventImage'));
    }
    public function update(Event $event, EventImage $eventImage)
    {
        $image_type_options = ['0','1'];
    	$data = request()->validate([
    	    'caption' => '',
            'image_type' => ['required',Rule::in([0, 1])],
    	]);
    	$eventImage->update($data);
    	return redirect("/e/{$event->id}/images/{$eventImage->id}");
    }
    public function destroy(Event $event, EventImage $eventImage)
    {
        $eventImage->delete($eventImage);
        return redirect("/e/{$event->id}/images");
    }
    public function show(Event $event, EventImage $eventImage)
    {
    	return view('eventimages.show',compact('event', 'eventImage'));
    }
    public function index(Event $event)
    {
    	$eventImages = EventImage::where('event_id', $event->id)->get();
        return view('eventimages.index',compact('event', 'eventImages'));
    }
    
    public function create(Event $event)
    {
        return view('eventimages.create', compact('event'));
    }
    public function store(Event $event)
    {
		$data = request()->validate([
	        'poster' => 'image|file|max:2048',
	        'poster_caption' => '',
	        'evidence' => 'image|file|max:2048',
	        'evidence_caption' => '',
		]);

    	// Image Type > 0 = Poster | 1 = Evidence
    	if(request('poster'))
    	{
    	    $posterPath = request('poster')->store('uploads','public');
    	    $image = Image::make(public_path("storage/{$posterPath}"))->fit(1200, 1000);
    	    $image->save();

    	    EventImage::create([
    	        'event_id' => $event->id,
    	        'image' => $posterPath,
    	        'image_type' => 0,
    	        'caption' => $data['poster_caption'],
    	    ]);
    	}

    	if(request('evidence'))
    	{
    	    $evidencePath = request('evidence')->store('uploads','public');
    	    $image = Image::make(public_path("storage/{$evidencePath}"))->fit(1200, 1000);
    	    $image->save();

    	    EventImage::create([
    	        'event_id' => $event->id,
    	        'image' => $evidencePath,
    	        'image_type' => 1,
    	        'caption' => $data['evidence_caption'],
    	    ]);
    	}
    	return redirect('/e/'.$event->id);
    }

}
