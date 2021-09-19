<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Organization;
use App\Models\OrganizationAsset;
use App\Models\SchoolYear;
use App\Models\StudentAccomplishment;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
use iio\libmergepdf\Merger;
use PDF;

/**
 * Handles all Accomplishment Report Requests
 * Libraries:
 * DomPDF, Carbon, LibMergePDF
 */ 

class AccomplishmentReportsController extends Controller
{
    /**
     * Show Index Page, Display Date Ranges
     */
    public function index()
    {
        $schoolYears = SchoolYear::select('year_start', 'year_end', 'school_year_id as id')->orderBy('year_start', 'DESC')->get();
    	return view('accomplishmentreports.index', compact('schoolYears'));
    }

    /**
     * Function to Group Keys using a given key array
     * choiceKeyArray = array() 
     * rowCount = int
     * category = String
     */ 
    public function groupKeysWithAttributes($choiceKeyArray, $rowCount, $category)
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
     * Function to Sort and Compile Report using Key Array and Report Collection
     * keys = array()
     * reportCollection = collection()
     * reportType = String (events, accomplishments)
     */ 
    public function sortAndCompileReport($keys, $reportCollection, $reportType)
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
     * Get request from showChecklist, then Output Final AR
     */
    public function finalizeReport(Request $request)
    {
        // Get and Validate Date
        $date_data = $request->validate([
            'start_date' => 'required|date|date_format:Y-m-d|before_or_equal:now|after:1992-01-01',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date|before_or_equal:now|after:1992-01-01',
        ]);
        // Get all Keys from Form
        $allKeys= $request->except(['start_date', 'end_date', '_token']);
        if (count($allKeys) == 0) 
        {
            return redirect()->action(
                [AccomplishmentReportsController::class, 'index']
            );
        }
        // Fetch Organization Details
        $organization = Organization::where('organization_id', Auth::user()->course->organization_id)->first();

        // Fetch Events and Accomplishments within Dates
        $events = Event::with([
            'eventImages' => function ($query) {
                    $query->orderBy('image_type', 'ASC')->get();},
            'eventDocuments' => function ($query) {
                    $query->orderBy('event_document_type_id', 'ASC')->get();},
                ])
            ->where('organization_id', $organization->organization_id)
            ->whereBetween('start_date', [$date_data['start_date'], $date_data['end_date']])
            ->orderBy('event_role_id', 'ASC')
            ->get();
        $studentAccomplishments = StudentAccomplishment::with([
            'accomplishmentFiles' => function ($query) {
                    $query->orderBy('type', 'ASC')->get();},
            'user',
                ])
            ->where('organization_id', $organization->organization_id)
            ->whereBetween('date_awarded', [$date_data['start_date'], $date_data['end_date']])
            ->where('status', 1)
            ->get();
        

        // Get Sorted Events and Accomplishments
        $sortedEvents = $this->sortAndCompileReport($allKeys, $events, 'events');
        $sortedAccomplishments = $this->sortAndCompileReport($allKeys, $studentAccomplishments, 'accomplishments');
        
        // Create Event PDF, save it to File, then add to array
        // After that get all documents, then add to array
        $compiledDocuments = array();
        // Create Folder
        $folder = uniqid() . '-' . now()->timestamp;
        if (!is_dir(storage_path('/app/public/compiledDocuments/' . $folder))) {
            // dir doesn't exist, make it
            mkdir(storage_path('/app/public/compiledDocuments/' . $folder));
        }

        $temp = true;

        foreach($sortedEvents as $event)
        {
            if ($temp)
            {
                // Create and Append Event Title Page
                $fileName = uniqid() . '-' . now()->timestamp . '.pdf';
                $dompdf = PDF::loadView('accomplishmentreports.eventTitlePage')
                    ->setPaper('letter', 'portrait')
                    ->save(storage_path('/app/public/compiledDocuments/' . $folder . '/' . $fileName));
                array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $folder . '/' . $fileName));
                $temp = false;
            }
            //dd($event);
            $fileName = uniqid() . '-' . now()->timestamp . '.pdf';
            $dompdf = PDF::loadView('accomplishmentreports.singlePageEvent', compact('event'))
                ->setPaper('letter', 'portrait')
                ->save(storage_path('/app/public/compiledDocuments/' . $folder . '/' . $fileName));
            array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $folder . '/' . $fileName));
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
                $fileName = uniqid() . '-' . now()->timestamp . '.pdf';
                $dompdf = PDF::loadView('accomplishmentreports.accomplishmentTitlePage')->save(storage_path('/app/public/compiledDocuments/' . $folder . '/' . $fileName));
                array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $folder . '/' . $fileName));
                $temp = false;
            }
            $fileName = uniqid() . '-' . now()->timestamp . '.pdf';
            $dompdf = PDF::loadView('accomplishmentreports.singlePageAccomplishment', compact('accomplishment'))
                ->setPaper('letter', 'portrait')
                ->save(storage_path('/app/public/compiledDocuments/' . $folder . '/' . $fileName));
            array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $folder . '/' . $fileName));
            if (isset($accomplishment['accomplishment_files']))
            {
                foreach ($accomplishment['accomplishment_files'] as $file) 
                {
                    if($file['type'] == 2)
                        array_push($compiledDocuments, storage_path('/app/public/' . $file['file']));
                    elseif($file['type'] == 1)
                    {
                        $fileName2 = uniqid() . '-' . now()->timestamp . '.pdf';
                        $dompdf = PDF::loadView('accomplishmentreports.singlePageAccomplishmentImage', compact('file'))
                            ->setPaper('letter', 'portrait')
                            ->save(storage_path('/app/public/compiledDocuments/' . $folder . '/' . $fileName2));
                        array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $folder . '/' . $fileName2));
                    }
                }
            }

        }
        //Merge all documents in the array
        $merger = new Merger;
        $merger->addIterator($compiledDocuments);
        $mergedPDF = $merger->merge();
        $fileNameFINAL = 'woooooot.pdf';
        $filePath = storage_path('/app/public/compiledDocuments/' . $fileNameFINAL);
        file_put_contents($filePath, $mergedPDF);

        // Delete Created Folder and its contents
        // first delete contents of the directory, but preserve the directory itself
        Storage::deleteDirectory('/public/compiledDocuments/' . $folder, true);
        // sleep 0.3 second because of race condition with HD
        sleep(0.3);
        // actually delete the folder itself
        Storage::deleteDirectory('/public/compiledDocuments/' . $folder);

        return redirect()->action(
                [AccomplishmentReportsController::class, 'index'])
                ->with('success','Report Generated');
    }

    /**
     * Get request from Index, then Show Checklist Page
     */
    public function showChecklist(Request $request)
    {
        $range = NULL;
        $rangeTitle = NULL;
    	if($request->input('semestral'))
    	{
    		$data = $request->validate([
                'school_year' => 'required|numeric|exists:school_years,school_year_id',
                'first_semester' => 'required_without:second_semester|string',
                'second_semester' => 'required_without:first_semester|string',
            ]);
            $year_data = SchoolYear::where('school_year_id', $data['school_year'])->first();
            if (isset($data['first_semester']))
            {
                $start_date = $year_data->first_semester_start;
                $end_date = $year_data->first_semester_end;
                $range = 'First Semester SY ' . $year_data->year_start . '-' . $year_data->year_end;
            }
            else if (isset($data['second_semester']))
            {
                $start_date = $year_data->second_semester_start;
                $end_date = $year_data->second_semester_end;
                $range = 'Second Semester SY ' . $year_data->year_start . '-' . $year_data->year_end;
            }
            $rangeTitle = 'Semestral';
    	}
        else if ($request->input('quarterly'))
        {
            $data = $request->validate([
                'first_quarter' => 'required_without_all:second_quarter,third_quarter,fourth_quarter|string',
                'second_quarter' => 'required_without_all:first_quarter,third_quarter,fourth_quarter|string',
                'third_quarter' => 'required_without_all:first_quarter,second_quarter,fourth_quarter|string',
                'fourth_quarter' => 'required_without_all:first_quarter,second_quarter,third_quarter|string',
            ]);
            if (isset($data['first_quarter']))
            {
                $start_date = Carbon::parse(date('Y'))->firstOfYear()->firstOfQuarter();
                $end_date = Carbon::parse($start_date)->endOfQuarter();
                $range = 'First Quarter of ' . date('Y');
            }
            else if (isset($data['second_quarter']))
            {
                $start_date = Carbon::parse(date('Y'))->firstOfYear()->addMonths(3)->firstOfQuarter();
                $end_date = Carbon::parse($start_date)->endOfQuarter();
                $range = 'Second Quarter of ' . date('Y');
            }
            else if (isset($data['third_quarter']))
            {
                $start_date = Carbon::parse(date('Y'))->firstOfYear()->addMonths(6)->firstOfQuarter();
                $end_date = Carbon::parse($start_date)->endOfQuarter();
                $range = 'Third Quarter of ' . date('Y');
            }
            else if (isset($data['fourth_quarter']))
            {
                $start_date = Carbon::parse(date('Y'))->firstOfYear()->addMonths(9)->firstOfQuarter();
                $end_date = Carbon::parse($start_date)->endOfQuarter();
                $range = 'Fourth Quarter of ' . date('Y');
            }
            $rangeTitle = 'Quarterly';
        }
        else if($request->input('custom'))
        {
            $data = request()->validate([
                'custom_start_date' => 'required|date|date_format:Y-m-d|before_or_equal:now|after:1992-01-01',
                'custom_end_date' => 'required|date|date_format:Y-m-d|after_or_equal:custom_start_date|before_or_equal:now|after:1992-01-01',
                ]);
            $start_date = Carbon::parse($data['custom_start_date'])->format('F d, Y') ;
            $end_date = Carbon::parse($data['custom_end_date'])->format('F d, Y') ;
        }
        else
        {
            return redirect()->action(
                [AccomplishmentReportsController::class, 'index']);
        }

        //Fetch organization and assets
        $organization = Organization::where('organization_id', Auth::user()->course->organization_id)
            ->first();
        
        // Get all Events within $start_date and $end_date, 
        // then grabs all of their child Event Images and Documents
        // Images Sorted on Image type, Documents on Document Type, Event on Organization's Role
    	$events = Event::with([
            'eventImages' => function ($query) {
                    $query->orderBy('image_type', 'ASC')->get();},
            'eventDocuments' => function ($query) {
                    $query->orderBy('event_document_type_id', 'ASC')->get();},
                ])
            ->where('organization_id', $organization->organization_id)
            ->whereBetween('start_date', [$start_date, $end_date])
    		->orderBy('event_role_id', 'ASC')
    		->get();

        $studentAccomplishments = StudentAccomplishment::with([
            'accomplishmentFiles' => function ($query) {
                    $query->orderBy('type', 'ASC')->get();},
            'user',
                ])
            ->where('organization_id', $organization->organization_id)
            ->whereBetween('date_awarded', [$start_date, $end_date])
            ->where('status', 1)
            ->get();
        //dd($studentAccomplishments);
        return view('accomplishmentreports.showChecklist', 
            compact('events', 'studentAccomplishments', 'range', 'rangeTitle', 'organization', 'start_date', 'end_date')); 
    }
   







}