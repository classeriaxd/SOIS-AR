<?php

namespace App\Services\EventServices\EventImageServices;

use App\Models\EventImage;

class EventImageRestoreService
{
    /**
     * @param Collection $event, String $eventImageSlug
     * Service to restore soft deletde event image.
     * Returns Message on success.
     * @return Array
     */
    public function restore($event, $eventImageSlug): array
    {
        try
        {
            $image = EventImage::onlyTrashed()
                ->where('slug', $eventImageSlug)
                ->where('accomplished_event_id', $event->accomplished_event_id)
                ->first();
            
            $image->restore();

            $returnArray = array('success' => 'Event Image restored successfully!');

            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array('error' => 'Error in Restoring Event Image:' . $e->getMessage());

            return $returnArray;
        }
        
    }
}
