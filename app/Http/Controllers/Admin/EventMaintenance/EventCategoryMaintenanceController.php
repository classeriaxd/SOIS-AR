<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

use App\Models\EventCategory;
use App\Http\Requests\Admin\EventMaintenance\EventCategory\{
    EventCategoryStoreRequest,
    EventCategoryUpdateRequest,
    EventCategoryDeleteRequest,
};
use App\Services\Admin\EventMaintenance\EventCategory\{
    EventCategoryStoreService,
    EventCategoryUpdateService,
    EventCategoryDeleteService,
};

use App\Http\Controllers\Controller as Controller;

class EventCategoryMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.eventCategory.';

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
        $eventCategories = EventCategory::all();
        return view($this->viewDirectory . 'index', compact('eventCategories',));
    }
    
    public function create()
    {
        return view($this->viewDirectory . 'create',);
    }

    public function store(EventCategoryStoreRequest $request)
    {
        $message = (new EventCategoryStoreService())->store($request);
        
        return redirect()->action(
            [EventCategoryMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($category_id)
    {
        $eventCategory = $this->checkIfCategoryExists($category_id);

        return view($this->viewDirectory . 'edit', compact('eventCategory'));
    }

    public function update(EventCategoryUpdateRequest $request, $category_id)
    {
        $eventCategory = $this->checkIfCategoryExists($category_id);

        $message = (new EventCategoryUpdateService())->update($eventCategory, $request);

        return redirect()->action(
            [EventCategoryMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($category_id)
    {
        $eventCategory = $this->checkIfCategoryExists($category_id);
        
        return view($this->viewDirectory . 'show', compact('eventCategory'));
    }

    public function destroy(EventCategoryDeleteRequest $request, $category_id)
    {
        $eventCategory = $this->checkIfCategoryExists($category_id);

        $message = (new EventCategoryDeleteService())->delete($eventCategory, $request);

        return redirect()->action(
            [EventCategoryMaintenanceController::class, 'index'])
            ->with($message);
    }

    /**
     * @param Integer $category_id
     * Function to check if a category id exists, sends 404 if not
     * @return Collection
     */ 
    private function checkIfCategoryExists($category_id)
    {
        abort_if(! $eventCategory = EventCategory::where('event_category_id', $category_id)->first(), 404);

        return $eventCategory;
    }
}
