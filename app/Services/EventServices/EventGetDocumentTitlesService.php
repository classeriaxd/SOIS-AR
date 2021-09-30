<?php

namespace App\Services\EventServices;

use Illuminate\Support\Facades\DB;

class EventGetDocumentTitlesService
{
    /**
     * Service to get all Document Titles from an event.
     * Returns Event Documents on success.
     *
     * @return Collection
     */
    public function getDocumentTitles($eventID)
    {
        $eventDocuments = DB::table('event_documents as documents')
        ->join('event_document_types as types','documents.event_document_type_id','=','types.event_document_type_id')
        ->where('documents.event_id', $eventID)
        ->whereNull('deleted_at')
        ->orderBy('documents.event_document_type_id', 'ASC')
        ->select('types.document_type as document_type', 'documents.title as title')
        ->get();

        return $eventDocuments;
    }
}
