<?php

namespace App\Services\Admin\EventMaintenance\Level;

use App\Models\Level;

class LevelRestoreService
{
    /**
     * Service to Restore soft deleted event fund source.
     * Returns message on success.
     * @return Array
     */
    public function restore(Level $level): array
    {
        try 
        {
            $level->restore();

            return ['success' => 'Successfully restored Event Level.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Restoring Event Level:' . $e->getMessage()];
        }
    }
}
