<?php

namespace App\Services\EventServices\EventImageServices;

use App\Models\EventImage;

class EventImageStoreCaptionService
{
    /**
     * @param Collection $event, String $eventImageSlug
     * Service to update an event image.
     * Returns Message on success.
     * @return Array
     */
    public function storeCaption($request, $event): array
    {
        try
        {
            if($request->has('caption'))
            {
                foreach($request->input('caption') as $image => $caption)
                {
                    if ($caption != NULL)
                    {
                        EventImage::where('accomplished_event_id', $event->accomplished_event_id)
                            ->where('slug', $image)
                            ->update(['caption' => $caption ]);
                    }
                }
            }

            $returnArray = array('success' => 'Event Image and Caption stored successfully!');

            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array('error' => 'Error in Storing Caption for Event Image:' . $e->getMessage());

            return $returnArray;
        }
        
    }
}
