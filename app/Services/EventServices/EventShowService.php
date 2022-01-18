<?php

namespace App\Services\EventServices;

use App\Models\Event;

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
        $event = Event::with([
            'eventCategory:event_category_id,category,background_color,text_color,deleted_at',
            'eventRole:event_role_id,event_role,background_color,text_color,deleted_at',
            'eventFundSource:fund_source_id,fund_source',
            'eventLevel:level_id,level',
            'eventImages:event_image_id,accomplished_event_id,image,image_type,slug,caption',
            'eventDocuments:event_document_id,accomplished_event_id,event_document_type_id,title',
            'eventDocuments.documentType:event_document_type_id,document_type',
            'organization:organization_id,organization_acronym,organization_slug',
                'organization.logo:organization_id,file',
                ])
        ->where('slug', $eventSlug)
        ->first();
        return $event;
    }
}
