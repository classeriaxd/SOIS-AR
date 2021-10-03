<?php

namespace App\Services\AccomplishmentReportServices;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use iio\libmergepdf\Merger;
use PDF;

class AccomplishmentReportGeneratePDFService
{
    /**
     * Service to generate PDF Accomplishment Report.
     * Returns Array of Final File Name and Folder Name
     * @return array
     */
    public function generate($request, $events, $studentAccomplishments)
    {

        // Get all Keys from Form
        $allKeys= $request->except(['start_date', 'end_date', '_token', 'ar_format', 'range_title']);
        if (count($allKeys) == 0) 
        {
            return redirect()->action(
                [AccomplishmentReportsController::class, 'index'])
                ->with('error', 'No Report Selected!');
        }

        // Get Sorted Events and Accomplishments
        $sortedEvents = $this->sortAndCompileReport($allKeys, $events, 'events');
        $sortedAccomplishments = $this->sortAndCompileReport($allKeys, $studentAccomplishments, 'accomplishments');
        
        // Create Folder and Directory
        $temporaryFolder = 'temporaryFolder-' . uniqid() . '-' . now()->timestamp;
        $this->createDirectory('/app/public/compiledDocuments/tmp', $temporaryFolder);

        // Create Event PDF, save it to File, then add to array
        // After that get all documents, then add to array
        // temp is true for Title Page
        $compiledDocuments = array();
        $temp = true;

        foreach($sortedEvents as $event)
        {
            if ($temp)
            {
                // Create and Append Event Title Page
                $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
                $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.eventTitlePage')
                    ->setPaper('letter', 'portrait')
                    ->save(storage_path('/app/public/compiledDocuments/tmp/' . $temporaryFolder . '/' . $fileName));
                array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/tmp/' . $temporaryFolder . '/' . $fileName));
                $temp = false;
            }
            //dd($event);
            $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
            $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.singlePageEvent', compact('event'))
                ->setPaper('letter', 'portrait')
                ->save(storage_path('/app/public/compiledDocuments/tmp/' . $temporaryFolder . '/' . $fileName));
            array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/tmp/' . $temporaryFolder . '/' . $fileName));
            if (isset($event['event_documents']))
            {
                foreach ($event['event_documents'] as $document) 
                {
                    array_push($compiledDocuments, storage_path('/app/public/' . $document['file']));
                }
            }
        }

        $temp = true;

        foreach ($sortedAccomplishments as $accomplishment)
        {
            if($temp)
            {
                // Create and Append Accomplishment Title Page
                $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
                $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.accomplishmentTitlePage')->save(storage_path('/app/public/compiledDocuments/tmp/' . $temporaryFolder . '/' . $fileName));
                array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/tmp/' . $temporaryFolder . '/' . $fileName));
                $temp = false;
            }
            $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
            $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.singlePageAccomplishment', compact('accomplishment'))
                ->setPaper('letter', 'portrait')
                ->save(storage_path('/app/public/compiledDocuments/tmp/' . $temporaryFolder . '/' . $fileName));
            array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/tmp/' . $temporaryFolder . '/' . $fileName));
            if (isset($accomplishment['accomplishment_files']))
            {
                foreach ($accomplishment['accomplishment_files'] as $file) 
                {
                    if($file['type'] == 2)
                        array_push($compiledDocuments, storage_path('/app/public/' . $file['file']));
                    elseif($file['type'] == 1)
                    {
                        $fileName2 = uniqid() . '-' . now()->timestamp . '.pdf';
                        $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.singlePageAccomplishmentImage', compact('file'))
                            ->setPaper('letter', 'portrait')
                            ->save(storage_path('/app/public/compiledDocuments/tmp/' . $temporaryFolder . '/' . $fileName2));
                        array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/tmp/' . $temporaryFolder . '/' . $fileName2));
                    }
                }
            }
        }
        // Merge all documents then delete temporary folder
        $finalFolderName = uniqid() . '-' . now()->timestamp;
        $this->createDirectory('/app/public/compiledDocuments/accomplishmentReports', $finalFolderName);
        $finalFileName = uniqid() . '-' . now()->timestamp . '.pdf';
        $this->mergePDF($compiledDocuments, $finalFileName, $finalFolderName);
        $this->deleteDirectory($temporaryFolder);

        $ARDirectory = [
            'finalFolderName' => $finalFolderName, 
            'finalFileName' =>$finalFileName
        ];

        return $ARDirectory;
    }

