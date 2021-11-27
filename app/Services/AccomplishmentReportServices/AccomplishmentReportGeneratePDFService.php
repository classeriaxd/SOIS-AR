<?php

namespace App\Services\AccomplishmentReportServices;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use iio\libmergepdf\Merger;
use PDF;

use App\Models\OrganizationDocumentType;

class AccomplishmentReportGeneratePDFService
{
    protected $viewDirectory = 'accomplishmentreports.pdfTemplates.';
    protected $temporaryFolderDirectory = '/app/public/compiledDocuments/tmp/';
    /**
     * @param Request $request, Integer $organizationID, Collection $events, Collection $studentAccomplishments, Collection $organizationConstitution
     * Service to generate PDF Accomplishment Report.
     * Returns Array of Final File Name and Folder Name
     * @return array
     */
    public function generate($request, $organizationID, $events, $studentAccomplishments, $organizationConstitution)
    {
        // Get all Keys from Form
        $allKeys= $request->except(['start_date', 'end_date', '_token', 'ar_format', 'range_title']);
        
        // Redirect if there is no event/accomplishment selected
            if (count($allKeys) == 0) 
                return redirect()->action(
                    [AccomplishmentReportsController::class, 'index'])
                    ->with('error', 'No Report Selected!');

        // Get Sorted Events and Accomplishments
        $sortedEvents = $this->sortAndCompileReport($allKeys, $events, 'events');
        $sortedAccomplishments = $this->sortAndCompileReport($allKeys, $studentAccomplishments, 'accomplishments');
        
        // Create Folder and Directory
        $temporaryFolder = 'temporaryFolder-' . uniqid() . '-' . now()->timestamp;
        $this->createDirectory('/app/public/compiledDocuments/tmp', $temporaryFolder);
        $compiledDocuments = array();

        //**********************************************//
        //********** ORGANIZATION CONSTITUTION *********//
        //**********************************************//
        // Append Constitution if Checked
        if ($request->has('constitution')) 
        {
            array_push($compiledDocuments, storage_path('/app/public/' . $organizationConstitution->file));
        }

        //********************************************//
        //********** ORGANIZATION DOCUMENTS **********//
        //********************************************//
        if ($request->has('organizationDocument')) 
        {
            // Collect all Organization Document ID from Request
            $idArray = array();
            foreach ($request->input('organizationDocument') as $key => $value) 
            {
                // Validate Array Values, forget all non-ID friendly numbers and non-integer
                if ((preg_match('/^([1-9][0-9]*)$/', $value)) === 1 )
                    array_push($idArray, $value);
            }
            // Requery Organization Documents based on Array Values checked in the checklist

            $startDate = $request->input('start_date'); $endDate = $request->input('end_date');
            $organizationDocumentTypes = OrganizationDocumentType::with([
                'organizationDocuments' => function ($query) use($startDate, $endDate, $idArray){
                    $query->whereBetween('effective_date', [$startDate, $endDate])
                        ->whereIn('organization_document_id', $idArray)
                        ->orderBy('effective_date', 'DESC')
                        ->orderBy('created_at', 'DESC');},])
                ->whereNotIn('type', ['Constitution'])
                ->where('organization_id', $organizationID)
                ->get();

            // Append each Organization Documents
            foreach ($organizationDocumentTypes as $organizationDocumentType) 
            {
                foreach ($organizationDocumentType->organizationDocuments as $document) 
                {
                    array_push($compiledDocuments, storage_path('/app/public/' . $document->file));
                }
            }
        }
        

        //*****************************************//
        //********** ACCOMPLISHED EVENTS **********//
        //*****************************************//
        // Create Event PDF, save it to File, then add to array, After that get all documents, then add to array
        $appendTitlePage = true;
        foreach($sortedEvents as $event)
        {
            if ($appendTitlePage)
            {
                // Create and Append Event Title Page
                $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
                $dompdf = PDF::loadView($this->viewDirectory . 'eventTitlePage')
                    ->setPaper('letter', 'portrait')
                    ->save(storage_path($this->temporaryFolderDirectory .  $temporaryFolder . '/' . $fileName));
                array_push($compiledDocuments, storage_path($this->temporaryFolderDirectory . $temporaryFolder . '/' . $fileName));
                $appendTitlePage = false;
            }
            $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
            $dompdf = PDF::loadView($this->viewDirectory . 'singlePageEvent', compact('event'))
                ->setPaper('letter', 'portrait')
                ->save(storage_path($this->temporaryFolderDirectory . $temporaryFolder . '/' . $fileName));
            array_push($compiledDocuments, storage_path($this->temporaryFolderDirectory . $temporaryFolder . '/' . $fileName));

            // If Event Images is checked
            if (isset($event['event_images']))
            {
                $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
                $dompdf = PDF::loadView($this->viewDirectory . 'singlePageEventImage', compact('event'))
                    ->setPaper('letter', 'portrait')
                    ->save(storage_path($this->temporaryFolderDirectory . $temporaryFolder . '/' . $fileName));
                array_push($compiledDocuments, storage_path($this->temporaryFolderDirectory . $temporaryFolder . '/' . $fileName));
            }

            // If Event Documents is checked
            if (isset($event['event_documents']))
            {
                foreach ($event['event_documents'] as $document) 
                {
                    array_push($compiledDocuments, storage_path('/app/public/' . $document['file']));
                }
            }
        }


        //*********************************************//
        //********** STUDENT ACCOMPLISHMENTS **********//
        //*********************************************//
        // Create Student Accomplishment PDF, save it to File, then add to array, After that get all documents, then add to array
        $appendTitlePage = true;

        foreach ($sortedAccomplishments as $accomplishment)
        {
            if($appendTitlePage)
            {
                // Create and Append Accomplishment Title Page
                $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
                $dompdf = PDF::loadView($this->viewDirectory . 'accomplishmentTitlePage')->save(storage_path($this->temporaryFolderDirectory . $temporaryFolder . '/' . $fileName));
                array_push($compiledDocuments, storage_path($this->temporaryFolderDirectory . $temporaryFolder . '/' . $fileName));
                $appendTitlePage = false;
            }

            $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
            $dompdf = PDF::loadView($this->viewDirectory . 'singlePageAccomplishment', compact('accomplishment'))
                ->setPaper('letter', 'portrait')
                ->save(storage_path($this->temporaryFolderDirectory . $temporaryFolder . '/' . $fileName));
            array_push($compiledDocuments, storage_path($this->temporaryFolderDirectory . $temporaryFolder . '/' . $fileName));

            // If Accomplishment Evidences/Files is checked
            if (isset($accomplishment['accomplishment_files']))
            {
                foreach ($accomplishment['accomplishment_files'] as $file) 
                {
                    if($file['type'] == 2)
                        array_push($compiledDocuments, storage_path('/app/public/' . $file['file']));
                    elseif($file['type'] == 1)
                    {
                        $fileName2 = uniqid() . '-' . now()->timestamp . '.pdf';
                        $dompdf = PDF::loadView($this->viewDirectory . 'singlePageAccomplishmentImage', compact('file'))
                            ->setPaper('letter', 'portrait')
                            ->save(storage_path($this->temporaryFolderDirectory . $temporaryFolder . '/' . $fileName2));
                        array_push($compiledDocuments, storage_path($this->temporaryFolderDirectory . $temporaryFolder . '/' . $fileName2));
                    }
                }
            }
        }
        // Merge all documents then delete temporary folder
        $finalFolderName = uniqid() . '-' . now()->timestamp;
        $this->createDirectory('/app/public/compiledDocuments/accomplishmentReports', $finalFolderName);
        $finalFileName = uniqid() . '-' . now()->timestamp . '.pdf';
        $this->mergePDF($compiledDocuments, $finalFileName, $finalFolderName);
        $this->deleteDirectory('/tmp/' . $temporaryFolder);

        $ARDirectory = [
            'finalFolderName' => $finalFolderName, 
            'finalFileName' =>$finalFileName
        ];

        return $ARDirectory;
    }

    /**
     * @param Array $keys, Collection $collection, String $reportType
     * Function to Sort and Compile Report using Key Array and Report Collectio
     * WORKS ONLY FOR EVENTS AND STUDENT ACCOMPLISHMENTS
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
     * @param Array $choiceKeyArray, Integer $rowCount, String $category
     * Function to Group Keys using a given key array
     * WORKS FOR sortAndCompileReport FUNCTION ONLY
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
     * Array $documents, String $fileName, String $folderName
     * Function to Merge PDF using documents array.
     * https://github.com/hanneskod/libmergepdf
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
     * @param String $folder
     * Function to Delete Temporary Folder and its contents
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
    
    /**
     * @param String $directory, String $folder
     * Function to create directory if it doesn't exist
     * @return void
     */
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
