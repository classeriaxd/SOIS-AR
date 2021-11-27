<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\TemporaryFile;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\EventImageRequests\{
    EventImageStoreRequest,
    EventImageStoreCaptionRequest,
    EventImageUpdateRequest,
};

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class EventImagesController extends Controller
{
    public function index($event_slug)
    {
        $event = Event::with('eventImages')
            ->where('slug', $event_slug)->first();
        
        $posters = $event->eventImages->where('image_type', 0);
        $evidences = $event->eventImages->where('image_type', 1);
        // dd(compact('posters', 'evidences'));
        return view('events.eventimages.index',compact('event','posters','evidences'));
    }

    public function show($event_slug, $eventImage_slug)
    {
        $event = Event::with([
            'eventImage' => function ($query) use ($eventImage_slug) {
                $query->where('slug', $eventImage_slug);},
            ])
        ->where('slug', $event_slug)->first();
        return view('events.eventimages.show',compact('event'));
    }

    public function edit($event_slug, $eventImage_slug)
    {
        $event = Event::with([
            'eventImage' => function ($query) use ($eventImage_slug) {
                $query->where('slug', $eventImage_slug);},
            ])
        ->where('slug', $event_slug)->first();

    	return view('events.eventimages.edit', compact('event'));
    }

    public function update(EventImageUpdateRequest $request, $event_slug, $eventImage_slug)
    {
        EventImage::where('slug', $eventImage_slug)
            ->update([
                'caption' => $request->input('caption', NULL),
                'image_type' => $request->input('image_type'),
        ]);

        return redirect()->action(
            [EventImagesController::class, 'show'], ['event_slug' => $event_slug, 'eventImage_slug' => $eventImage_slug]
        );
    }

    public function destroy($event_slug, $eventImage_slug)
    {
        $event = Event::where('slug', $event_slug)->first();
        $eventImage = EventImage::where('slug', $eventImage_slug)->delete();
        return redirect()->action(
            [EventImagesController::class, 'index'], ['event_slug' => $event->slug]
        );
    }

    
    public function create($event_slug)
    {
        $event = Event::where('slug', $event_slug)->first();
        $filePondJS = true;
        $loadJSWithoutDefer = true;
        return view('events.eventimages.create', compact('event', 'filePondJS', 'loadJSWithoutDefer'));
    }
    public function createCaption($event_slug)
    {
        $event = Event::where('slug', $event_slug)->first();
        $eventImages['posters'] = collect();
        $eventImages['evidences'] = collect();
        if(session()->has('eventImagesArray'))
        {
            $eventImagesArray = session()->get('eventImagesArray');
            session()->keep(['eventImagesArray']);
            $eventImages['posters'] = EventImage::where('image_type', 0)
                ->where('accomplished_event_id', $event->accomplished_event_id)
                ->whereIn('event_image_id', $eventImagesArray)
                ->get();
            $eventImages['evidences'] = EventImage::where('image_type', 1)
                ->where('accomplished_event_id', $event->accomplished_event_id)
                ->whereIn('event_image_id', $eventImagesArray)
                ->get();
        }
        $loadJSWithoutDefer = true;
        return view('events.eventimages.createCaption', compact('event','eventImages', 'loadJSWithoutDefer'));
    }
    public function store(EventImageStoreRequest $request, $event_slug)
    {
        $event = Event::where('slug', $event_slug)->first();
    	$insertedImages = array();
        $currentTime = Carbon::now();
        if($request->has('poster'))
        {
            $tempPath = '/public/uploads/tmp/';
            $finalPath = '/public/uploads/events/posters/';
            $dbPath = '/uploads/events/posters/';
            
            foreach($request->input('poster') as $poster)
            {
                $file = TemporaryFile::where('folder', $poster)->value('filename');
                Storage::move($tempPath . $poster . '/' . $file, $finalPath . $file);
                $this->deleteDirectory($tempPath . $poster);
                TemporaryFile::where('folder', $poster)->delete();

                // Image Type > 0 = Poster | 1 = Evidence
                $eventImageID = EventImage::insertGetId([
                    'accomplished_event_id' => $event->accomplished_event_id,
                    'image' => $dbPath . $file,
                    'image_type' => 0,
                    'caption' => NULL,
                    'slug' => Str::uuid(),
                    'created_at' => $currentTime,
                    'updated_at' => $currentTime,
                ]);
                array_push($insertedImages, $eventImageID);
            }
        }

        if($request->has('evidence'))
        {
            $tempPath = '/public/uploads/tmp/';
            $finalPath = '/public/uploads/events/evidences/';
            $dbPath = '/uploads/events/evidences/';
            foreach($request->input('evidence') as $evidence)
            {
                $file = TemporaryFile::where('folder', $evidence)->value('filename');
                Storage::move($tempPath . $evidence . '/' . $file, $finalPath . $file);
                $this->deleteDirectory($tempPath . $evidence);
                TemporaryFile::where('folder', $evidence)->delete();

                // Image Type > 0 = Poster | 1 = Evidence
                $eventImageID = EventImage::insertGetId([
                    'accomplished_event_id' => $event->accomplished_event_id,
                    'image' => $dbPath . $file,
                    'image_type' => 1,
                    'caption' => NULL,
                    'slug' => Str::uuid(),
                    'created_at' => $currentTime,
                    'updated_at' => $currentTime,
                ]);
                array_push($insertedImages, $eventImageID);
            }
        }
        if(count($insertedImages) > 0)
        {   
            session()->flash('eventImagesArray', $insertedImages);
            return redirect()->action(
                [EventImagesController::class, 'createCaption'], ['event_slug' => $event->slug,]
            );
        }
        else
            return redirect()->action(
                [EventsController::class, 'show'], ['event_slug' => $event->slug]
            );
    }
    public function storeCaption(EventImageStoreCaptionRequest $request, $event_slug)
    {
        if($request->has('caption'))
        {
            $event = Event::where('slug', $event_slug)->first();
            foreach($request->input('caption') as $image => $caption)
            {
                if ($caption != NULL)
                {
                    EventImage::where('accomplished_event_id', $event->accomplished_event_id)
                        ->where('slug', $image)
                        ->update(['caption' => $caption ]);
                }
            }
        }
        return redirect()->action(
            [EventsController::class, 'show'], ['event_slug' => $event->slug]
        );
    }

    /* FilePond JS
     * Upload Functions
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('evidence'))
        {
            $request->validate([
                'evidence.*' => 'mimes:jpg,jpeg,png',
            ]);
            foreach ($request->file('evidence') as $file) 
            {
                $filename = uniqid() . '-' . now()->timestamp . '.' .$file->extension();
                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('/public/uploads/tmp/' . $folder, $filename);

                TemporaryFile::create([
                    'folder' => $folder,
                    'filename' => $filename,
                ]);
                return $folder;
            }
        }

        if ($request->hasFile('poster'))
        {
            $request->validate([
                'poster.*' => 'mimes:jpg,jpeg,png',
            ]);
            foreach ($request->file('poster') as $file) 
            {
                $filename = uniqid() . '-' . now()->timestamp . '.' .$file->extension();
                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('/public/uploads/tmp/' . $folder, $filename);

                TemporaryFile::create([
                    'folder' => $folder,
                    'filename' => $filename,
                ]);
                return $folder;
            }
        }
        
        return 'not uploaded';
    }
    public function undoUpload(Request $request)
    {
         if ($request->getContent())
         {
            $folder = $request->getContent();
            TemporaryFile::where('folder', $folder)->delete();
            // first delete contents of the directory, but preserve the directory itself
            Storage::deleteDirectory('/public/uploads/tmp/' . $folder, true);
            // sleep 0.5 second because of race condition with HD
            sleep(0.5);
            // actually delete the folder itself
            Storage::deleteDirectory('/public/uploads/tmp/' . $folder);
            return 'file deleted';
         }
         return 'file not deleted';
    }
    /**
     * Private Function to delete temporary directories.
     *
     * @return void
     */
    private function deleteDirectory($folderPath)
    {
        Storage::deleteDirectory($folderPath, true);
        sleep(0.3);
        Storage::deleteDirectory($folderPath);
    }

}
