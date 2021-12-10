<?php

namespace App\Services\EventServices\EventImageServices;

use App\Models\EventImage;

class EventImageDeleteService
{
    /**
     * @param Collection $event, String $eventImageSlug
     * Service to soft delete an event image.
     * Returns Message on success.
     * @return Array
     */
    public function destroy($event, $eventImageSlug): array
    {
        try
        {
            $image = EventImage::where('slug', $eventImageSlug)
                ->where('accomplished_event_id', $event->accomplished_event_id)
                ->first();
                
            $image->delete();

            $returnArray = array('success' => 'Event Image deleted successfully!');

            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array('error' => 'Error in Deleting Event Image:' . $e->getMessage());

            return $returnArray;
        }
        
    }
}
