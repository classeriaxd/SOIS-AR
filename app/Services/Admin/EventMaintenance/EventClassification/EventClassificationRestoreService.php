<?php

namespace App\Services\Admin\EventMaintenance\EventClassification;

use App\Models\EventClassification;

class EventClassificationRestoreService
{
    /**
     * Service to Restore soft deleted event classification.
     * Returns message on success.
     * @return Array
     */
    public function restore(EventClassification $classification): array
    {
        try 
        {
            $classification->restore();

            return ['success' => 'Successfully restored Event Classification.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Restoring Event Classification:' . $e->getMessage()];
        }
    }
}