    /**
     * Function to Sort and Compile Report using Key Array and Report Collection
     * keys = array()
     * reportCollection = collection()
     * reportType = String (events, accomplishments)
     * @return Collection
     */ 
    private function sortAndCompileReport($keys, $reportCollection, $reportType)
    {
        // Filter Event/Accomplishment Keys
        if ($reportType == 'events')
        {
            $collectionKeys = Arr::where($keys, function ($value, $key) {
                if(Str::startsWith($key, 'event'))
                    return $key;
            });
        }
        elseif ($reportType == 'accomplishments')
        {
            $collectionKeys = Arr::where($keys, function ($value, $key) {
                if(Str::startsWith($key, 'accomplishment'))
                    return $key;
            });
        }

        // Remake array, only keys remain
        $collectionKeys = array_keys($collectionKeys);
        // Group Keys, add attributes
        $collectionWithAttributes = $this->groupKeysWithAttributes($collectionKeys, $reportCollection->count(), $reportType);
        $sortedCollection = collect([]);

        // Rearrange Collection, then retain/remove attributes
        foreach ($collectionWithAttributes as $key => $value) 
        {
            // If details attribute is set, add report to new Collection
            if (isset($value['details']))
            {
                if ($reportType == 'events')
                {
                    // Get current event using Key from original Event Query
                    $currentEvent = collect($reportCollection->get($key));
                    // If images is not set, remove from current event
                    if((! isset($value['images'])) && ($currentEvent['event_images'] != NULL))
                        $currentEvent->forget('event_images');
                    // If documents is not set, remove from current event
                    if((! isset($value['documents'])) && ($currentEvent['event_documents'] != NULL))
                        $currentEvent->forget('event_documents');
                    // Push updated current event to a new collection
                    $sortedCollection->push($currentEvent);
                }
                elseif ($reportType == 'accomplishments')
                {
                    // Get current accomplishment using Key from original Accomplishment Query
                    $currentAccomplishment = collect($reportCollection->get($key));
                    // If files is not set, remove from current accomplishment
                    if((! isset($value['files'])) && ($currentAccomplishment['accomplishment_files'] != NULL))
                        $currentAccomplishment->forget('accomplishment_files');               
                    // Push updated current accomplishment to a new collection
                    $sortedCollection->push($currentAccomplishment);
                }
            }
        }
        return $sortedCollection;
    }

    /**
     * Function to Group Keys using a given key array
     * choiceKeyArray = array() 
     * rowCount = int
     * category = String
     * @return array
     */ 
    private function groupKeysWithAttributes($choiceKeyArray, $rowCount, $category)
    {
        // Loop throughout the array, then append attributes to numbers
        $temp = 0;
        $currentNumber = null;
        $newArray = array();
        while($temp <= count($choiceKeyArray)-1)
        {
            // Get Number character from Key
            // Number is the Ordinal Position of the Event from the Original Query
            $number = array();
            $condition = preg_match_all('!\d+!', $choiceKeyArray[$temp], $number);
            $number = (int)$number[0][0];

            if(($condition === 1 || $condition === true) && ($number <= $rowCount))
            {
                if ($number !== $currentNumber) 
                {
                    // Create new Array Instance if there is a new Number
                    $currentNumber = $number;
                    $newArray[$number] = array();
                }
                switch ($category) 
                {
                    // Depending on Category, add attribute
                    case 'events':
                        if (Str::endsWith($choiceKeyArray[$temp],'details'))
                            $newArray[$number] += ['details' => true];
                        else if (Str::endsWith($choiceKeyArray[$temp],'images'))
                            $newArray[$number] += ['images' => true];
                        else if (Str::endsWith($choiceKeyArray[$temp],'documents'))
                            $newArray[$number] += ['documents' => true,];
                        break;
                    case 'accomplishments':
                        if (Str::endsWith($choiceKeyArray[$temp],'details'))
                            $newArray[$number] += ['details' => true];
                        else if (Str::endsWith($choiceKeyArray[$temp],'files'))
                            $newArray[$number] += ['files' => true];
                    default:
                        break;
                }
            }
            $temp += 1;
        }
        return $newArray;
    }

    /**
     * Function to Merge PDF using documents array.
     * documents = array()
     * fileName = String
     * folderName = String
     * @return void
     */
    private function mergePDF($documents, $fileName, $folderName)
    {
        $merger = new Merger;
        $merger->addIterator($documents);
        $mergedPDF = $merger->merge();
        $filePath = storage_path('/app/public/compiledDocuments/accomplishmentReports/' . $folderName . '/' . $fileName);
        file_put_contents($filePath, $mergedPDF);
    }

    /**
     * Function to Delete Created Folder and its contents
     * folder = String
     * @return void
     */
    private function deleteDirectory($folder)
    {
        // first delete contents of the directory, but preserve the directory itself
        Storage::deleteDirectory('/public/compiledDocuments/' . $folder, true);
        // sleep 0.3 second because of race condition with HD
        sleep(0.3);
        // actually delete the folder itself
        Storage::deleteDirectory('/public/compiledDocuments/' . $folder);
    }
    private function createDirectory($directory, $folder)
    {
        if (!is_dir(storage_path($directory))) 
        {
            // dir doesn't exist, make it
            mkdir(storage_path($directory));
        }

        if (!is_dir(storage_path($directory . '/' . $folder))) 
        {
            // dir doesn't exist, make it
            mkdir(storage_path($directory . '/' . $folder));
        }
    }
}
