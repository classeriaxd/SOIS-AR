<?php

namespace App\Services\OrganizationDocumentServices;

use App\Models\OrganizationDocument;

class OrganizationDocumentUpdateService
{
    /**
     * @param Request $request, Integer $organizationDocumentTypeSlug
     * Service to Update an Organization Document.
     * Returns Message and Organization Document ID on success.
     * @return Array
     */
    public function update($request, $organizationDocumentID): array
    {
        try 
        {
            $organizationDocument = OrganizationDocument::where('organization_document_id', $organizationDocumentID)
                ->first();
            $documentData = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'effective_date' => $request->input('effective_date'),
            ];
            $organizationDocument->update($documentData);
            $returnArray = array(
                'organizationDocumentID' => $organizationDocument->organization_document_id, 
                'message' => array('success' => 'Document updated successfully!'),
            );
            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array(
                'organizationDocumentID' => NULL, 
                'message' => array('error' => 'Error in updating document ' . $e->getMessage()),
            );

            return $returnArray;
        }
    }
}
