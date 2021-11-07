<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

use App\Models\EventNature;
use App\Http\Requests\Admin\EventMaintenance\EventNature\{
    EventNatureStoreRequest,
    EventNatureUpdateRequest,
    EventNatureDeleteRequest,
};
use App\Services\Admin\EventMaintenance\EventNature\{
    EventNatureStoreService,
    EventNatureUpdateService,
    EventNatureDeleteService,
};

use App\Http\Controllers\Controller as Controller;

class EventNatureMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.eventNature.';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $eventNatures = EventNature::all();
        return view($this->viewDirectory . 'index', compact('eventNatures',));
    }
    
    public function create()
    {
        return view($this->viewDirectory . 'create',);
    }

    public function store(EventNatureStoreRequest $request)
    {
        $message = (new EventNatureStoreService())->store($request);

        return redirect()->action(
            [EventNatureMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($nature_id)
    {
        $eventNature = $this->checkIfNatureExists($nature_id);

        return view($this->viewDirectory . 'edit', compact('eventNature'));
    }

    public function update(EventNatureUpdateRequest $request, $nature_id)
    {
        $eventNature = $this->checkIfNatureExists($nature_id);

        $message = (new EventNatureUpdateService())->update($eventNature, $request);

        return redirect()->action(
            [EventNatureMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($nature_id)
    {
        $eventNature = $this->checkIfNatureExists($nature_id);
        
        return view($this->viewDirectory . 'show', compact('eventNature'));
    }

    public function destroy(EventNatureDeleteRequest $request, $nature_id)
    {
        $eventNature = $this->checkIfNatureExists($nature_id);

        $message = (new EventNatureDeleteService())->delete($eventNature, $request);

        return redirect()->action(
            [EventNatureMaintenanceController::class, 'index'])
            ->with($message);
    }

    /**
     * @param Integer $nature_id
     * Function to check if a nature id exists, sends 404 if not
     * @return Collection
     */ 
    private function checkIfNatureExists($nature_id)
    {
        abort_if(! $eventNature = EventNature::where('event_nature_id', $nature_id)->first(), 404);

        return $eventNature;
    }
}
