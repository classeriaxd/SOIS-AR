<?php

namespace App\Services\Admin\EventMaintenance\EventCategory;

use App\Models\EventCategory;

class EventCategoryRestoreService
{
    /**
     * Service to Restore soft deleted event category.
     * Returns message on success.
     * @return Array
     */
    public function restore(EventCategory $category): array
    {
        try 
        {
            $category->restore();

            return ['success' => 'Successfully restored Event Category.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Restoring Event Category:' . $e->getMessage()];
        }
    }
}
