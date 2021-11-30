<?php

namespace App\Services\OrganizationDocumentServices\OrganizationDocumentTypeMaintenanceServices;

use App\Models\OrganizationDocumentType;

class OrganizationDocumentTypeDeleteService
{
    /**
     * @param Collection $organization, String $organizationDocumentTypeSlug
     * Service to Soft Delete an Organization Document Type.
     * Returns message on success.
     * @return Array
     */
    public function delete($organization, $organizationDocumentTypeSlug): array
    {
        try 
        {
            $documentType = OrganizationDocumentType::where('slug', $organizationDocumentTypeSlug)
                ->where('organization_id', $organization->organization_id)
                ->first();
            $documentType->delete();

            return ['success' => 'Successfully deleted Organization Document Type.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in deleting Organization Document Type: ' . $e->getMessage()];
        }
    }
}
