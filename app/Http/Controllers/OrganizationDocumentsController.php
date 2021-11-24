<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use App\Models\OrganizationDocument;
use App\Models\OrganizationDocumentType;
use App\Models\TemporaryFile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Services\OrganizationDocumentServices\{
    OfficerOrganizationIDService,
    OrganizationDocumentStoreService,
    OrganizationDocumentUpdateService,
    OrganizationDocumentDeleteService,
};
use App\Http\Requests\OrganizationDocumentRequests\{
    OrganizationDocumentStoreRequest,
    OrganizationDocumentUpdateRequest,
};

class OrganizationDocumentsController extends Controller
{
    protected $viewDirectory = 'organizationDocuments.';
    protected $temporaryFolderDirectory = '/public/uploads/tmp/';

    public function index($organizationSlug)
    {
        // Only Documentation Officer Allowed
        abort_if(! Organization::where('organization_slug', $organizationSlug)->where('organization_id', (new OfficerOrganizationIDService())->getOrganizationID())->exists(), 404);

        $organization = Organization::where('organization_slug', $organizationSlug)->first();
        $organizationDocumentTypes = OrganizationDocumentType::with('organizationDocumentsForDisplay:organization_document_type_id,organization_document_id,title,created_at')
            ->where('organization_id', (new OfficerOrganizationIDService())->getOrganizationID())
            ->get();

        return view($this->viewDirectory . 'index', compact('organization', 'organizationDocumentTypes'));
    }

    public function documentTypeIndex($organizationSlug, $organizationDocumentTypeSlug)
    {
        // Only Documentation Officer Allowed
        abort_if(! Organization::where('organization_slug', $organizationSlug)->where('organization_id', (new OfficerOrganizationIDService())->getOrganizationID())->exists(), 404);
        $organization = Organization::where('organization_slug', $organizationSlug)->first();

        abort_if(! OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->exists(), 404);
        $organizationDocumentType = OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)
            ->where('organization_id', $organization->organization_id)
            ->first();

        $organizationDocuments = OrganizationDocument::with([
            'documentType' => function($query) use ($organization, $organizationDocumentTypeSlug){
                $query->where('organization_id', $organization->organization_id);}])
            ->where('organization_document_type_id', $organizationDocumentType->organization_document_type_id)
            ->orderBy('created_at', 'DESC')
            ->paginate(30, ['*'], 'documents');

