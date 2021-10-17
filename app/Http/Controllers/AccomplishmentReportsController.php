<?php

namespace App\Http\Controllers;

use App\Models\{
    Event,
    Organization,
    SchoolYear,
    StudentAccomplishment,
    AccomplishmentReport,
};

use App\Http\Requests\AccomplishmentReportRequests\{
    FinalizeReportRequest,
    FinalizeReviewRequest,
};

use App\Services\AccomplishmentReportServices\{
    AccomplishmentReportGeneratePDFService,
    AccomplishmentReportGenerateXLSXService,
    AccomplishmentReportStoreService,
    AccomplishmentReportReviewService,
};

use App\Services\NotificationServices\{
    AccomplishmentReportNotificationService,
};

use Illuminate\{
    Http\Request,
    Support\Str,
    Support\Facades\Auth,
};

use Carbon\Carbon;
use iio\libmergepdf\Merger;
use PDF;

/**
 * Handles all Accomplishment Report Requests, Services, and Exports
 * Libraries:
 * DomPDF, Carbon, LibMergePDF
 */

// Remaining tasks: showChecklist()
class AccomplishmentReportsController extends Controller
{
    /**
     * Function to show page to create accomplishment report
     * @return View
     */ 
    public function create()
    {
        $schoolYears = SchoolYear::select('year_start', 'year_end', 'school_year_id as id')->orderBy('year_start', 'DESC')->get();
    	return view('accomplishmentreports.create', compact('schoolYears'));
    }

    /**
     * Function to show index page for all accomplishment reports
     * @return View
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
     * @param String $accomplishmentReportUUID
     * Function to show specific accomplishment report
     * @return View
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
     * @param String $accomplishmentReportUUID
     * Function to show review page for an accomplishment report
     * @return View
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
     * @param Request $request, String $accomplishmentReportUUID
     * Function to review the submitted Accomplishment Report
     * @return Redirect Response
     */ 
    public function finalizeReview(FinalizeReviewRequest $request, $accomplishmentReportUUID)
    {
        if($accomplishmentReport = AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->first())
        {
            $accomplishmentReportReviewService = new AccomplishmentReportReviewService();
            $message = $accomplishmentReportReviewService->reviewAccomplishmentReport($accomplishmentReport, $request);

            return redirect()->action(
                [AccomplishmentReportsController::class, 'index'])
                ->with('success', $message);
            
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
     * @param Request $request
     * Function to compile events and student accomplishment to finalize the Accomplishment Report
     * @return Redirect Response
     */ 
    public function finalizeReport(FinalizeReportRequest $request)
    {
        // Fetch Organization Details
        $organization = Organization::where('organization_id', Auth::user()->course->organization_id)
            ->select('organization_id')
            ->first();

        // Fetch Events and Accomplishments within Dates
        $events = Event::with([
                'eventImages' => function ($query) {
                        $query->orderBy('image_type', 'ASC')->get();},
                'eventDocuments' => function ($query) {
                        $query->orderBy('event_document_type_id', 'ASC')->get();},
                'eventLevel',
                'eventFundSource',
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

        $accomplishmentReportStoreService = new AccomplishmentReportStoreService();

        if ($request->input('ar_format') == 'tabular')
        {
            // Generate XLSX AR then Return the directory where it is saved
            $accomplishmentReportGenerateXLSXService = new AccomplishmentReportGenerateXLSXService();
            $ARDirectory = $accomplishmentReportGenerateXLSXService->generate($events, $studentAccomplishments);
            $accomplishmentReportGenerateXLSXService->generate($events, $studentAccomplishments);

            // Assign Report Type for Tabular
            $accomplishmentReportType = 1;

            // Store Accomplishment Report
            $accomplishmentReportUUID = $accomplishmentReportStoreService->store($request, $ARDirectory, $organization, $accomplishmentReportType);

            // Send Notification to Organization President
            $this->sendNotificationToPresident($accomplishmentReportUUID);

            // Automatic approval for Tabular reports
            $accomplishmentReportReviewService = new AccomplishmentReportReviewService();
            $accomplishmentReport = AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->first();
            $accomplishmentReportReviewService->approveAccomplishmentReport_Tabular($accomplishmentReport);

            // Go to AR Page
            return redirect()->route('accomplishmentReport.show',
                ['accomplishmentReportUUID' => $accomplishmentReportUUID, 'newAccomplishmentReport' => true])
                ->with('success', 'Accomplishment Report Generated and Approved. No approval process is required for Tabular Reports.');
        }

        elseif ($request->input('ar_format') == 'design') 
        {
            // Generate PDF AR then Return the directory where it is saved
            $accomplishmentReportGeneratePDFService = new AccomplishmentReportGeneratePDFService();
            $ARDirectory = $accomplishmentReportGeneratePDFService->generate($request, $events, $studentAccomplishments,);

            // Assign Report Type for Design
            $accomplishmentReportType = 2;

            // Store Accomplishment Report
            $accomplishmentReportUUID = $accomplishmentReportStoreService->store($request, $ARDirectory, $organization, $accomplishmentReportType);

            // Send Notification to Organization President
            $this->sendNotificationToPresident($accomplishmentReportUUID);

            // Go to AR Page
            return redirect()->route('accomplishmentReport.show',
                ['accomplishmentReportUUID' => $accomplishmentReportUUID, 'newAccomplishmentReport' => true])
                ->with('success', 'Accomplishment Report Generated. Sent in for President\'s Approval.');
        }
    }

    /**
     * @param String $accomplishmentReportUUID
     * Function to send a download Response for an Accomplishment Report
     * @return Response
     */ 
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
     * @param String $accomplishmentReportUUID
     * Function to send notification to Organization President
     * @return void
     */ 
    private function sendNotificationToPresident($accomplishmentReportUUID)
    {
        // Get Sender Details
        $sender = Auth::user()->last_name . ', '.  Auth::user()->first_name . ' ' .  Auth::user()->middle_name;

        // Send Notification to Organization President
        $accomplishmentReportNotificationService = new AccomplishmentReportNotificationService();
        $accomplishmentReportNotificationService->sendNotificationToPresident($sender, Auth::user()->course->organization_id, $accomplishmentReportUUID);
    }

}