<?php

namespace App\Services\OrganizationDocumentServices;

use App\Models\TemporaryFile;
use App\Models\OrganizationDocument;
use App\Models\OrganizationDocumentType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganizationDocumentStoreService
{
    /**
     * @param Request $request, String $organizationDocumentTypeSlug
     * Service to Store an Organization Document.
     * Returns Message and Organization Document ID on success.
     * @return Array
     */
    public function store($request, $organizationDocumentTypeSlug): array
    {
        try 
        {
            $temp_path = '/public/uploads/tmp/';
            $final_path = '/public/organizationDocuments/';
            $db_path = '/organizationDocuments/';

            $organizationDocumentType = OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)
                ->first();

            if($request->has('document'))
            {
                $file = TemporaryFile::where('folder', $request->input('document'))->value('filename');

                Storage::move($temp_path . $request->input('document') . '/' . $file, $final_path . $file);
                $this->deleteDirectory($temp_path . $request->input('document'));

                $organizationDocumentID = OrganizationDocument::insertGetId([
                    'organization_document_type_id' => $organizationDocumentType->organization_document_type_id,
                    'title' => $request->input('title', NULL),
                    'description' => $request->input('description', NULL),
                    'file' =>  $db_path . $file, 
                    'effective_date' => $request->input('effective_date'),
                ]);
            }

            $returnArray = array(
                'organizationDocumentID' => $organizationDocumentID, 
                'message' => array('success' => 'Document uploaded successfully!'),
            );
            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array(
                'organizationDocumentID' => NULL, 
                'message' => array('error' => 'Error in uploading document ' . $e->getMessage()),
            );

            return $returnArray;
        }
    }

    /**
     * @param String $folderPath
     * Private Function to delete temporary directories.
     * @return void
     */
    private function deleteDirectory($folderPath)
    {
        Storage::deleteDirectory($folderPath, true);
        sleep(0.3);
        Storage::deleteDirectory($folderPath);
    }
}
