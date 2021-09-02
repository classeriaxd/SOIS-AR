<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Organization;
use App\Models\OrganizationAsset;
use App\Models\SchoolYear;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use iio\libmergepdf\Merger;
use Barryvdh\DomPDF\Facade;
use PDF;

class EventReportsController extends Controller
{
    public function index()
    {
        $schoolYears = SchoolYear::select('year_start', 'year_end', 'school_year_id as id')->orderBy('year_start', 'DESC')->get();
    	return view('eventreports.index', compact('schoolYears'));
    }

    public function show(Request $request)
    {
    	if($request->input('semestral'))
    	{
    		$data = $request->validate([
                'school_year' => 'required|numeric|exists:school_years,school_year_id',
                'first_semester' => 'required_without:second_semester|string',
                'second_semester' => 'required_without:first_semester|string',
            ]);
            if (isset($data['first_semester']))
            {
                $start_date = SchoolYear::where('school_year_id', $data['school_year'])->value('first_semester_start');
                $end_date = SchoolYear::where('school_year_id', $data['school_year'])->value('first_semester_end');
            }
            else if (isset($data['second_semester']))
            {
                $start_date = SchoolYear::where('school_year_id', $school_year)->value('second_semester_start');
                $end_date = SchoolYear::where('school_year_id', $school_year)->value('second_semester_end');
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
            }
            else if (isset($data['second_quarter']))
            {
                $start_date = Carbon::parse(date('Y'))->firstOfYear()->addMonths(3)->firstOfQuarter();
                $end_date = Carbon::parse($start_date)->endOfQuarter();
            }
            else if (isset($data['third_quarter']))
            {
                $start_date = Carbon::parse(date('Y'))->firstOfYear()->addMonths(6)->firstOfQuarter();
                $end_date = Carbon::parse($start_date)->endOfQuarter();
            }
            else if (isset($data['fourth_quarter']))
            {
                $start_date = Carbon::parse(date('Y'))->firstOfYear()->addMonths(9)->firstOfQuarter();
                $end_date = Carbon::parse($start_date)->endOfQuarter();
            }
            $rangeTitle = 'Quarterly';
        }
        else if($request->input('custom'))
        {
            $data = request()->validate([
                'custom_start_date' => 'required|date|date_format:Y-m-d|before_or_equal:now|after:1992-01-01',
                'custom_end_date' => 'required|date|date_format:Y-m-d|after_or_equal:custom_start_date|before_or_equal:now|after:1992-01-01',
                ]);
            $start_date = Carbon::parse($data['custom_start_date']);
            $end_date = Carbon::parse($data['custom_end_date']);
        }
        else
        {
            return redirect()->action(
                [EventReportsController::class, 'index']);
        }

        //Fetch organization and assets
        $organization = Organization::where('organization_id', Auth::user()->course->organization_id)
            ->first();
        $organization_logo = OrganizationAsset::where('organization_id', $organization->organization_id)
            ->where('type', '1')
            ->select('image')
            ->first();
        
        // Get all Events within $start_date and $end_date, 
        // then grabs all of their child Event Images
        // All sorted ASC on date and image_type respectively
    	$events = Event::with([
            'eventImages' => function ($query) {
                    $query->orderBy('image_type', 'ASC');},
            'eventDocuments' => function ($query) {
                    $query->orderBy('event_document_type_id', 'ASC');},
                ])
            ->where('organization_id', $organization->organization_id)
            ->whereBetween('start_date', [$start_date, $end_date])
    		->orderBy('event_role_id', 'ASC')
    		->get();
        //dd($events);
        $view = false;
        $compiledDocuments = array();
        foreach($events as $event)
        {
            $fileName = uniqid() . '-' . now()->timestamp . '.pdf';
            $dompdf = PDF::loadView('eventreports.singlePageEvent', compact('event', 'view'))->save(storage_path('/app/public/compiledDocuments/' . $fileName));
            array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $fileName));
            foreach ($event->eventDocuments as $document) 
            {
                array_push($compiledDocuments, storage_path('/app/public/' . $document->file));
            }
        }
        $merger = new Merger;
        $merger->addIterator($compiledDocuments);
        $mergedPDF = $merger->merge();
        $fileNameFINAL = 'compiledaheheheheeh.pdf';
        $filePath = storage_path('/app/public/compiledDocuments/' . $fileNameFINAL);
        file_put_contents($filePath, $mergedPDF);

        // if(false)
        // {
        //     // normal view
        //     $view = true;
        //     return view('eventreports.pdf', compact('events', 'start', 'end', 'view', 'organization', 'organization_logo'));
        // }
        // else
        // {
        //     //dompdf views
        //     $view = false;
        //     $dompdf = PDF::loadView('eventreports.pdf', compact('events', 'start', 'end', 'view', 'organization', 'organization_logo'));  
        //     return $dompdf->stream();
        // }

        //download
        //return $dompdf->download("yeet".'Document.pdf');
    }
}
