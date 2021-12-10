<?php

namespace App\Services\Admin\EventMaintenance\EventNature;

use App\Models\EventNature;

class EventNatureRestoreService
{
    /**
     * Service to Restore soft deleted event nature.
     * Returns message on success.
     * @return Array
     */
    public function restore(EventNature $nature): array
    {
        try 
        {
            $nature->restore();

            return ['success' => 'Successfully restored Event Nature.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Restoring Event Nature:' . $e->getMessage()];
        }
    }
}
