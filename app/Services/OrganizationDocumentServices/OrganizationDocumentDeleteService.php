<?php

namespace App\Services\OrganizationDocumentServices;

use App\Models\OrganizationDocument;

class OrganizationDocumentDeleteService
{
    /**
     * Service to Soft Delete an Organization Document.
     * Returns message on success.
     * @return Array
     */
    public function delete($organizationDocumentID): array
    {
        try 
        {
            $organizationDocument = OrganizationDocument::where('organization_document_id', $organizationDocumentID)
                ->first();

            $organizationDocument->delete();

            return ['success' => 'Document deleted successfully!'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in deleting document:' . $e->getMessage()];
        }
    }
}
