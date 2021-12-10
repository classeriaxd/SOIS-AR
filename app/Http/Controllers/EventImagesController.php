<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventImage;
use App\Models\TemporaryFile;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Http\Requests\EventImageRequests\{
    EventImageStoreRequest,
    EventImageStoreCaptionRequest,
    EventImageUpdateRequest,
};

use App\Services\EventServices\EventImageServices\{
    EventImageStoreService,
    EventImageStoreCaptionService,
    EventImageUpdateService,
    EventImageDeleteService,
    EventImageRestoreService,
};

use App\Services\PermissionServices\PermissionCheckingService;

class EventImagesController extends Controller
{
    protected $permissionChecker;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->permissionChecker = new PermissionCheckingService();
    }

    /**
     * @param String $event_slug
     * Function to show Index Page of all Event Images
     * @return View
     */
    public function index($event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Event_Image'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::with('eventImages')
            ->where('slug', $event_slug)->first();
        $posters = $event->eventImages->where('image_type', 0);
        $evidences = $event->eventImages->where('image_type', 1);
        $deletedEventImages = EventImage::onlyTrashed()
            ->where('accomplished_event_id', $event->accomplished_event_id)
            ->get();
        return view('events.eventimages.index',compact('event','posters','evidences', 'deletedEventImages'));
    }

    /**
     * @param String $event_slug, String $eventImage_slug
     * Function to show a single Event Image
     * @return View
     */
    public function show($event_slug, $eventImage_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Event_Image'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);
        abort_if(! EventImage::where('slug', $eventImage_slug)->exists(), 404);

        $event = Event::with([
            'eventImage' => function ($query) use ($eventImage_slug) {
                $query->where('slug', $eventImage_slug);},
            ])
            ->where('slug', $event_slug)->first();
        return view('events.eventimages.show',compact('event'));
    }

    /**
     * @param String $event_slug, String $eventImage_slug
     * Function to edit an Event Image
     * @return View
     */
    public function edit($event_slug, $eventImage_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Edit_Event_Image'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);
        abort_if(! EventImage::where('slug', $eventImage_slug)->exists(), 404);

        $event = Event::with([
            'eventImage' => function ($query) use ($eventImage_slug) {
                $query->where('slug', $eventImage_slug);},
            ])
        ->where('slug', $event_slug)->first();

    	return view('events.eventimages.edit', compact('event'));
    }

    /**
     * @param Request $request, String $event_slug, String $eventImage_slug
     * Function to update an Event Image
     * @return Redirect
     */
    public function update(EventImageUpdateRequest $request, $event_slug, $eventImage_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Edit_Event_Image'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);
        abort_if(! EventImage::where('slug', $eventImage_slug)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();

        $message = (new EventImageUpdateService())->update($request, $event, $eventImage_slug);

        return redirect()->action(
            [EventImagesController::class, 'show'], ['event_slug' => $event_slug, 'eventImage_slug' => $eventImage_slug])
            ->with($message);
    }

    /**
     * @param String $event_slug, String $eventImage_slug
     * Function to soft delete an Event Image
     * @return Redirect
     */
    public function destroy($event_slug, $eventImage_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Delete_Event_Image'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);
        abort_if(! EventImage::where('slug', $eventImage_slug)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();

        $message = (new EventImageDeleteService())->destroy($event, $eventImage_slug);

        return redirect()->action(
            [EventImagesController::class, 'index'], ['event_slug' => $event->slug])
            ->with($message);
    }

    /**
     * @param String $event_slug, String $eventImage_slug
     * Function to restore soft deleted Event Image
     * @return Redirect
     */
    public function restore($event_slug, $eventImage_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Delete_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);
        abort_if(! EventImage::withTrashed()->where('slug', $eventImage_slug)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();

        $message = (new EventImageRestoreService())->restore($event, $eventImage_slug);

        return redirect()->action(
            [EventImagesController::class, 'index'], ['event_slug' => $event->slug])
            ->with($message);
    }
    
    /**
     * @param String $event_slug
     * Function to show Create Page for Event Image
     * @return View
     */
    public function create($event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Event_Image'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();
        $filePondJS = true;
        return view('events.eventimages.create', compact('event', 'filePondJS'));
    }

    /**
     * @param String $event_slug
     * Function to show Create Caption Page for Event Image, requires call from Store Function
     * @return View | Redirect if not called from Store Function
     */
    public function createCaption($event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Event_Image'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        // If there is Inserted Image ID Array in Session data...
        if(session()->has('eventImagesArray'))
        {
            $event = Event::where('slug', $event_slug)->first();
            $eventImages['posters'] = collect();
            $eventImages['evidences'] = collect();

            // Get Inserted Image IDs from array on Session
            $eventImagesArray = session()->get('eventImagesArray');
            session()->keep(['eventImagesArray']);

            // Get Inserted Images
            $eventImages['posters'] = EventImage::where('image_type', 0)
                ->where('accomplished_event_id', $event->accomplished_event_id)
                ->whereIn('event_image_id', $eventImagesArray)
                ->get();
            $eventImages['evidences'] = EventImage::where('image_type', 1)
                ->where('accomplished_event_id', $event->accomplished_event_id)
                ->whereIn('event_image_id', $eventImagesArray)
                ->get();

            return view('events.eventimages.createCaption', compact('event','eventImages'));
        }
        else
            return redirect()->action(
                [EventsController::class, 'show'], ['event_slug' => $event->slug])
                ->with(array('error' => 'No Image Uploaded.'));
    }

    /**
     * @param Request $request, String $event_slug
     * Function to store Event Images
     * @return Redirect
     */
    public function store(EventImageStoreRequest $request, $event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Event_Image'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();
    	$returnArray = (new EventImageStoreService())->store($request, $event);

        if($returnArray['insertedImagesCount'] > 0)
        {   
            session()->flash('eventImagesArray', $returnArray['insertedImages']);
            return redirect()->action(
                [EventImagesController::class, 'createCaption'], ['event_slug' => $event->slug,])
                ->with($returnArray['message']);
        }
        else
            return redirect()->action(
                [EventsController::class, 'show'], ['event_slug' => $event->slug])
                ->with($returnArray['message']);
    }

    /**
     * @param Request $request, String $event_slug
     * Function to store captions for Event Images
     * @return Redirect
     */

    public function storeCaption(EventImageStoreCaptionRequest $request, $event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Event_Image'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();

        $message = (new EventImageStoreCaptionService())->storeCaption($request, $event);
        
        return redirect()->action(
            [EventsController::class, 'show'], ['event_slug' => $event->slug])
            ->with($message);
    }

    /**
     * @param Request $request
     * Function for FilePond JS File Upload 
     * https://pqina.nl/filepond/
     * @return text/plain JSON Response
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

    /**
     * @param Request $request
     * Function for FilePond JS Reverting File Upload 
     * https://pqina.nl/filepond/docs/api/server/#revert
     * @return empty JSON Response
     */
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

    

}
