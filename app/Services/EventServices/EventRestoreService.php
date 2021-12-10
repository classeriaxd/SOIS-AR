<?php

namespace App\Services\EventServices;

use App\Models\Event;

class EventRestoreService
{
    /**
     * @param String $eventSlug
     * Service to Restore a soft deleted event.
     * Returns message on success.
     * @return Array
     */
    public function restore($eventSlug): array
    {
        try 
        {
            $event = Event::onlyTrashed()->where('slug', $eventSlug)->first();
            $event->restore();
            $returnArray = array('success' => 'Event restored Successfully');
            return $returnArray;
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array('error' => 'Error in restoring Event:' . $e->getMessage());
            return $returnArray;
        }
    }
}
