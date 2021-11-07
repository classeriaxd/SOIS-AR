<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

use App\Models\EventClassification;
use App\Http\Requests\Admin\EventMaintenance\EventClassification\{
    EventClassificationStoreRequest,
    EventClassificationUpdateRequest,
    EventClassificationDeleteRequest,
};
use App\Services\Admin\EventMaintenance\EventClassification\{
    EventClassificationStoreService,
    EventClassificationUpdateService,
    EventClassificationDeleteService,
};

use App\Http\Controllers\Controller as Controller;

class EventClassificationMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.eventClassification.';

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
        $eventClassifications = EventClassification::all();
        return view($this->viewDirectory . 'index', compact('eventClassifications',));
    }
    
    public function create()
    {
        return view($this->viewDirectory . 'create',);
    }

    public function store(EventClassificationStoreRequest $request)
    {
        $message = (new EventClassificationStoreService())->store($request);

        return redirect()->action(
            [EventClassificationMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($classification_id)
    {
        $eventClassification = $this->checkIfClassificationExists($classification_id);

        return view($this->viewDirectory . 'edit', compact('eventClassification'));
    }

    public function update(EventClassificationUpdateRequest $request, $classification_id)
    {
        $eventClassification = $this->checkIfClassificationExists($classification_id);

        $message = (new EventClassificationUpdateService())->update($eventClassification, $request);

        return redirect()->action(
            [EventClassificationMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($classification_id)
    {
        $eventClassification = $this->checkIfClassificationExists($classification_id);
        
        return view($this->viewDirectory . 'show', compact('eventClassification'));
    }

    public function destroy(EventClassificationDeleteRequest $request, $classification_id)
    {
        $eventClassification = $this->checkIfClassificationExists($classification_id);

        $message = (new EventClassificationDeleteService())->delete($eventClassification, $request);

        return redirect()->action(
            [EventClassificationMaintenanceController::class, 'index'])
            ->with($message);
    }

    /**
     * @param Integer $classification_id
     * Function to check if a classification id exists, sends 404 if not
     * @return Collection
     */ 
    private function checkIfClassificationExists($classification_id)
    {
        abort_if(! $eventClassification = EventClassification::where('event_classification_id', $classification_id)->first(), 404);

        return $eventClassification;
    }
}
