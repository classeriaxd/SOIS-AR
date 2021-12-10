<?php

namespace App\Services\EventServices\EventDocumentServices;

use App\Models\EventDocument;

class EventDocumentRestoreService
{
    /**
     * @param Collection $event, Integer $documentID
     * Service to restore soft deleted event document.
     * Returns Message on success.
     * @return Array
     */
    public function restore($event, $documentID): array
    {
        try
        {
            $document = EventDocument::onlyTrashed()
                ->where('event_document_id', $documentID)
                ->where('accomplished_event_id', $event->accomplished_event_id)
                ->first();

            $document->restore();

            $returnArray = array('success' => 'Event Document restored successfully!');

            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array('error' => 'Error in Restoring Event Document:' . $e->getMessage());

            return $returnArray;
        }
        
    }
}