        return view($this->viewDirectory . 'documentTypeIndex', compact('organization', 'organizationDocumentType', 'organizationDocuments'));

    }

    public function create($organizationSlug, $organizationDocumentTypeSlug)
    {
        // Only Documentation Officer Allowed
        abort_if(! Organization::where('organization_slug', $organizationSlug)->where('organization_id', (new OfficerOrganizationIDService())->getOrganizationID())->exists(), 404);
        $organization = Organization::where('organization_slug', $organizationSlug)->first();

        abort_if(! OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->exists(), 404);
        $organizationDocumentType = OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)
            ->where('organization_id', $organization->organization_id)
            ->first();

        $filePondJS = true;
    	return view($this->viewDirectory . 'create', compact('organization', 'organizationDocumentType', 'filePondJS'));
    }

    public function store(OrganizationDocumentStoreRequest $request, $organizationSlug, $organizationDocumentTypeSlug)
    {
        // Only Documentation Officer Allowed
        abort_if(! Organization::where('organization_slug', $organizationSlug)->where('organization_id', (new OfficerOrganizationIDService())->getOrganizationID())->exists(), 404);
        abort_if(! OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->exists(), 404);

        $returnArray = (new OrganizationDocumentStoreService())->store($request, $organizationDocumentTypeSlug);
        $message = $returnArray['message'];

        if ($returnArray['organizationDocumentID'] === NULL) 
            return redirect()->action(
                [OrganizationDocumentsController::class, 'index'], ['organizationSlug' => $organizationSlug,])
                ->with($message);
        else
            return redirect()->action(
                [OrganizationDocumentsController::class, 'show'], [
                    'organizationSlug' => $organizationSlug,
                    'organizationDocumentTypeSlug' => $organizationDocumentTypeSlug,
                    'organizationDocumentID' => $returnArray['organizationDocumentID'], 
                    'newDocument' => true])
                ->with($message);
    }

    public function show($organizationSlug, $organizationDocumentTypeSlug, $organizationDocumentID, $newDocument = false)
    {
        // Only Documentation Officer Allowed
        abort_if(! Organization::where('organization_slug', $organizationSlug)->where('organization_id', (new OfficerOrganizationIDService())->getOrganizationID())->exists(), 404);
        $organization = Organization::where('organization_slug', $organizationSlug)->first();

        abort_if(! OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->exists(), 404);
        $organizationDocumentType = OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)
            ->where('organization_id', $organization->organization_id)
            ->first();

        abort_if(! OrganizationDocument::where('organization_document_id', $organizationDocumentID)->where('organization_document_type_id', $organizationDocumentType->organization_document_type_id)->exists(), 404);
        $organizationDocument = OrganizationDocument::where('organization_document_id', $organizationDocumentID)
            ->where('organization_document_type_id', $organizationDocumentType->organization_document_type_id)
            ->first();

        return view($this->viewDirectory . 'show', compact('organization', 'organizationDocumentType', 'organizationDocument', 'newDocument'));
    }

    public function edit($organizationSlug, $organizationDocumentTypeSlug, $organizationDocumentID)
    {
        // Only Documentation Officer Allowed
        abort_if(! Organization::where('organization_slug', $organizationSlug)->where('organization_id', (new OfficerOrganizationIDService())->getOrganizationID())->exists(), 404);
        $organization = Organization::where('organization_slug', $organizationSlug)->first();

        abort_if(! OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->exists(), 404);
        $organizationDocumentType = OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)
            ->where('organization_id', $organization->organization_id)
            ->first();

        abort_if(! OrganizationDocument::where('organization_document_id', $organizationDocumentID)->where('organization_document_type_id', $organizationDocumentType->organization_document_type_id)->exists(), 404);
        $organizationDocument = OrganizationDocument::where('organization_document_id', $organizationDocumentID)
            ->where('organization_document_type_id', $organizationDocumentType->organization_document_type_id)
            ->first();

        return view($this->viewDirectory . 'edit', compact('organization', 'organizationDocumentType', 'organizationDocument'));
    }

    public function update(OrganizationDocumentUpdateRequest $request, $organizationSlug, $organizationDocumentTypeSlug, $organizationDocumentID)
    {
        // Only Documentation Officer Allowed
        abort_if(! Organization::where('organization_slug', $organizationSlug)->where('organization_id', (new OfficerOrganizationIDService())->getOrganizationID())->exists(), 404);
        $organization = Organization::where('organization_slug', $organizationSlug)->first();

        abort_if(! OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->exists(), 404);
        $organizationDocumentType = OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)
            ->where('organization_id', $organization->organization_id)
            ->first();

        abort_if(! OrganizationDocument::where('organization_document_id', $organizationDocumentID)->where('organization_document_type_id', $organizationDocumentType->organization_document_type_id)->exists(), 404);
        

        $returnArray = (new OrganizationDocumentUpdateService())->update($request, $organizationDocumentID);
        $message = $returnArray['message'];

        if ($returnArray['organizationDocumentID'] === NULL) 
            return redirect()->action(
                [OrganizationDocumentsController::class, 'index'], ['organizationSlug' => $organizationSlug,])
                ->with($message);
        else
            return redirect()->action(
                [OrganizationDocumentsController::class, 'show'], [
                    'organizationSlug' => $organizationSlug,
                    'organizationDocumentTypeSlug' => $organizationDocumentTypeSlug,
                    'organizationDocumentID' => $returnArray['organizationDocumentID'], 
                    'newDocument' => true])
                ->with($message);
    }

    public function destroy($organizationSlug, $organizationDocumentTypeSlug, $organizationDocumentID)
    {
        // Only Documentation Officer Allowed
        abort_if(! Organization::where('organization_slug', $organizationSlug)->where('organization_id', (new OfficerOrganizationIDService())->getOrganizationID())->exists(), 404);
        $organization = Organization::where('organization_slug', $organizationSlug)->first();

        abort_if(! OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)->where('organization_id', $organization->organization_id)->exists(), 404);
        $organizationDocumentType = OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)
            ->where('organization_id', $organization->organization_id)
            ->first();

        abort_if(! OrganizationDocument::where('organization_document_id', $organizationDocumentID)->where('organization_document_type_id', $organizationDocumentType->organization_document_type_id)->exists(), 404);

        $message = (new OrganizationDocumentDeleteService())->delete($organizationDocumentID);

        return redirect()->action(
            [OrganizationDocumentsController::class, 'documentTypeIndex'], ['organizationSlug' => $organizationSlug, 'organizationDocumentTypeSlug' => $organizationDocumentTypeSlug])
            ->with($message);
    }

    /**
     * @param Request $request
     * Function for FilePond JS File Upload 
     * https://pqina.nl/filepond/
     * @return text/plain JSON Response
     */
    public function upload(Request $request, $organizationSlug)
    {
        if ($request->hasFile('document'))
        {
            $file = $request->file('document');
            $filename = uniqid() . '-' . now()->timestamp . '.' .$file->extension();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs($this->temporaryFolderDirectory . $folder, $filename);

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
    public function undoUpload(Request $request, $organizationSlug)
    {
         if ($request->getContent())
         {
            $folder = $request->getContent();
            TemporaryFile::where('folder', $folder)->delete();
            // first delete contents of the directory, but preserve the directory itself
            Storage::deleteDirectory($this->temporaryFolderDirectory . $folder, true);
            // sleep 0.5 second because of race condition with HD
            sleep(0.5);
            // actually delete the folder itself
            Storage::deleteDirectory($this->temporaryFolderDirectory . $folder);
            return 'file deleted';
         }
         return 'file not deleted';
    }

}

