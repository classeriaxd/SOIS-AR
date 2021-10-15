<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    Event,
    EventImage,
    Organization,
    OrganizationAsset,
    SchoolYear,
    StudentAccomplishment,
    AccomplishmentReport,
    PositionTitle,
    Notification,
};

use App\Http\Requests\AccomplishmentReportRequests\{
    FinalizeReportRequest,
    FinalizeReviewRequest,
};

use App\Services\AccomplishmentReportServices\{
    AccomplishmentReportGeneratePDFService,
    AccomplishmentReportGenerateXLSXService,
    AccomplishmentReportStoreService,
};

use App\Services\NotificationServices\{
    AccomplishmentReportNotificationService,
};

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
                    'status' => 2,
                    'reviewed_by' => Auth::user()->user_id,
                    'remarks' => $request->input('remarks'),
                ]);
                
                $this->deleteDirectory($temporaryFolder);
                $this->deleteDirectory(Str::of(storage_path('/app/public/' . $accomplishmentReport->file))->dirname());

                // Insert to archive table if archive=true
                $accomplishmentReportNotificationService = new AccomplishmentReportNotificationService();
                $accomplishmentReportNotificationService->sendNotificationToOfficer($accomplishmentReport->organization_id, $accomplishmentReport->accomplishment_report_uuid, 'approved');
            }
            else if ($request->has('decline'))
            {
                $accomplishmentReport->update([
                    'status' => 3,
                    'reviewed_by' => Auth::user()->user_id,
                    'remarks' => $request->input('remarks'),
                ]);
                $accomplishmentReportNotificationService = new AccomplishmentReportNotificationService();
                $accomplishmentReportNotificationService->sendNotificationToOfficer($accomplishmentReport->organization_id, $accomplishmentReport->accomplishment_report_uuid, 'declined');
                
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
            'student',
                ])
            ->where('organization_id', $organization->organization_id)
            ->whereBetween('end_date', [$start_date, $end_date])
            ->where('status', 2)
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
        // Fetch Organization Details
        $organization = Organization::where('organization_id', Auth::user()->course->organization_id)->first();

        // Fetch Events and Accomplishments within Dates
        $events = Event::with([
            'eventImages' => function ($query) {
                    $query->orderBy('image_type', 'ASC')->get();},
            'eventDocuments' => function ($query) {
                    $query->orderBy('event_document_type_id', 'ASC')->get();},
            'eventLevel',
            'eventFundSource',
            'organization',
                ])
            ->where('organization_id', $organization->organization_id)
            ->whereBetween('start_date', [$request->input('start_date'), $request->input('end_date')])
            ->orderBy('event_role_id', 'ASC')
            ->get();
        $studentAccomplishments = StudentAccomplishment::with([
            'accomplishmentFiles' => function ($query) {
                    $query->orderBy('type', 'ASC')->get();},
            'student',
            'level',
                ])
            ->where('organization_id', $organization->organization_id)
            ->whereBetween('end_date', [$request->input('start_date'), $request->input('end_date')])
            ->where('status', 2)
            ->get();
        $AltARDirectory = NULL;
        if ($request->input('ar_format') == 'tabular')
        {
            // Generate XLSX AR then Return the directory where it is saved
            $accomplishmentReportGenerateXLSXService = new AccomplishmentReportGenerateXLSXService();
            $ARDirectory = $accomplishmentReportGenerateXLSXService->generate($events, $studentAccomplishments);
            $accomplishmentReportGenerateXLSXService->generate($events, $studentAccomplishments);

            $accomplishmentReportType = 1;
        }

        elseif ($request->input('ar_format') == 'design') 
        {
            // Generate PDF AR then Return the directory where it is saved
            $accomplishmentReportGeneratePDFService = new AccomplishmentReportGeneratePDFService();
            $ARDirectory = $accomplishmentReportGeneratePDFService->generate($request, $events, $studentAccomplishments,);
            $accomplishmentReportType = 2;
        }

        // Store Accomplishment Report
        $accomplishmentReportStoreService = new AccomplishmentReportStoreService();
        $accomplishmentReportUUID = $accomplishmentReportStoreService->store($request, $ARDirectory, $organization, $accomplishmentReportType, $AltARDirectory);
        
        // Send Notification
        $sender = Auth::user()->last_name . ', '.  Auth::user()->first_name . ' ' .  Auth::user()->middle_name;
        $accomplishmentReportNotificationService = new AccomplishmentReportNotificationService();
        $accomplishmentReportNotificationService->sendNotificationToPresident($sender, Auth::user()->course->organization_id, $accomplishmentReportUUID);

        return redirect()->route('accomplishmentReport.show',
            ['accomplishmentReportUUID' => $accomplishmentReportUUID, 'newAccomplishmentReport' => true])
            ->with('success', 'Accomplishment Report Generated. Sent in for President\'s Approval.');
    }
    public function downloadAccomplishmentReport($accomplishmentReportUUID)
    {
        if($accomplishmentReport = AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->first())
        {
            $filePath = storage_path('/app/public/'. $accomplishmentReport->file);

            if ($accomplishmentReport->accomplishment_report_type == 1) 
                $headers = ['Content-Type: application/vnd.ms-excel'];
            else if ($accomplishmentReport->accomplishment_report_type == 2) 
                $headers = ['Content-Type: application/pdf'];
            
            $fileName = Str::limit(Str::slug($accomplishmentReport->title, '-'), 20, '-') .'-AccomplishmentReport.' .  pathinfo(storage_path($filePath), PATHINFO_EXTENSION);

            return response()->download($filePath, $fileName, $headers);
        }
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
    

   







}