<?php

namespace App\Http\Controllers\Admin\EventMaintenance;

use Illuminate\Support\Facades\Auth;

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
    EventDocumentTypeRestoreService,
};

use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\DataLogServices\DataLogService;

use App\Http\Controllers\Controller as Controller;

class EventDocumentTypeMaintenanceController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.event.eventDocumentType.';
    protected $permissionChecker;
    protected $dataLogger;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->permissionChecker = new PermissionCheckingService();
        $this->dataLogger = new DataLogService();
    }

    public function index()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $documentTypes = EventDocumentType::all();
        $deletedDocumentTypes = EventDocumentType::onlyTrashed()->get();
        return view($this->viewDirectory . 'index', compact('documentTypes','deletedDocumentTypes'));
    }
    
    public function create()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        return view($this->viewDirectory . 'create',);
    }

    public function store(EventDocumentTypeStoreRequest $request)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);

        $message = (new EventDocumentTypeStoreService())->store($request);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Created an Event Document Type.');

        return redirect()->action(
            [EventDocumentTypeMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function edit($document_type_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $documentType = $this->checkIfDocumentTypeExists($document_type_id);

        return view($this->viewDirectory . 'edit', compact('documentType'));
    }

    public function update(EventDocumentTypeUpdateRequest $request, $document_type_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $documentType = $this->checkIfDocumentTypeExists($document_type_id);

        $message = (new EventDocumentTypeUpdateService())->update($documentType, $request);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Updated an Event Document Type.');

        return redirect()->action(
            [EventDocumentTypeMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function show($document_type_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $documentType = $this->checkIfDocumentTypeExists($document_type_id);
        
        return view($this->viewDirectory . 'show', compact('documentType'));
    }

    public function destroy(EventDocumentTypeDeleteRequest $request, $document_type_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $documentType = $this->checkIfDocumentTypeExists($document_type_id);

        $message = (new EventDocumentTypeDeleteService())->delete($documentType, $request);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Deleted an Event Document Type.');

        return redirect()->action(
            [EventDocumentTypeMaintenanceController::class, 'index'])
            ->with($message);
    }

    public function restore($document_type_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Event'), 403);
        $documentType = $this->checkIfDocumentTypeExists($document_type_id);

        $message = (new EventDocumentTypeRestoreService())->restore($documentType);

        $this->dataLogger->log(Auth::user()->user_id, Auth::user()->roles->first()->role . ' Restored an Event Document Type.');

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
        abort_if(! $documentType = EventDocumentType::withTrashed()->where('event_document_type_id', $document_type_id)->first(), 404);

        return $documentType;
    }
}
