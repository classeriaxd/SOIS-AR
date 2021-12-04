<?php

namespace App\Services\Admin\EventMaintenance\EventRole;

use App\Models\EventRole;

class EventRoleRestoreService
{
    /**
     * Service to Restore soft deleted event role.
     * Returns message on success.
     * @return Array
     */
    public function restore(EventRole $role): array
    {
        try 
        {
            $role->restore();

            return ['success' => 'Successfully restored Event Role.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Restoring Event Role:' . $e->getMessage()];
        }
    }
}
