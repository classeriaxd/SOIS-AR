<?php

namespace App\Services\EventServices\EventDocumentServices;

use App\Models\EventDocument;

class EventDocumentDeleteService
{
    /**
     * @param Collection $event, Integer $documentID
     * Service to soft delete an event document.
     * Returns Message on success.
     * @return Array
     */
    public function destroy($event, $documentID): array
    {
        try
        {
            $document = EventDocument::where('event_document_id', $documentID)
                ->where('accomplished_event_id', $event->accomplished_event_id)
                ->first();

            $document->delete();

            $returnArray = array('success' => 'Event Document deleted successfully!');

            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array('error' => 'Error in Deleting Event Document:' . $e->getMessage());

            return $returnArray;
        }
        
    }
}
