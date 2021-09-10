<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Organization;
use App\Models\OrganizationAsset;
use App\Models\SchoolYear;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
use iio\libmergepdf\Merger;
use PDF;

class EventReportsController extends Controller
{
    public function index()
    {
        $schoolYears = SchoolYear::select('year_start', 'year_end', 'school_year_id as id')->orderBy('year_start', 'DESC')->get();
    	return view('eventreports.index', compact('schoolYears'));
    }
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
                    default:
                        break;
                }
            }
            $temp += 1;
        }
        return $newArray;
    }
    public function finalizeReport(Request $request)
    {
        // Get and Validate Date
        $date_data = $request->validate([
            'start_date' => 'required|date|date_format:Y-m-d|before_or_equal:now|after:1992-01-01',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date|before_or_equal:now|after:1992-01-01',
        ]);
        // Fetch Organization Details
        $organization = Organization::where('organization_id', Auth::user()->course->organization_id)->first();
        // Fetch Events within Dates
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

        // Get all Keys from Form
        $allKeys= $request->except(['start_date', 'end_date', '_token']);
        // Filter Event Keys
        $eventKeys = Arr::where($allKeys, function ($value, $key) {
            if(Str::startsWith($key, 'event'))
                return $key;
        });

        // Remake array, only keys remain
        $eventKeys = array_keys($eventKeys);
        // Group Keys, add attributes
        $eventWithAttributes = $this->groupKeysWithAttributes($eventKeys, $events->count(), 'events');

        $sortedEvents = collect([]);
        foreach ($eventWithAttributes as $key => $value) 
        {
            // If details attribute is set, add event to new Collection
            if (isset($value['details']))
            {
                // Get current event using Key from original Event Query
                $currentEvent = collect($events->get($key));
                // If images is not set, remove from current event
                if((! isset($value['images'])) && ($currentEvent['event_images'] != NULL))
                    $currentEvent->forget('event_images');
                // If documents is not set, remove from current event
                if((! isset($value['documents'])) && ($currentEvent['event_documents'] != NULL))
                    $currentEvent->forget('event_documents');
                // Push updated current event to a new collection
                $sortedEvents->push($currentEvent);
            }
        }
        // Create Event PDF, save it to File, then add to array
        // After that get all documents, then add to array
        $compiledDocuments = array();
        foreach($sortedEvents as $event)
        {
            //dd($event);
            $fileName = uniqid() . '-' . now()->timestamp . '.pdf';
            $dompdf = PDF::loadView('eventreports.singlePageEvent', compact('event'))->save(storage_path('/app/public/compiledDocuments/' . $fileName));
            array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $fileName));
            if (isset($event['event_documents']))
            {
                foreach ($event['event_documents'] as $document) 
                {
                    array_push($compiledDocuments, storage_path('/app/public/' . $document['file']));
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

        return redirect()->action(
                [EventReportsController::class, 'index']);
    }
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
                [EventReportsController::class, 'index']);
        }

        //Fetch organization and assets
        $organization = Organization::where('organization_id', Auth::user()->course->organization_id)
            ->first();
        // $organization_logo = OrganizationAsset::where('organization_id', $organization->organization_id)
        //     ->where('type', '1')
        //     ->select('image')
        //     ->first();
        
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
            //dd($events);
        $studentAccomplishments = collect(NULL);
        return view('eventreports.showChecklist', compact('events', 'studentAccomplishments', 'range', 'rangeTitle', 'organization', 'start_date', 'end_date'));
        
    }
    

}


