<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Organization;
use App\Models\OrganizationDocumentType;
use App\Http\Requests\OrganizationDocumentRequests\OrganizationDocumentTypeMaintenanceRequests\{
    OrganizationDocumentTypeStoreRequest,
    OrganizationDocumentTypeUpdateRequest,
};
use App\Services\OrganizationDocumentServices\OrganizationDocumentTypeMaintenanceServices\{
    OrganizationDocumentTypeStoreService,
    OrganizationDocumentTypeUpdateService,
    OrganizationDocumentTypeDeleteService,
    OrganizationDocumentTypeRestoreService,
};
use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\EventServices\EventGetOrganizationIDService;
use App\Services\DataLogServices\DataLogService;

class OrganizationDocumentTypesController extends Controller
{
    protected $viewDirectory = 'organizationDocuments.organizationDocumentTypes.';
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

    public function index($organizationSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Organization_Document_Type'), 403);
        abort_if(! Organization::where('organization_slug', $organizationSlug)->exists(), 404);

        $organization = Organization::where('organization_slug', $organizationSlug)->first();
        abort_if($organization->organization_id !== (new EventGetOrganizationIDService())->getOrganizationID(), 403);

        $organizationDocumentTypes = OrganizationDocumentType::withCount('organizationDocuments')
            ->where('organization_id', $organization->organization_id)
            ->get();
        $deletedOrganizationDocumentTypes = OrganizationDocumentType::onlyTrashed()
            ->withCount('organizationDocuments')
            ->where('organization_id', $organization->organization_id)
            ->get();
        //dd($organizationDocumentTypes);
        return view($this->viewDirectory . 'index', compact('organization','organizationDocumentTypes','deletedOrganizationDocumentTypes'));
    }
    
    public function create($organizationSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Organization_Document_Type'), 403);
        abort_if(! Organization::where('organization_slug', $organizationSlug)->exists(), 404);

        $organization = Organization::where('organization_slug', $organizationSlug)->first();
        abort_if($organization->organization_id !== (new EventGetOrganizationIDService())->getOrganizationID(), 403);

        return view($this->viewDirectory . 'create', compact('organization'));
    }

    public function store(OrganizationDocumentTypeStoreRequest $request, $organizationSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Organization_Document_Type'), 403);
        abort_if(! Organization::where('organization_slug', $organizationSlug)->exists(), 404);

        $message = (new OrganizationDocumentTypeStoreService())->store($request, $organizationSlug);

        $this->dataLogger->log(Auth::user()->user_id, 'User Created an Organization Document Type.');

        return redirect()->action(
            [OrganizationDocumentTypesController::class, 'index'], ['organizationSlug' => $organizationSlug])
            ->with($message);
    }

    public function edit($organizationSlug, $organizationDocumentTypeSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Edit_Organization_Document_Type'), 403);
        abort_if(! Organization::where('organization_slug', $organizationSlug)->exists(), 404);
        $organization = Organization::where('organization_slug', $organizationSlug)->first();
        abort_if($organization->organization_id !== (new EventGetOrganizationIDService())->getOrganizationID(), 403);

        abort_if(! OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->exists(), 404);
        $organizationDocumentType = OrganizationDocumentType::where('organization_id', $organization->organization_id)->where('slug', $organizationDocumentTypeSlug)->first();

        return view($this->viewDirectory . 'edit', compact('organization', 'organizationDocumentType'));
    }

    public function update(OrganizationDocumentTypeUpdateRequest $request, $organizationSlug, $organizationDocumentTypeSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Edit_Organization_Document_Type'), 403);
        abort_if(! Organization::where('organization_slug', $organizationSlug)->exists(), 404);
        $organization = Organization::where('organization_slug', $organizationSlug)->first();
        abort_if($organization->organization_id !== (new EventGetOrganizationIDService())->getOrganizationID(), 403);

        abort_if(! OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->exists(), 404);

        $message = (new OrganizationDocumentTypeUpdateService())->update($request, $organization, $organizationDocumentTypeSlug);

        $this->dataLogger->log(Auth::user()->user_id, 'User Updated an Organization Document Type.');

        return redirect()->action(
            [OrganizationDocumentTypesController::class, 'index'], ['organizationSlug' => $organizationSlug])
            ->with($message);
    }

    public function show($organizationSlug, $organizationDocumentTypeSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Organization_Document_Type'), 403);
        abort_if(! Organization::where('organization_slug', $organizationSlug)->exists(), 404);
        $organization = Organization::where('organization_slug', $organizationSlug)->first();
        abort_if($organization->organization_id !== (new EventGetOrganizationIDService())->getOrganizationID(), 403);

        abort_if(! OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->exists(), 404);
        $organizationDocumentType = OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->first();

        return view($this->viewDirectory . 'show', compact('organization', 'organizationDocumentType'));
    }

    public function destroy($organizationSlug, $organizationDocumentTypeSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Delete_Organization_Document_Type'), 403);
        abort_if(! Organization::where('organization_slug', $organizationSlug)->exists(), 404);
        $organization = Organization::where('organization_slug', $organizationSlug)->first();
        abort_if($organization->organization_id !== (new EventGetOrganizationIDService())->getOrganizationID(), 403);

        abort_if(! OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->exists(), 404);

        $message = (new OrganizationDocumentTypeDeleteService())->delete($organization, $organizationDocumentTypeSlug);

        $this->dataLogger->log(Auth::user()->user_id, 'User Deleted an Organization Document Type.');

        return redirect()->action(
            [OrganizationDocumentTypesController::class, 'index'], ['organizationSlug' => $organizationSlug])
            ->with($message);
    }

    public function restore($organizationSlug, $organizationDocumentTypeSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Delete_Organization_Document_Type'), 403);
        abort_if(! Organization::where('organization_slug', $organizationSlug)->exists(), 404);
        $organization = Organization::where('organization_slug', $organizationSlug)->first();
        abort_if($organization->organization_id !== (new EventGetOrganizationIDService())->getOrganizationID(), 403);

        abort_if(! OrganizationDocumentType::onlyTrashed()->where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->exists(), 404);

        $message = (new OrganizationDocumentTypeRestoreService())->restore($organization, $organizationDocumentTypeSlug);

        $this->dataLogger->log(Auth::user()->user_id, 'User Restored an Organization Document Type.');

        return redirect()->action(
            [OrganizationDocumentTypesController::class, 'index'], ['organizationSlug' => $organizationSlug])
            ->with($message);
    }
}
