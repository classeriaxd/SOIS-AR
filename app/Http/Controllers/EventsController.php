<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\{
    Event,
    EventImage,
    EventCategory,
    EventRole,
    Level,
    FundSource,
};

use App\Http\Requests\EventRequests\{
    EventStoreRequest,
};

use App\Services\EventServices\{
    EventIndexService,
    EventShowService,
    EventStoreService,
    EventUpdateService,
    EventDeleteService,
    EventGetOrganizationIDService,
    EventGetDocumentTitlesService,
};

class EventsController extends Controller
{
    public function index()
    {
        /*
         * Shows the Index Page of all Events
         */
        $orgAcronym = Auth::user()->course->organization->organization_acronym;
        $eventIndexService = new EventIndexService();
        $events = $eventIndexService->index();
        $simpleDataTables = true;
        return view('events.index', compact('events', 'orgAcronym', 'simpleDataTables'));
    }
    public function show($event_slug, $newEvent = false)
    {
        /*
         * Shows the Specific Event Details
         */
        $eventShowService = new EventShowService();
        $eventGetDocumentTitlesService = new eventGetDocumentTitlesService;
        $event = $eventShowService->show($event_slug);
        $eventDocuments = $eventGetDocumentTitlesService->getDocumentTitles($event->event_id);
        $eventImages = EventImage::where('event_id', $event->event_id)->get();

        return view('events.show',compact('event', 'eventImages', 'eventDocuments', 'newEvent'));
    }
    public function edit($event_slug)
    {
        /*
         * Open up Edit Page for an Event
         */
        if($event = Event::where('slug', $event_slug)->first())
        {
            $eventCategories = EventCategory::all();
            $eventRoles = EventRole::all();
            $levels = Level::all();
            $fundSources = FundSource::all();
            $loadJSWithoutDefer = true;

            return view('events.edit',compact('event', 'eventCategories', 'eventRoles', 'levels', 'fundSources', 'loadJSWithoutDefer'));
        }
        else
            abort(404);
    }
    public function update(EventStoreRequest $request, $event_slug)
    {
        /*
         * Recieve POST request from Edit Page
         */
        $eventUpdateService = new EventUpdateService();
        $updatedEventSlug = $eventUpdateService->update($request, $event_slug);

        return redirect()->route('event.show',['event_slug' => $updatedEventSlug,]);
    }
    public function destroy($event_slug)
    {
        /*
         * Recieve DELETE request to Delete Event
         */
        $eventDeleteService = new EventDeleteService();
        $eventDeleteService->destroy($event_slug);

        return redirect()->route('event.index');
        
    }
    public function create()
    {
        /*
         * Open up Create Page for Event
         */
        $eventCategories = EventCategory::all();
        $eventRoles = EventRole::all();
        $levels = Level::all();
        $fundSources = FundSource::all();
        $loadJSWithoutDefer = true;

    	return view('events.create', compact(
            'eventCategories', 
            'eventRoles', 
            'levels', 
            'fundSources', 
            'loadJSWithoutDefer'));
    }
    public function store(EventStoreRequest $request)
    {
        /*
         * Recieve POST request to Store Event
         */
        $eventStoreService = new EventStoreService();
        $eventGetOrganizationID = new EventGetOrganizationIDService();
        $organizationID = $eventGetOrganizationID->getOrganizationID();
        $event_slug = $eventStoreService->store($request, $organizationID);

        return redirect()->route('event.show',['event_slug' => $event_slug, 'newEvent' => true,]);
    }
    /**
     * Find Function for Bloodhound and TypeAheadJS
     , 
                
     */
    public function findEvent(Request $request)
    {
        $events = Event::search($request->get('event'))
            ->select('title',
                DB::raw('DATE_FORMAT(start_date, "%M %Y") as start_date'))
            ->orderby('start_date', 'DESC')
            ->get();
        if($events != NULL)
            return $events;
        else 
            return NULL;
    }
    // Notes
    //https://github.com/laravel/framework/issues/14997#issuecomment-242129087
}
