<?php

namespace App\Services\EventServices\EventImageServices;

use App\Models\EventImage;
use App\Models\TemporaryFile;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

class EventImageStoreService
{
    /**
     * @param Request $request, Collection $event
     * Service to Store event images.
     * Returns Message and InsertedImageCount on success.
     * @return Array
     */
    public function store($request, $event): array
    {
        try
        {
            $insertedImages = array();
            if($request->has('poster'))
            {
                $tempPath = '/public/uploads/tmp/';
                $finalPath = '/public/uploads/events/posters/';
                $dbPath = '/uploads/events/posters/';
                
                foreach($request->input('poster') as $poster)
                {   
                    // Get File details from TemporaryFile Table
                    $file = TemporaryFile::where('folder', $poster)->value('filename');
                    // Move File to permanent storage
                    Storage::move($tempPath . $poster . '/' . $file, $finalPath . $file);
                    // Delete Temporary Directory and TemporaryFile entry
                    $this->deleteDirectory($tempPath . $poster);
                    TemporaryFile::where('folder', $poster)->delete();

                    // Image Type > 0 = Poster | 1 = Evidence
                    $eventImageID = EventImage::insertGetId([
                        'accomplished_event_id' => $event->accomplished_event_id,
                        'image' => $dbPath . $file,
                        'image_type' => 0,
                        'caption' => NULL,
                        'slug' => Str::uuid(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    array_push($insertedImages, $eventImageID);
                }
            }

            if($request->has('evidence'))
            {
                $tempPath = '/public/uploads/tmp/';
                $finalPath = '/public/uploads/events/evidences/';
                $dbPath = '/uploads/events/evidences/';
                foreach($request->input('evidence') as $evidence)
                {
                    // Get File details from TemporaryFile Table
                    $file = TemporaryFile::where('folder', $evidence)->value('filename');
                    // Move File to permanent storage
                    Storage::move($tempPath . $evidence . '/' . $file, $finalPath . $file);
                    // Delete Temporary Directory and TemporaryFile entry
                    $this->deleteDirectory($tempPath . $evidence);
                    TemporaryFile::where('folder', $evidence)->delete();

                    // Image Type > 0 = Poster | 1 = Evidence
                    $eventImageID = EventImage::insertGetId([
                        'accomplished_event_id' => $event->accomplished_event_id,
                        'image' => $dbPath . $file,
                        'image_type' => 1,
                        'caption' => NULL,
                        'slug' => Str::uuid(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    array_push($insertedImages, $eventImageID);
                }
            }

            if (count($insertedImages) > 0) 
                $returnArray = array(
                    'message' => array('success' => 'Event Document added successfully!'),
                    'insertedImagesCount' => count($insertedImages),
                    'insertedImages' => $insertedImages,
                );
            else
                $returnArray = array(
                    'message' => array('error' => 'No Image Uploaded.'),
                    'insertedImagesCount' => 0,
                );

            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array(
                'message' => array('error' => 'Error in Storing Event Document:' . $e->getMessage()),
                'insertedImagesCount' => 0,
            );

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
