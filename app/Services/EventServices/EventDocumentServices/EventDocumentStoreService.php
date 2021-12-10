<?php

namespace App\Services\EventServices\EventDocumentServices;

use App\Models\EventDocument;
use App\Models\TemporaryFile;

use Illuminate\Support\Facades\Storage;

class EventDocumentStoreService
{
    /**
     * @param Request $request, Collection $event
     * Service to Store an event document.
     * Returns Message on success.
     * @return Array
     */
    public function store($request, $event): array
    {
        try
        {
            $tempPath = '/public/uploads/tmp/';
            $finalPath = '/public/uploads/events/documents/';
            $dbPath = '/uploads/events/documents/';

            if($request->has('document'))
            {
                // Get File details from TemporaryFile Table
                $file = TemporaryFile::where('folder', $request->input('document'))->value('filename');
                // Move file to permanent Storage folder
                Storage::move($tempPath . $request->input('document') . '/' . $file, $finalPath . $file);
                // Delete the directory of temporary file
                $this->deleteDirectory($tempPath . $request->input('document'));
                // Delete entry on TemporaryFile Table
                TemporaryFile::where('folder', $request->input('document'))->delete();

                // Create EventDocument entry
                EventDocument::create([
                    'accomplished_event_id' => $event->accomplished_event_id,
                    'event_document_type_id' => $request->input('document_type'),
                    'title' => $request->input('title', NULL),
                    'description' => $request->input('description', NULL),
                    'file' =>  $dbPath . $file, 
                ]);
            }

            $returnArray = array('success' => 'Event Document added successfully!');

            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array('error' => 'Error in Storing Event Document:' . $e->getMessage());

            return $returnArray;
        }
        
    }

    /**
     * @param String $folderPath
     * Private Function to delete temporary directories.
     * @return void
     */
    private function deleteDirectory($folderPath)
    {
        Storage::deleteDirectory($folderPath, true);
        sleep(0.3);
        Storage::deleteDirectory($folderPath);
    }
}
