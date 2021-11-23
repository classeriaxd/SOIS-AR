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
    EventUpdateRequest,
};

use App\Services\EventServices\{
    EventIndexService,
    EventShowService,
    EventStoreService,
    EventUpdateService,
    EventDeleteService,
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
        return view('events.index', compact('events', 'orgAcronym'));
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
        return view('events.show',compact('event', 'newEvent',));
    }

    /**
     * @param String $event_slug
     * Open up Edit Page for an Event
     * @return View
     */
    public function edit($event_slug)
    {
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::with(
                'eventCategory:event_category_id,category,deleted_at', 
                'eventRole:event_role_id,event_role,deleted_at', 
                'eventLevel:level_id,level,deleted_at', 
                'eventFundSource:fund_source_id,fund_source,deleted_at',
                'eventNature:event_nature_id,nature,deleted_at',
                'eventClassification:event_classification_id,classification,deleted_at',)
            ->where('slug', $event_slug)->first();

        $eventCategories = EventCategory::all();
        $eventClassifications = EventClassification::all();
        $eventNatures = EventNature::all();
        $eventRoles = EventRole::all();
        $fundSources = FundSource::all();
        $levels = Level::all();
        
        return view('events.edit',compact(
            'event', 
            'eventCategories', 
            'eventRoles', 
            'eventNatures',
            'eventClassifications',
            'levels', 
            'fundSources'));
        
    }

    /**
     * @param Request $request, String $event_slug
     * Function to Update an event
     * @return Redirect
     */
    public function update(EventUpdateRequest $request, $event_slug)
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
        $eventClassifications = EventClassification::all();
        $eventNatures = EventNature::all();
        $eventRoles = EventRole::all();
        $fundSources = FundSource::all();
        $levels = Level::all();

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
        $returnArray = (new EventStoreService())->store($request);
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
