<?php

namespace App\Services\EventServices\EventImageServices;

use App\Models\EventImage;

class EventImageUpdateService
{
    /**
     * @param Request $request, Collection $event, String $eventImageSlug
     * Service to update an event image.
     * Returns Message on success.
     * @return Array
     */
    public function update($request, $event, $eventImageSlug): array
    {
        try
        {
            EventImage::where('accomplished_event_id', $event->accomplished_event_id)
                ->where('slug', $eventImageSlug)
                ->update([
                    'caption' => $request->input('caption', NULL),
                    'image_type' => $request->input('image_type'),]);

            $returnArray = array('success' => 'Event Image updated successfully!');

            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array('error' => 'Error in Updating Event Image:' . $e->getMessage());

            return $returnArray;
        }
        
    }
}
