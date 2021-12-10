<?php

namespace App\Services\OrganizationDocumentServices\OrganizationDocumentTypeMaintenanceServices;

use App\Models\OrganizationDocumentType;
use Illuminate\Support\Str;

class OrganizationDocumentTypeUpdateService
{
    /**
     * @param Request $request, Collection $organization, String $organizationDocumentTypeSlug
     * Service to Update an Organization Document Type.
     * Returns Message on success
     * @return Array
     */
    public function update($request, $organization, $organizationDocumentTypeSlug): array
    {
        try 
        {
            $organizationDocumentType = OrganizationDocumentType::where('organization_id', $organization->organization_id)->where('slug', $organizationDocumentTypeSlug)->first();

            $organizationDocumentType->update([
                'type' => $request->input('documentType'),
                'slug' => Str::slug($request->input('documentType')), 
            ]);

            return ['success' => 'Updated the Organization Document Type Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Updating Organization Document Type: ' . $e->getMessage()];
        }
            
    }
}
