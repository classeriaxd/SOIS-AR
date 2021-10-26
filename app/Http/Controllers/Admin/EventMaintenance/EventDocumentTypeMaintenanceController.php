<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

use App\Models\EventDocumentType;
use App\Http\Requests\Admin\EventMaintenance\EventDocumentType\{
    EventDocumentTypeStoreRequest,
    EventDocumentTypeUpdateRequest,
    EventDocumentTypeDeleteRequest,
};
use App\Services\Admin\EventMaintenance\EventDocumentType\{
    EventDocumentTypeStoreService,
    EventDocumentTypeUpdateService,
    EventDocumentTypeDeleteService,
};

use App\Http\Controllers\Controller as Controller;

class EventDocumentTypeMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.eventDocumentType.';

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
        $documentTypes = EventDocumentType::all();
        return view($this->viewDirectory . 'index', compact('documentTypes',));
    }
    
    public function create()
    {
        return view($this->viewDirectory . 'create',);
    }

    public function store(EventDocumentTypeStoreRequest $request)
    {
        $message = (new EventDocumentTypeStoreService())->store($request);

        return redirect()->action(
            [EventDocumentTypeMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($document_type_id)
    {
        $documentType = $this->checkIfDocumentTypeExists($document_type_id);

        return view($this->viewDirectory . 'edit', compact('documentType'));
    }

    public function update(EventDocumentTypeUpdateRequest $request, $document_type_id)
    {
        $documentType = $this->checkIfDocumentTypeExists($document_type_id);

        $message = (new EventDocumentTypeUpdateService())->update($documentType, $request);

        return redirect()->action(
            [EventDocumentTypeMaintenanceController::class, 'index'])
            ->with($message);

    }

    public function show($document_type_id)
    {
        $documentType = $this->checkIfDocumentTypeExists($document_type_id);
        
        return view($this->viewDirectory . 'show', compact('documentType'));
    }

    public function destroy(EventDocumentTypeDeleteRequest $request, $document_type_id)
    {
        $documentType = $this->checkIfDocumentTypeExists($document_type_id);

        $message = (new EventDocumentTypeDeleteService())->delete($documentType, $request);

        return redirect()->action(
            [EventDocumentTypeMaintenanceController::class, 'index'])
            ->with($message);
    }

    /**
     * @param Integer $document_type_id
     * Function to check if a document type id exists, sends 404 if not
     * @return Collection
     */ 
    private function checkIfDocumentTypeExists($document_type_id)
    {
        abort_if(! $documentType = EventDocumentType::where('event_document_type_id', $document_type_id)->first(), 404);

        return $documentType;
    }
}
