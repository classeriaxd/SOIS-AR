<?php

namespace App\Services\Admin\EventMaintenance\EventDocumentType;

use App\Models\EventDocumentType;

class EventDocumentTypeRestoreService
{
    /**
     * Service to Restore soft deleted event document type.
     * Returns message on success.
     * @return Array
     */
    public function restore(EventDocumentType $documentType): array
    {
        try 
        {
            $documentType->restore();

            return ['success' => 'Successfully restored Event Document Type.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Restoring Event Document Type:' . $e->getMessage()];
        }
    }
}
