<?php

namespace App\Services\EventServices;

use App\Models\Event;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventDeleteService
{
    /**
     * Service to Delete an event.
     * Returns true on success.
     *
     * @return Boolean
     */
    public function destroy($eventSlug)
    {
        if ($event = Event::where('slug', $eventSlug)->first())
        {
            if ($event->delete())
                return true;
            else
               abort(404); 
        }
        else
            abort(404);
    }
}
