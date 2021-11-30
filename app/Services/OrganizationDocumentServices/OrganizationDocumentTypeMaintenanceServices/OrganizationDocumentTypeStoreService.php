<?php

namespace App\Services\OrganizationDocumentServices\OrganizationDocumentTypeMaintenanceServices;

use App\Models\OrganizationDocumentType;
use Illuminate\Support\Str;
use App\Services\EventServices\EventGetOrganizationIDService;

class OrganizationDocumentTypeStoreService
{
    /**
     * @param Request $request
     * Service to Store an Organization Document Type.
     * Returns Message on success
     * @return Array
     */
    public function store($request, $organizationSlug): array
    {
        try 
        {
            $eventCategory = OrganizationDocumentType::create([
                'organization_id' => (new EventGetOrganizationIDService())->getOrganizationID(),
                'type' => $request->input('documentType'),
                'slug' => Str::slug(Str::plural($request->input('documentType'))),
            ]);
                
            return ['success' => 'Added the Organization Document Type Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in adding Organization Document Type:' . $e->getMessage()];
        }
    }
}
