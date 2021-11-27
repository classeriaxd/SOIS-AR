<?php

namespace App\Http\Controllers;

use App\Models\{
    Event,
    Organization,
    SchoolYear,
    StudentAccomplishment,
    AccomplishmentReport,
    AccomplishmentReportType,
    OrganizationDocument,
    OrganizationDocumentType,
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


use Illuminate\Database\Eloquent\Builder;

use Carbon\Carbon;
use iio\libmergepdf\Merger;
use PDF;
/**
 * Handles all Accomplishment Report Requests, Services, and Exports
 * Libraries: DomPDF, Carbon, LibMergePDF
 */

// Remaining tasks: showChecklist()
class AccomplishmentReportsController extends Controller
{
    protected $viewDirectory = 'accomplishmentReports.';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Function to show index page for all accomplishment reports
     * @return View
     */ 
    public function index()
    {
        // Pluck all User Roles
        $userRoleCollection = Auth::user()->roles;

        // Remap User Roles into array with Organization ID
        $userRoles = array();
        foreach ($userRoleCollection as $role) 
        {
            array_push($userRoles, ['role' => $role->role, 'organization_id' => $role->pivot->organization_id]);
        }

        // Array to store variables to send to View
        $compactVariables = array();

        // If User has AR President Admin role...
        if ( ($userRoleKey = $this->hasRole($userRoles, 'AR President Admin')) !== false ? true : false)
        {
            // Get the Organization from which the user is AR President Admin
            $organizationID = $userRoles[$userRoleKey]['organization_id'];
            
            // Query the pending accomplishment reports under this Organization
            $pendingAccomplishmentReports = AccomplishmentReport::with('accomplishmentReportType')
                ->where('status', 1)
                ->where('organization_id', $organizationID)
                ->paginate(30, ['*'], 'pendingAR');
            
            $organizationAccomplishmentReports = AccomplishmentReport::with('accomplishmentReportType')
                ->where('organization_id', $organizationID)
                ->paginate(30, ['*'], 'orgAR');

            array_push($compactVariables, 'pendingAccomplishmentReports', 'organizationAccomplishmentReports');
        }

        // If User has AR Officer Admin role...
        if ( ($userRoleKey = $this->hasRole($userRoles, 'AR Officer Admin')) !== false ? true : false)
        {
            // Get the Organization from which the user is AR President Admin
            $organizationID = $userRoles[$userRoleKey]['organization_id'];

            $organizationAccomplishmentReports = AccomplishmentReport::with('accomplishmentReportType')
                ->where('organization_id', $organizationID)
                ->paginate(30, ['*'], 'orgAR');

            array_push($compactVariables, 'organizationAccomplishmentReports');
        }

        return view($this->viewDirectory . 'index', compact($compactVariables));
    }

    /**
     * Function to show page to create accomplishment report
     * @return View
     */ 
    public function create()
    {
        $schoolYears = SchoolYear::select('year_start', 'year_end', 'school_year_id as id')
            ->orderBy('year_start', 'DESC')
            ->get();

        return view($this->viewDirectory . 'create', compact('schoolYears'));
    }

    /**
     * @param String $accomplishmentReportUUID
     * Function to show specific accomplishment report
     * @return View
     */ 
    public function show($accomplishmentReportUUID, $newAccomplishmentReport = false)
    {
        abort_if(! AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->exists(), 404);

        $accomplishmentReport = AccomplishmentReport::with('accomplishmentReportType', 'reviewer')
            ->where('accomplishment_report_uuid', $accomplishmentReportUUID)
            ->first();
        return view($this->viewDirectory . 'show', compact('accomplishmentReport','newAccomplishmentReport')); 
    }

    /**
     * @param String $accomplishmentReportUUID
     * Function to show review page for an accomplishment report
     * @return View
     */ 
    public function review($accomplishmentReportUUID)
    {
        abort_if(! AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->exists(), 404);

        $accomplishmentReport = AccomplishmentReport::with('accomplishmentReportType')->where('accomplishment_report_uuid', $accomplishmentReportUUID)->first();

        // Redirect if Status is not Pending, or AR type is Tabular
        if($accomplishmentReport->status !== 1 || $accomplishmentReport->accomplishment_report_type_id === 1)
            return redirect()->action(
                [AccomplishmentReportsController::class, 'show'], ['accomplishmentReportUUID' => $accomplishmentReportUUID]);

        return view($this->viewDirectory . 'review', compact('accomplishmentReport'));
    }

    /**
     * @param Request $request, String $accomplishmentReportUUID
     * Function to review the submitted Accomplishment Report
     * @return Redirect Response
     */ 
    public function finalizeReview(FinalizeReviewRequest $request, $accomplishmentReportUUID)
    {
        abort_if(! AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->exists(), 404);

        $returnArray = (new AccomplishmentReportReviewService())->reviewAccomplishmentReport($accomplishmentReportUUID, $request);

        return redirect()->action(
            [AccomplishmentReportsController::class, 'show'], ['accomplishmentReportUUID' => $accomplishmentReportUUID])
            ->with($returnArray['message']);
    }

    /**
     * @param Request $request
     * Function to show checklist from Create Page
     * @return View
     */
    public function showChecklist(Request $request)
    {
        // Pluck all User Roles
        $userRoleCollection = Auth::user()->roles;

        // Remap User Roles into array with Organization ID
        $userRoles = array();
        foreach ($userRoleCollection as $role) 
        {
            array_push($userRoles, ['role' => $role->role, 'organization_id' => $role->pivot->organization_id]);
        }

        // If User has AR Officer Admin role...
        if ( ($userRoleKey = $this->hasRole($userRoles, 'AR Officer Admin')) !== false ? true : false)
        {
            // Get the Organization from which the user is AR Officer Admin
            $organizationID = $userRoles[$userRoleKey]['organization_id'];
            $organization = Organization::where('organization_id', $organizationID)->first();

            $range = NULL;
            $rangeTitle = NULL;

            // Get Date Range/Title
                if($request->input('semestral'))
                {
                    $rangeTitle = 'Semestral';
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
                }
                else if ($request->input('quarterly'))
                {
                    $rangeTitle = 'Quarterly';
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
                }
                else if($request->input('custom'))
                {
                    $rangeTitle = 'Custom';
                    $data = request()->validate([
                        'custom_start_date' => 'required|date|date_format:Y-m-d|before_or_equal:now|after:1992-01-01',
                        'custom_end_date' => 'required|date|date_format:Y-m-d|after_or_equal:custom_start_date|before_or_equal:now|after:1992-01-01',
                        ]);
                    $start_date = $data['custom_start_date'];
                    $end_date = $data['custom_end_date'];
                    $range = Carbon::parse($start_date)->format('F d, Y') . ' - ' . Carbon::parse($end_date)->format('F d, Y');
                }
                else
                    return redirect()->action(
                        [AccomplishmentReportsController::class, 'index']);

            // Get the latest Constitution from the Organization's Documents
            $organizationConstitution = OrganizationDocument::whereHas(
                'documentType', function(Builder $query) use($organizationID){
                    $query->where('type', 'Constitution')->where('organization_id', $organizationID);},)
                ->orderBy('effective_date', 'DESC')
                ->first();

            // Get the other Organization Documents that fall under the Start and End Dates
            $organizationDocumentTypes = OrganizationDocumentType::with([
                'organizationDocuments' => function ($query) use($start_date, $end_date){
                    $query->whereBetween('effective_date', [$start_date, $end_date])
                        ->orderBy('effective_date', 'DESC')
                        ->orderBy('created_at', 'DESC')
                        ;},])
                ->whereNotIn('type', ['Constitution'])
                ->where('organization_id', $organizationID)
                ->get();

            // Get all Events within $start_date and $end_date, then grabs all of their child Event Images and Documents. 
            //Images Sorted on Image type, Documents on Document Type, Event on Organization's Role
            $events = Event::with(
                    'eventCategory:event_category_id,category,text_color,background_color', 
                    'eventRole:event_role_id,event_role,text_color,background_color', )
                ->withCount('eventImages', 'eventDocuments')
                ->where('organization_id', $organizationID)
                ->whereBetween('start_date', [$start_date, $end_date])
                ->orderBy('event_role_id', 'ASC')
                ->get();
            
            $studentAccomplishments = StudentAccomplishment::with('student')
                ->withCount('accomplishmentFiles')
                ->where('organization_id', $organizationID)
                ->whereBetween('end_date', [$start_date, $end_date])
                ->where('status', 2)
                ->get();
            
            $accomplishmentReportTypes = AccomplishmentReportType::all();

            return view($this->viewDirectory . 'showChecklist', 
                compact(
                    'organizationConstitution',
                    'organizationDocumentTypes',
                    'events', 
                    'studentAccomplishments', 
                    'accomplishmentReportTypes', 
                    'range', 
                    'rangeTitle', 
                    'organization', 
                    'start_date', 
                    'end_date',)); 
        }
        else
            abort(403);
    }

    /**
     * FinalizeReportRequest $request
     * @param Request $request
     * Function to compile events and student accomplishment to finalize the Accomplishment Report
     * @return Redirect Response
     */ 
    public function finalizeReport(FinalizeReportRequest $request)
    {
        // Pluck all User Roles
        $userRoleCollection = Auth::user()->roles;

        // Remap User Roles into array with Organization ID
        $userRoles = array();
        foreach ($userRoleCollection as $role) 
        {
            array_push($userRoles, ['role' => $role->role, 'organization_id' => $role->pivot->organization_id]);
        }

        // If User has AR Officer Admin role...
        if ( ($userRoleKey = $this->hasRole($userRoles, 'AR Officer Admin')) !== false ? true : false)
        {
            // Get the Organization from which the user is AR Officer Admin
            $organizationID = $userRoles[$userRoleKey]['organization_id'];

            // Get the one latest Constitution from the Organization's Documents
            $organizationConstitution = OrganizationDocument::whereHas(
                'documentType', function(Builder $query) use($organizationID){
                    $query->where('type', 'Constitution')->where('organization_id', $organizationID);},)
                ->orderBy('effective_date', 'DESC')
                ->first();

            // Fetch Events within Dates
            $events = Event::with([
                    'eventImages' => function ($query) {
                            $query->orderBy('image_type', 'ASC')->get();},
                    'eventDocuments' => function ($query) {
                            $query->orderBy('event_document_type_id', 'ASC')->get();},
                    'eventDocuments.documentType:event_document_type_id,document_type',
                    'eventLevel:level_id,level',
                    'eventFundSource:fund_source_id,fund_source',
                    'eventCategory:event_category_id,category,text_color,background_color', 
                    'eventRole:event_role_id,event_role,text_color,background_color', 
                    'eventNature:event_nature_id,nature',
                    'eventClassification:event_classification_id,classification',
                        ])
                ->where('organization_id', $organizationID)
                ->whereBetween('start_date', [$request->input('start_date'), $request->input('end_date')])
                ->orderBy('event_role_id', 'ASC')
                ->get();

            // Fetch Student Accomplishments within Dates
            $studentAccomplishments = StudentAccomplishment::with(
                    'accomplishmentFiles.documentType',
                    'student',
                    'level:level_id,level',)
                ->where('organization_id', $organizationID)
                ->whereBetween('end_date', [$request->input('start_date'), $request->input('end_date')])
                ->where('status', 2)
                ->get();

            // If AR Format selected is Tabular...
            if ($request->input('ar_format') == 1)
            {
                // Generate XLSX AR then Return the directory where it is saved
                $ARDirectory = (new AccomplishmentReportGenerateXLSXService())->generate($events, $studentAccomplishments);

                // Store Accomplishment Report
                $returnArray = (new AccomplishmentReportStoreService())->store($request, $ARDirectory, $organizationID);
            }

            // If AR Format selected is Design...
            elseif ($request->input('ar_format') == 2) 
            {
                // Generate PDF AR then Return the directory where it is saved
                $ARDirectory = (new AccomplishmentReportGeneratePDFService())->generate($request, $organizationID, $events, $studentAccomplishments, $organizationConstitution);

                // Store Accomplishment Report
                $returnArray = (new AccomplishmentReportStoreService())->store($request, $ARDirectory, $organizationID);
            }

            // Go to AR Page
            if ($returnArray['accomplishmentReportUUID'] !== NULL) 
                return redirect()->action(
                    [AccomplishmentReportsController::class, 'show'], ['accomplishmentReportUUID' => $returnArray['accomplishmentReportUUID'], 'newAccomplishmentReport' => true])
                    ->with($returnArray['message']);
            else
                return redirect()->action(
                    [AccomplishmentReportsController::class, 'index'])
                    ->with($returnArray['message']);
        }
        else
            abort(403);

    }

    /**
     * @param String $accomplishmentReportUUID
     * Function to send a download Response for an Accomplishment Report
     * @return Response
     */ 
    public function downloadAccomplishmentReport($accomplishmentReportUUID)
    {
        abort_if(! AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->exists(), 404);

        $accomplishmentReport = AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->first();
        $filePath = storage_path('/app/public/'. $accomplishmentReport->file);

        if ($accomplishmentReport->accomplishment_report_type_id == 1) 
            $headers = ['Content-Type: application/vnd.ms-excel'];
        else if ($accomplishmentReport->accomplishment_report_type_id == 2) 
            $headers = ['Content-Type: application/pdf'];
        
        $fileName = Str::limit(Str::slug($accomplishmentReport->title, '-'), 20, '-') .'-AccomplishmentReport.' .  pathinfo(storage_path($filePath), PATHINFO_EXTENSION);

        return response()->download($filePath, $fileName, $headers);
    }

    /**
     * @param Array $roles, String $role
     * Function to search for a role under 'role' column in $roles Array 
     * Return Array Key if found, False if not
     * @return True: Integer, False: Boolean
     */ 
    private function hasRole($roles, $role)
    {
        return array_search($role, array_column($roles, 'role'));
    }

}