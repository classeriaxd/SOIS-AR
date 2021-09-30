<?php

namespace App\Services\EventServices;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRole;


class EventShowService
{
    /**
     * Service to Show an event.
     * Returns Event Details Collection.
     *
     * @return Collection
     */
    public function show($eventSlug)
    {
        if(Event::where('slug', $eventSlug)->exists())
        {
            $event = Event::with([
                'eventCategory:event_category_id,category',
                'eventRole:event_role_id,event_role',
                'eventFundSource:fund_source_id,fund_source',
                'eventLevel:level_id,level',
                    ])
            ->where('slug', $eventSlug)
            ->first();
           
            // some colors
                if ($event->eventCategory->category == 'Academic')
                    $event->category_color = 'primary';
                elseif ($event->eventCategory->category == 'Non-academic') 
                    $event->category_color = 'danger';
                elseif ($event->eventCategory->category == 'Cultural') 
                    $event->category_color = 'warning';
                elseif ($event->eventCategory->category == 'Sports') 
                    $event->category_color = 'success';
                elseif ($event->eventCategory->category == 'Community Outreach') 
                    $event->category_color = 'info text-white';
                elseif ($event->eventCategory->category == 'Seminars/Workshops') 
                    $event->category_color = 'info text-white';

                if ($event->eventRole->event_role == 'Organizer')
                    $event->role_color = 'primary';
                elseif ($event->eventRole->event_role == 'Sponsor') 
                    $event->role_color = 'success';
                elseif ($event->eventRole->event_role == 'Participant') 
                    $event->role_color = 'secondary';

            return $event;
        }
        else
            abort(404);
    }
}
