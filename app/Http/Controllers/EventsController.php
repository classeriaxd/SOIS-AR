<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\{
    Event,
    EventCategory,
    EventRole,
    EventClassification,
    EventNature,
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
};

class EventsController extends Controller
{
    /**
     * Shows the Index Page of all Events
     * @return View
     */
    public function index()
    {
        $orgAcronym = Auth::user()->course->organization->organization_acronym;
        $events = (new EventIndexService())->index();
        $simpleDataTables = true;
        return view('events.index', compact('events', 'orgAcronym', 'simpleDataTables'));
    }

    /**
     * @param String $event_slug, Boolean $newEvent
     * Shows the Specific Event Details
     * @return View
     */
    public function show($event_slug, $newEvent = false)
    {
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = (new EventShowService())->show($event_slug);
        $loadJSWithoutDefer = true;
        return view('events.show',compact('event', 'newEvent', 'loadJSWithoutDefer'));
    }

    /**
     * @param String $event_slug
     * Open up Edit Page for an Event
     * @return View
     */
    public function edit($event_slug)
    {
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::with('eventCategory', 'eventRole')->where('slug', $event_slug)->first();
        $eventCategories = EventCategory::all();
        $eventRoles = EventRole::all();
        $eventClassifications = EventClassification::all();
        $eventNatures = EventNature::all();
        $levels = Level::all();
        $fundSources = FundSource::all();
        $loadJSWithoutDefer = true;
        //dd($event);
        return view('events.edit',compact('event', 'eventCategories', 'eventRoles', 'levels', 'fundSources', 'loadJSWithoutDefer'));
        
    }

    /**
     * @param Request $request, String $event_slug
     * Function to Update an event
     * @return Redirect
     */
    public function update(EventStoreRequest $request, $event_slug)
    {
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $returnArray = (new EventUpdateService())->update($request, $event_slug);
        $message = $returnArray['message'];

        if ($returnArray['eventSlug'] == NULL) {
            return redirect()->action(
                [EventsController::class, 'index'])
                ->with($message);
        }
        else
            return redirect()->action(
                [EventsController::class, 'show'], ['event_slug' => $returnArray['eventSlug']])
                ->with($message);
    }

    /**
     * @param String $event_slug
     * Function to Open Event Creation Page
     * @return View 
     */ 
    public function destroy($event_slug)
    {
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $message = (new EventDeleteService())->destroy($event_slug);

        return redirect()->action(
                [EventsController::class, 'index'])
                ->with($message);
    }

    /**
     * Function to Open Event Creation Page
     * @return View 
     */ 
    public function create()
    {
        $eventCategories = EventCategory::all();
        $eventRoles = EventRole::all();
        $eventClassifications = EventClassification::all();
        $eventNatures = EventNature::all();
        $levels = Level::all();
        $fundSources = FundSource::all();

    	return view('events.create', compact(
            'eventCategories', 
            'eventRoles', 
            'eventClassifications',
            'eventNatures',
            'levels', 
            'fundSources',));
    }

    /**
     * @param Request $request
     * Function to Store Event
     * @return Redirect
     */
    public function store(EventStoreRequest $request)
    {
        $organizationID = (new EventGetOrganizationIDService())->getOrganizationID();
        $returnArray = (new EventStoreService())->store($request, $organizationID);
        $message = $returnArray['message'];

        if ($returnArray['eventSlug'] == NULL) {
            return redirect()->action(
                [EventsController::class, 'index'])
                ->with($message);
        }
        else
            return redirect()->action(
                [EventsController::class, 'show'], ['event_slug' => $returnArray['eventSlug'], 'newEvent' => true])
                ->with($message);
    }

    /**
     * @param Request $request
     * Find Function for Bloodhound and TypeAheadJS  
     * @return Collection $events
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
