<?php

namespace App\Services\OrganizationDocumentServices;

use App\Models\OrganizationDocument;

class OrganizationDocumentRestoreService
{
    /**
     * Service to restore Soft Deleted Organization Document.
     * Returns message on success.
     * @return Array
     */
    public function restore($organizationDocumentID): array
    {
        try 
        {
            $organizationDocument = OrganizationDocument::onlyTrashed()->where('organization_document_id', $organizationDocumentID)
                ->first();

            $organizationDocument->restore();

            return ['success' => 'Document restored successfully!'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in restoring document:' . $e->getMessage()];
        }
    }
}
