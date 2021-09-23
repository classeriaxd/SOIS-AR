<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Organization;
use App\Models\OrganizationAsset;
use App\Models\SchoolYear;
use App\Models\StudentAccomplishment;
use App\Models\AccomplishmentReport;
use App\Models\PositionTitle;
use App\Models\Notification;

use App\Http\Requests\AccomplishmentReportRequests\FinalizeReportRequest;
use App\Http\Requests\AccomplishmentReportRequests\FinalizeReviewRequest;

use App\Controllers\NotificationsController;

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
     * Show Create Page, Display Date Ranges
     */
    public function create()
    {
        $schoolYears = SchoolYear::select('year_start', 'year_end', 'school_year_id as id')->orderBy('year_start', 'DESC')->get();
    	return view('accomplishmentreports.create', compact('schoolYears'));
    }
    /**
     * Show Index Page
     */
    public function index()
    {
        $approvedAccomplishmentReports = AccomplishmentReport::where('status', 2)
            ->where('organization_id', Auth::user()->course->organization_id)
            ->paginate(5, ['*'], 'approved');
        $pendingAccomplishmentReports = AccomplishmentReport::where('status', 1)
            ->where('organization_id', Auth::user()->course->organization_id)
            ->paginate(5, ['*'], 'pending');
        $declinedAccomplishmentReports = AccomplishmentReport::where('status', 3)
            ->where('organization_id', Auth::user()->course->organization_id)
            ->paginate(5,  ['*'], 'declined');
        return view('accomplishmentreports.index', compact('approvedAccomplishmentReports', 'pendingAccomplishmentReports', 'declinedAccomplishmentReports'));
    }

    /**
     * Show Accomplishment Report
     * accomplishmentReportUUID = String
     */
    public function show($accomplishmentReportUUID, $newAccomplishmentReport = false)
    {
        if($accomplishmentReport = AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->first())
        {
            return view('accomplishmentreports.show', compact('accomplishmentReport','newAccomplishmentReport'));
        }
        else
            abort(404);
    }
    /**
     * Show Accomplishment Report Review Page
     * accomplishmentReportUUID = String
     */
    public function review($accomplishmentReportUUID)
    {
        if($accomplishmentReport = AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->first())
        {
            if($accomplishmentReport->status != 1)
                return redirect()->action(
                    [AccomplishmentReportsController::class, 'show'], ['accomplishmentReportUUID' => $accomplishmentReportUUID]
                );
            $loadJSWithoutDefer = true;
            return view('accomplishmentreports.review', compact('accomplishmentReport', 'loadJSWithoutDefer'));
        }
        else
            abort(404);
    }
    /**
     * Get Request from review page
     * accomplishmentReportUUID = String
     */
    public function finalizeReview($accomplishmentReportUUID, FinalizeReviewRequest $request)
    {
        if($accomplishmentReport = AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->first())
        {
            if ($request->has('success'))
            {
                $signatoryDocumentationOfficers = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];
                $signatoryPresident = ['President'];

                $signature = false;
                if($request->has('esignature'))
                    $signature = true;

                $rangeTitle = $accomplishmentReport->range_title;
                $startDate = Carbon::parse($accomplishmentReport->start_date)->format('F d, Y');
                $endDate = Carbon::parse($accomplishmentReport->end_date)->format('F d, Y');

                $documentationSignatory = PositionTitle::with(['users' => function($query){
                    $query->select([DB::raw('CONCAT(first_name, " ", middle_name, " ", last_name) as full_name')]);
                }])
                    ->whereIn('position_title', $signatoryDocumentationOfficers)
                    ->where('organization_id', $accomplishmentReport->organization_id)
                    ->orderBy('position_title', 'DESC')
                    ->get();

                $presidentSignatory = PositionTitle::with(['users' => function($query){
                    $query->select([DB::raw('CONCAT(first_name, " ", middle_name, " ", last_name) as full_name')]);
                }])
                    ->whereIn('position_title', $signatoryPresident)
                    ->where('organization_id', $accomplishmentReport->organization_id)
                    ->first();

                $organization = Organization::with('assets')
                    ->where('organization_id', $accomplishmentReport->organization_id)
                    ->first();
                
                // Create temporary folder directory
                $temporaryFolder = 'tmp/temporaryFolder-' . uniqid() . '-' . now()->timestamp;
                if (!is_dir(storage_path('/app/public/compiledDocuments/tmp/'))) {
                    // dir doesn't exist, make it
                    mkdir(storage_path('/app/public/compiledDocuments/tmp/'));
                }
                if (!is_dir(storage_path('/app/public/compiledDocuments/' . $temporaryFolder))) {
                    // dir doesn't exist, make it
                    mkdir(storage_path('/app/public/compiledDocuments/' . $temporaryFolder));
                }

                // Create Array and insert accomplishment report first
                $compiledDocuments = array(storage_path('/app/public/' . $accomplishmentReport->file));

                // Create Signatory Page PDF then insert to Array
                $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
                $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.signatoryPage', compact('documentationSignatory', 'presidentSignatory', 'organization', 'signature'))
                    ->setPaper('letter', 'portrait')
                    ->save(storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
                array_unshift($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));

                // Create Title Page PDF then insert to Array
                $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
                $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.titlePage', compact('organization', 'rangeTitle', 'startDate', 'endDate'))
                    ->setPaper('letter', 'portrait')
                    ->save(storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
                array_unshift($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));


                // Merge all documents then delete temporary folder
                $finalFolderName = uniqid() . '-' . now()->timestamp;
                if (!is_dir(storage_path('/app/public/compiledDocuments/accomplishmentReports/'))) {
                    // dir doesn't exist, make it
                    mkdir(storage_path('/app/public/compiledDocuments/accomplishmentReports/'));
                }
                if (!is_dir(storage_path('/app/public/compiledDocuments/accomplishmentReports/' . $finalFolderName))) {
                    // dir doesn't exist, make it
                    mkdir(storage_path('/app/public/compiledDocuments/accomplishmentReports/' . $finalFolderName));
                }

                $finalFileName = uniqid() . '-' . now()->timestamp . '.pdf';
                $this->mergePDF($compiledDocuments, $finalFileName, $finalFolderName);
                $archive = ($request->has('archive')) ? 1 : 0;
                $accomplishmentReport->update([
                    'file' => '/compiledDocuments/accomplishmentReports/' . $finalFolderName . '/' . $finalFileName,
                    'for_archive' => $archive,
                    'status' => 2,
                    'reviewed_by' => Auth::user()->user_id,
                    'remarks' => $request->input('remarks'),
                ]);
                
                $this->deleteDirectory($temporaryFolder);
                $this->deleteDirectory(Str::of(storage_path('/app/public/' . $accomplishmentReport->file))->dirname());

                // Insert to archive table if archive=true

                $this->sendNotificationToOfficer($accomplishmentReport->organization_id, $accomplishmentReport->accomplishment_report_uuid, 'approved');
                

            }
            else if ($request->has('decline'))
            {
                $accomplishmentReport->update([
                    'status' => 3,
                    'reviewed_by' => Auth::user()->user_id,
                    'remarks' => $request->input('remarks'),
                ]);
                $this->sendNotificationToOfficer($accomplishmentReport->organization_id, $accomplishmentReport->accomplishment_report_uuid, 'declined');
                
            }
            return redirect()->action(
                [AccomplishmentReportsController::class, 'index']);
            
        }
        else
            abort(404);
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
                $start_date = Carbon::parse(date('Y'))->firstOfYear()->firstOfQuarter()->format('Y-m-d');
                $end_date = Carbon::parse($start_date)->endOfQuarter()->format('Y-m-d');
                $range = 'First Quarter of ' . date('Y');
            }
            else if (isset($data['second_quarter']))
            {
                $start_date = Carbon::parse(date('Y'))->firstOfYear()->addMonths(3)->firstOfQuarter()->format('Y-m-d');
                $end_date = Carbon::parse($start_date)->endOfQuarter()->format('Y-m-d');
                $range = 'Second Quarter of ' . date('Y');
            }
            else if (isset($data['third_quarter']))
            {
                $start_date = Carbon::parse(date('Y'))->firstOfYear()->addMonths(6)->firstOfQuarter()->format('Y-m-d');
                $end_date = Carbon::parse($start_date)->endOfQuarter()->format('Y-m-d');
                $range = 'Third Quarter of ' . date('Y');
            }
            else if (isset($data['fourth_quarter']))
            {
                $start_date = Carbon::parse(date('Y'))->firstOfYear()->addMonths(9)->firstOfQuarter()->format('Y-m-d');
                $end_date = Carbon::parse($start_date)->endOfQuarter()->format('Y-m-d');
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
            $start_date = $data['custom_start_date'];
            $end_date = $data['custom_end_date'];
            $range = Carbon::parse($start_date)->format('F d, Y') . ' - ' . Carbon::parse($end_date)->format('F d, Y');
            $rangeTitle = 'Custom';

        }
        else
        {
            return redirect()->action(
                [AccomplishmentReportsController::class, 'index']);
        }
        
        //Fetch organization and assets
        $organization = Organization::where('organization_id', Auth::user()->course->organization_id)
            ->first();
        //dd($start_date, $end_date);
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
        $loadJSWithoutDefer = true;
        return view('accomplishmentreports.showChecklist', 
            compact('events', 'studentAccomplishments', 'range', 'rangeTitle', 'organization', 'start_date', 'end_date', 'loadJSWithoutDefer')); 
    }

    /**
     * Get request from showChecklist, then Output Final AR
     */
    public function finalizeReport(FinalizeReportRequest $request)
    {
        // Get Date, Format, Archive, and Range Title
        $dateData = $request->only(['start_date', 'end_date']);
        $format = $request->only('ar_format');
        $archive = $request->has('archive') ? 1 : 0;
        $rangeTitleRequest = $request->only('range_title');
        $rangeTitle = NULL;
        // change range title
        switch ($rangeTitleRequest['range_title']) {
            case 'Semestral':
                $rangeTitle = 1;
                break;
            case 'Quarterly':
                $rangeTitle = 2;
                break;
            case 'Custom':
                $rangeTitle = 3;
                break;
        }

        // Get all Keys from Form
        $allKeys= $request->except(['start_date', 'end_date', '_token', 'ar_format', 'range_title']);
        if (count($allKeys) == 0) 
        {
            return redirect()->action(
                [AccomplishmentReportsController::class, 'index'])
                ->with('error', 'No Report Selected!');
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
            ->whereBetween('start_date', [$dateData['start_date'], $dateData['end_date']])
            ->orderBy('event_role_id', 'ASC')
            ->get();
        $studentAccomplishments = StudentAccomplishment::with([
            'accomplishmentFiles' => function ($query) {
                    $query->orderBy('type', 'ASC')->get();},
            'user',
                ])
            ->where('organization_id', $organization->organization_id)
            ->whereBetween('date_awarded', [$dateData['start_date'], $dateData['end_date']])
            ->where('status', 1)
            ->get();
        

        // Get Sorted Events and Accomplishments
        $sortedEvents = $this->sortAndCompileReport($allKeys, $events, 'events');
        $sortedAccomplishments = $this->sortAndCompileReport($allKeys, $studentAccomplishments, 'accomplishments');
        
        // Create Folder and Directory
            $temporaryFolder = 'tmp/temporaryFolder-' . uniqid() . '-' . now()->timestamp;
            if (!is_dir(storage_path('/app/public/compiledDocuments/tmp/'))) {
                // dir doesn't exist, make it
                mkdir(storage_path('/app/public/compiledDocuments/tmp/'));
            }
            if (!is_dir(storage_path('/app/public/compiledDocuments/' . $temporaryFolder))) {
                // dir doesn't exist, make it
                mkdir(storage_path('/app/public/compiledDocuments/' . $temporaryFolder));
            }

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
                    ->save(storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
                array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
                $temp = false;
            }
            //dd($event);
            $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
            $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.singlePageEvent', compact('event'))
                ->setPaper('letter', 'portrait')
                ->save(storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
            array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
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
                $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.accomplishmentTitlePage')->save(storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
                array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
                $temp = false;
            }
            $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
            $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.singlePageAccomplishment', compact('accomplishment'))
                ->setPaper('letter', 'portrait')
                ->save(storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
            array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
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
                            ->save(storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName2));
                        array_push($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName2));
                    }
                }
            }
        }
        // Merge all documents then delete temporary folder
            $finalFolderName = uniqid() . '-' . now()->timestamp;
            if (!is_dir(storage_path('/app/public/compiledDocuments/accomplishmentReports/'))) {
                // dir doesn't exist, make it
                mkdir(storage_path('/app/public/compiledDocuments/accomplishmentReports/'));
            }
            if (!is_dir(storage_path('/app/public/compiledDocuments/accomplishmentReports/' . $finalFolderName))) {
                // dir doesn't exist, make it
                mkdir(storage_path('/app/public/compiledDocuments/accomplishmentReports/' . $finalFolderName));
            }
        $finalFileName = uniqid() . '-' . now()->timestamp . '.pdf';
        $this->mergePDF($compiledDocuments, $finalFileName, $finalFolderName);
        $this->deleteDirectory($temporaryFolder);

        // Create new CompiledDocument model
        $accomplishmentReportUUID = AccomplishmentReport::create([
            'accomplishment_report_uuid' => Str::uuid(),
            'organization_id' => $organization->organization_id,
            'created_by' => Auth::user()->user_id,
            'title' => $request->input('title'),
            'description' => $request->input('description', NULL),
            'file' => '/compiledDocuments/accomplishmentReports/' . $finalFolderName . '/' . $finalFileName,
            'for_archive' => $archive,
            'start_date' => $dateData['start_date'],
            'end_date' => $dateData['end_date'],
            'range_title' => $rangeTitle,
        ])->accomplishment_report_uuid;
        
        $senderDetails = User::where('user_id', Auth::user()->user_id)->select('first_name', 'middle_name', 'last_name')->first();
        $sender = $senderDetails->last_name . ', '. $senderDetails->first_name . ' ' . $senderDetails->middle_name;
        $this->sendNotificationToPresident($sender, Auth::user()->course->organization_id, $accomplishmentReportUUID);
        return redirect()->route('accomplishmentReport.show',
            ['accomplishmentReportUUID' => $accomplishmentReportUUID, 'newAccomplishmentReport' => true])
            ->with('success', 'Accomplishment Report Generated. Sent in for President\'s Approval.');
    }
    
    /**
     * Function to Send Notification to Organization President
     * about new Accomplishment Report
     * 
     * sender = String
     * recieverOrganizationId = int
     * accomplishmentReportUUID = String
     * type = String (System,Event,SA,AR)
     */ 
    public function sendNotificationToPresident($sender, $recieverOrganizationId, $accomplishmentReportUUID, $type = 4)
    {
        $validPositions = ['President'];
        $recievingPositions = PositionTitle::where('organization_id', $recieverOrganizationId)
            ->whereIn('position_title', $validPositions)
            ->pluck('position_title_id');
        $recievingUsers = array();
        foreach($recievingPositions as $reciever)
        {
            $recievingUserId = DB::table('users_position_titles')->where('position_title_position_title_id', $reciever)->value('user_user_id');
            if ($recievingUserId != NULL) 
                array_push($recievingUsers,$recievingUserId);
        }

        if (count($recievingUsers) > 0)
        {
            foreach($recievingUsers as $reciever)
            {
                if ($reciever != NULL)
                {
                    $notificationTitle = "New Accomplishment Report Submission";
                    $notificationDescription = 'An Officer named ' . $sender . ' sent an Accomplishment Report Submission. Please review it!';
                    $notificationType = $type;
                    $notificationLink = $accomplishmentReportUUID;
                    Notification::create([
                        'user_id' => $reciever,
                        'title' => $notificationTitle,
                        'description' => $notificationDescription,
                        'type' => $notificationType,
                        'link' => $notificationLink,
                    ]);
                }
            }
        }
    }
    /**
     * Function to Send Notification to Documentation Officer
     * about Accomplishment Report status
     * 
     * sender = String
     * recieverOrganizationId = int
     * accomplishmentReportUUID = String
     * status = String(approved,declined)
     * type = String (System,Event,SA,AR)
     */ 
    public function sendNotificationToOfficer($recieverOrganizationId, $accomplishmentReportUUID, $status, $type = 4)
    {
        $validPositions = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];
        $recievingPositions = PositionTitle::where('organization_id', $recieverOrganizationId)
            ->whereIn('position_title', $validPositions)
            ->pluck('position_title_id');
        $recievingUsers = array();
        foreach($recievingPositions as $reciever)
        {
            $recievingUserId = DB::table('users_position_titles')->where('position_title_position_title_id', $reciever)->value('user_user_id');
            if ($recievingUserId != NULL) 
                array_push($recievingUsers,$recievingUserId);
        }

        $notificationType = $type;
        $notificationLink = $accomplishmentReportUUID;

        if (count($recievingUsers) > 0)
        {
            foreach($recievingUsers as $reciever)
            {
                if ($reciever != NULL)
                {
                    if($status == 'approved')
                    {
                        $notificationTitle = "AR Submission approved!";
                        $notificationDescription = "Your Accomplishment Report Submission has been approved.";

                    }
                    else if($status == 'declined')
                    {
                        $notificationTitle = "AR Submission declined.";
                        $notificationDescription = "Your Accomplishment Report Submission has been declined.";
                    }
                    
                    Notification::create([
                        'user_id' => $reciever,
                        'title' => $notificationTitle,
                        'description' => $notificationDescription,
                        'type' => $notificationType,
                        'link' => $notificationLink,
                    ]);
                }
            }
        }
    }
    /**
     * Function to Sort and Compile Report using Key Array and Report Collection
     * keys = array()
     * reportCollection = collection()
     * reportType = String (events, accomplishments)
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

   







}