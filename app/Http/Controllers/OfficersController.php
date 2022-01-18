<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Organization;
use App\Models\PositionTitle;
use App\Models\Officer;
use App\Models\TemporaryFile;

use App\Http\Requests\OfficerRequests\OfficerSignatureStoreRequest;
use App\Services\OfficerServices\OfficerSignatureStoreService;

use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\DataLogServices\DataLogService;
use App\Services\OrganizationDocumentServices\OfficerOrganizationIDService;

class OfficersController extends Controller
{
    protected $viewDirectory = 'officers.';
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

    /**
     * @param String $organizationSlug, Integer $officerID
     * Function to open Create/Update Page for Officer Signature
     * @return View
     */
    public function create($organizationSlug, $officerID)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Manage_Officer_Signatures'), 403);
        abort_if(! Organization::where('organization_slug', $organizationSlug)->exists(), 404);

        $organization = Organization::where('organization_slug', $organizationSlug)
            ->first();
        $officer = Officer::with(['positionTitle'])
            ->whereHas('positionTitle', function(Builder $query) use($organization){
                $query->where('organization_id', $organization->organization_id);
            })
            ->whereHas('positionTitle.positionCategory', function(Builder $query){
                $query->whereIn('position_category', ['President', 'Documentation']);
            })
            ->where('officer_id', $officerID)
            ->first();

        abort_if($officer === NULL, 404);

        $filePondJS = true;

        return view($this->viewDirectory . 'create', compact('organization','officer','filePondJS',));
    }

    /**
     * @param Request $request, String $organizationSlug, Integer $officerID
     * Function to store/update an Officer's Signature
     * @return Redirect
     */
    public function store(OfficerSignatureStoreRequest $request, $organizationSlug, $officerID)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Manage_Officer_Signatures'), 403);
        abort_if(! Organization::where('organization_slug', $organizationSlug)->exists(), 404);

        $organization = Organization::where('organization_slug', $organizationSlug)
            ->first();
        $officer = Officer::with(['positionTitle'])
            ->whereHas('positionTitle', function(Builder $query) use($organization){
                $query->where('organization_id', $organization->organization_id);
            })
            ->whereHas('positionTitle.positionCategory', function(Builder $query){
                $query->whereIn('position_category', ['President', 'Documentation']);
            })
            ->where('officer_id', $officerID)
            ->first();

        abort_if($officer === NULL, 404);

        $message = (new OfficerSignatureStoreService())->store($request, $officer);

        $this->dataLogger->log(Auth::user()->user_id, 'User Updated an Officer\'s Signature.');

        return redirect()->action(
            [OfficersController::class, 'create'], ['organizationSlug' => $organization->organization_slug, 'officerID' => $officer->officer_id])
            ->with($message);
    }

    /**
     * @param String $organizationSlug
     * Function to open Index Page for Organization Officers
     * @return View
     */
    public function index($organizationSlug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Manage_Officer_Signatures'), 403);
        abort_if(! Organization::where('organization_slug', $organizationSlug)->exists(), 404);

        // Get all President and Documentation Officer that has active status
        $positionTitles = PositionTitle::with(['officers' => function($query){
                $query->where('status', 1);}])
            ->whereHas('positionCategory', function(Builder $query){
                $query->whereIn('position_category', ['President', 'Documentation']);
            })
            ->where('organization_id', (new OfficerOrganizationIDService)->getOrganizationID())
            ->get();

        $organization = Organization::where('organization_slug', $organizationSlug)
            ->first();

        return view($this->viewDirectory . 'index', compact('positionTitles', 'organization'));
    }

    /**
     * Function to redirect to Index Page from Sidebar/Home
     * @return Redirect
     */
    public function indexRedirect()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Manage_Officer_Signatures'), 403);

        $organization = Organization::where('organization_id', (new OfficerOrganizationIDService)->getOrganizationID())
            ->first();

        return redirect()->action(
            [OfficersController::class, 'index'], ['organizationSlug' => $organization->organization_slug]);
    }

    /**
     * @param Request $request
     * Function for FilePond JS File Upload 
     * https://pqina.nl/filepond/
     * @return text/plain JSON Response
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('signature'))
        {
            $file = $request->validate([
                'signature' => 'mimes:png'
            ]);
            $file = $request->file('signature');
            $filename = uniqid() . '-' . now()->timestamp . '.' .$file->extension();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('/public/uploads/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);
            return $folder;
        }
        return 'not uploaded';
    }

    /**
     * @param Request $request
     * Function for FilePond JS Reverting File Upload 
     * https://pqina.nl/filepond/docs/api/server/#revert
     * @return empty JSON Response
     */
    public function undoUpload(Request $request)
    {
         if ($request->getContent())
         {
            $folder = $request->getContent();
            TemporaryFile::where('folder', $folder)->delete();
            // first delete contents of the directory, but preserve the directory itself
            Storage::deleteDirectory('/public/uploads/tmp/' . $folder, true);
            // sleep 0.5 second because of race condition with HD
            sleep(0.5);
            // actually delete the folder itself
            Storage::deleteDirectory('/public/uploads/tmp/' . $folder);
            return 'file deleted';
         }
         return 'file not deleted';
    }
    
    
}
