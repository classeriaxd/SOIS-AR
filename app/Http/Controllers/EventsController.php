<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\{
    Event,
    EventCategory,
    EventRole,
    EventClassification,
    EventNature,
    Level,
    FundSource,
    Organization,
    UpcomingEvent,
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
    EventRestoreService,
    EventGetOrganizationIDService,
};
use App\Services\PermissionServices\PermissionCheckingService;

class EventsController extends Controller
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
     * Function to show the Index Page of all Events
     * @return View
     */
    public function index()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Event'), 403);
        $organizationID = (new EventGetOrganizationIDService)->getOrganizationID();
        $orgAcronym = Organization::where('organization_id', $organizationID)->value('organization_acronym');
        $events = Event::with('eventRole',
                'eventCategory',
                'eventLevel',)
            ->where('organization_id', $organizationID,)
            ->orderByRaw('MONTH(`start_date`) ASC, `start_date` ASC')
            ->paginate(30, ['*'], 'events');

        $deletedEvents = Event::onlyTrashed()
            ->with('eventRole',
                'eventCategory',
                'eventLevel',)
            ->where('organization_id', $organizationID,)
            ->orderByRaw('MONTH(`start_date`) ASC, `start_date` ASC')
            ->paginate(30, ['*'], 'deletedEvents');

        $accomplishedEventsCount = UpcomingEvent::whereNull('accomplished_event_id')
            ->where('organization_id', $organizationID)
            ->where('advisers_approval', 'approved')
            ->where('studAffairs_approval', 'approved')
            ->where('completion_status', 'accomplished')
            ->count();
        return view('events.index', compact('events', 'orgAcronym', 'deletedEvents', 'accomplishedEventsCount'));
    }

    /**
     * @param String $event_slug, Boolean $newEvent
     * Function to shows the Specific Event
     * @return View
     */
    public function show($event_slug, $newEvent = false)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Event'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = (new EventShowService())->show($event_slug);
        $eventPosters = $event->eventImages->where('image_type', 0);
        $eventEvidences = $event->eventImages->where('image_type', 1);
        return view('events.show',compact('event', 'newEvent', 'eventPosters', 'eventEvidences'));
    }

    /**
     * @param String $event_slug
     * Open up Edit Page for an Event
     * @return View
     */
    public function edit($event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Edit_Event'), 403);
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
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Edit_Event'), 403);
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
     * Function to soft delete an Event
     * @return View 
     */ 
    public function destroy($event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Delete_Event'), 403);
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
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Event'), 403);
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
     * Function to Store an Event
     * @return Redirect
     */
    public function store(EventStoreRequest $request)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Event'), 403);
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
     * @param String $event_slug
     * Function to restore soft deleted Event
     * @return Redirect
     */
    public function restore($event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Delete_Event'), 403);
        abort_if(! Event::onlyTrashed()->where('slug', $event_slug)->exists(), 404);

        $message = (new EventRestoreService())->restore($event_slug);

        return redirect()->action(
            [EventsController::class, 'index'])
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

    /**
     * Function to show all GPOA Events that are not in AR
     * @return View
     */
    public function gpoaIndex()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Event'), 403);
        $organizationID = (new EventGetOrganizationIDService)->getOrganizationID();
        $orgAcronym = Organization::where('organization_id', $organizationID)->value('organization_acronym');
        $accomplishedEvents = UpcomingEvent::whereNull('accomplished_event_id')
            ->where('organization_id', $organizationID)
            ->where('advisers_approval', 'approved')
            ->where('studAffairs_approval', 'approved')
            ->where('completion_status', 'accomplished')
            ->paginate(30, ['*'], 'accomplishedEvents');

        return view('events.gpoa.index', compact('orgAcronym', 'accomplishedEvents'));
    }

    /**
     * Function to show Create Page with prefilled GPOA Data
     * @return View
     */ 
    public function gpoaCreate($gpoaID)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Event'), 403);
        $organizationID = (new EventGetOrganizationIDService)->getOrganizationID();
        abort_if(! UpcomingEvent::where('upcoming_event_id', $gpoaID)->where('organization_id', $organizationID)->exists(), 404);

        $accomplishedEvent = UpcomingEvent::where('upcoming_event_id', $gpoaID)
            ->where('organization_id', $organizationID)
            ->first();

        if ($accomplishedEvent->accomplished_event_id !== NULL)
        {
            $event = Event::where('accomplished_event_id', $accomplishedEvent->accomplished_event_id)->first();
            return redirect()->action(
                [EventsController::class, 'show'], ['event_slug' => $event->slug]);
        }

        $eventCategories = EventCategory::all();
        $eventClassifications = EventClassification::all();
        $eventNatures = EventNature::all();
        $eventRoles = EventRole::all();
        $fundSources = FundSource::all();
        $levels = Level::all();

        return view('events.gpoa.create', compact(
            'accomplishedEvent',
            'eventCategories', 
            'eventRoles', 
            'eventClassifications',
            'eventNatures',
            'levels', 
            'fundSources',));
    }

}
