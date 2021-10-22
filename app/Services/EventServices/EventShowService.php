<?php

namespace App\Services\EventServices;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRole;

class EventShowService
{
    /**
     * @param String $eventSlug
     * Service to Show an event.
     * Returns Event Details Collection.
     * @return Collection
     */
    public function show($eventSlug)
    {
        abort_if(! 
            $event = Event::with([
                'eventCategory:event_category_id,category,background_color,text_color,deleted_at',
                'eventRole:event_role_id,event_role,background_color,text_color',
                'eventFundSource:fund_source_id,fund_source',
                'eventLevel:level_id,level',
                'eventImages:event_image_id,event_id,image,image_type',
                'eventDocuments:event_document_id,event_id,event_document_type_id,title',
                'eventDocuments.documentType:event_document_type_id,document_type',
                    ])
            ->where('slug', $eventSlug)
            ->first()
        , 404);
        //dd($event);
        return $event;
    }
}
