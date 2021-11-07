<?php

namespace App\Services\EventServices;

use App\Models\Event;
use Illuminate\Support\Str;

class EventDeleteService
{
    /**
     * @param String $eventSlug
     * Service to Delete an event.
     * Returns message on success.
     * @return Array
     */
    public function destroy($eventSlug): array
    {
        try 
        {
            $event = Event::where('slug', $eventSlug)->first();
            $event->delete();
            return ['success' => 'Event deleted Successfully'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in deleting Event:' . $e->getMessage()];
        }
    }
}
