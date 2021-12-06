<?php

namespace App\Services\OrganizationDocumentServices\OrganizationDocumentTypeMaintenanceServices;

use App\Models\OrganizationDocumentType;

class OrganizationDocumentTypeRestoreService
{
    /**
     * @param Collection $organization, String $organizationDocumentTypeSlug
     * Service to restore Soft Deleted Organization Document Type.
     * Returns message on success.
     * @return Array
     */
    public function restore($organization, $organizationDocumentTypeSlug): array
    {
        try 
        {
            $documentType = OrganizationDocumentType::onlyTrashed()->where('slug', $organizationDocumentTypeSlug)
                ->where('organization_id', $organization->organization_id)
                ->first();
            $documentType->restore();

            return ['success' => 'Successfully restored Organization Document Type.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in restoring Organization Document Type: ' . $e->getMessage()];
        }
    }
}
