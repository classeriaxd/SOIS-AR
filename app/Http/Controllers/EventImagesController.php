<?php

namespace App\Http\Controllers;

use \App\Models\User;
use \App\Models\Event;
use \App\Models\EventImage;
use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class EventImagesController extends Controller
{
    public function index($event_slug)
    {
        $event = Event::where('slug', $event_slug)->first();
        $eventImages = EventImage::where('event_id', $event->event_id)->get();
        return view('eventimages.index',compact('event', 'eventImages'));
    }

    public function show($event_slug, $eventImage_slug)
    {
        $event = Event::where('slug', $event_slug)->first();
        $eventImage = EventImage::where('slug', $eventImage_slug)->first();
        return view('eventimages.show',compact('event', 'eventImage'));
    }

    public function edit($event_slug, $eventImage_slug)
    {
        $event = Event::where('slug', $event_slug)->first();
        $eventImage = EventImage::where('slug', $eventImage_slug)->first();
    	return view('eventimages.edit', compact('event', 'eventImage'));
    }

    public function update($event_slug, $eventImage_slug)
    {
    	$data = request()->validate([
    	    'caption' => '',
            'image_type' => ['required',Rule::in([0, 1])],
    	]);
        $event = Event::where('slug', $event_slug)->first();
    	$eventImage = EventImage::where('slug', $eventImage_slug)->update($data);
    	return redirect("/e/{$event_slug}/images/{$eventImage_slug}");
    }

    public function destroy($event_slug, $eventImage_slug)
    {
        $event = Event::where('slug', $event_slug)->first();
        $eventImage = EventImage::where('slug', $eventImage_slug)->delete();
        return redirect("/e/{$event_slug}/images");
    }

    
    public function create($event_slug)
    {
        $event = Event::where('slug', $event_slug)->first();
        return view('eventimages.create', compact('event'));
    }
    public function store($event_slug)
    {
		$data = request()->validate([
	        'poster' => 'image|file|max:2048',
	        'poster_caption' => '',
	        'evidence' => 'image|file|max:2048',
	        'evidence_caption' => '',
		]);
        $event = Event::where('slug', $event_slug)->first();
    	// Image Type > 0 = Poster | 1 = Evidence
        if(request('poster') && request('evidence'))
        {
            $posterPath = request('poster')->store('uploads','public');
            $image = Image::make(public_path("storage/{$posterPath}"))->fit(1200, 1000);
            $image->save();

            EventImage::create([
                'event_id' => $event->event_id,
                'image' => $posterPath,
                'image_type' => 0,
                'caption' => $data['poster_caption'],
                'slug' => Str::uuid(),
            ]);
            $evidencePath = request('evidence')->store('uploads','public');
            $image = Image::make(public_path("storage/{$evidencePath}"))->fit(1200, 1000);
            $image->save();

            EventImage::create([
                'event_id' => $event->event_id,
                'image' => $evidencePath,
                'image_type' => 1,
                'caption' => $data['evidence_caption'],
                'slug' => Str::uuid(),
            ]);
        }

    	else if(request('poster'))
    	{
    	    $posterPath = request('poster')->store('uploads','public');
    	    $image = Image::make(public_path("storage/{$posterPath}"))->fit(1200, 1000);
    	    $image->save();

    	    EventImage::create([
    	        'event_id' => $event->event_id,
    	        'image' => $posterPath,
    	        'image_type' => 0,
    	        'caption' => $data['poster_caption'],
                'slug' => Str::uuid(),
    	    ]);
    	}

    	else if(request('evidence'))
    	{
    	    $evidencePath = request('evidence')->store('uploads','public');
    	    $image = Image::make(public_path("storage/{$evidencePath}"))->fit(1200, 1000);
    	    $image->save();

    	    EventImage::create([
    	        'event_id' => $event->event_id,
    	        'image' => $evidencePath,
    	        'image_type' => 1,
    	        'caption' => $data['evidence_caption'],
                'slug' => Str::uuid(),
    	    ]);
    	}
    	return redirect('/e/'.$event_slug);
    }

}
