<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StudentAccomplishmentRequests\{
    StudentAccomplishmentStoreRequest,
    StudentAccomplishmentApproveRequest,
};

use App\Services\StudentAccomplishmentServices\{
    StudentAccomplishmentStoreService,
    StudentAccomplishmentUpdateService,
    StudentAccomplishmentFileUpdateService,
};

use App\Services\NotificationServices\{
    StudentAccomplishmentNotificationService,
};

use App\Models\{
    TemporaryFile,
    PositionTitle,
    StudentAccomplishment,
    StudentAccomplishmentFile,
    StudentAccomplishmentDocumentType,
    User,
    Notification,
    Level,
    Organization,
    FundSource,
    Event,
};
use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\DataLogServices\DataLogService;


class StudentAccomplishmentsController extends Controller
{
    protected $viewDirectory = 'studentAccomplishments.';
    protected $temporaryFolderDirectory = '/public/uploads/tmp/';
    protected $permissionChecker;
    protected $dataLogger;


    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->permissionChecker = new PermissionCheckingService();
        $this->dataLogger = new DataLogService();
    }

    /**
     * Show Index Page, depends on Position title for Submissions/Accomplishment
     * @return View
     */ 
    public function index()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Student_Accomplishment'), 403);
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

        // If User has a User role...
        if ( ($userRoleKey = $this->hasRole($userRoles, 'User')) !== false ? true : false)
        {
            // Get Student Accomplishments
            $studentAccomplishments = StudentAccomplishment::with('reviewer')
                ->where('user_id', Auth::user()->user_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(30, ['*'], 'myAccomplishments');
                array_push($compactVariables, 'studentAccomplishments');
        }

        // If User has AR Officer Admin role...
        if( ($userRoleKey = $this->hasRole($userRoles, 'AR Officer Admin')) !== false ? true : false)
        {
            // Get the Organization from which the user is AR President Admin
            $organization_id = $userRoles[$userRoleKey]['organization_id'];

            // Query the Pending Student Accomplishments under that Organization
            $accomplishmentSubmissions = StudentAccomplishment::where('organization_id', $organization_id)
                ->where('status', 1)
                ->orderBy('created_at', 'DESC')
                ->paginate(30, ['*'], 'pendingAccomplishments');
                array_push($compactVariables, 'accomplishmentSubmissions');
        }

        return view($this->viewDirectory . 'index', compact($compactVariables));
    }

    /**
     * Function to Show Create Page for Student Accomplishment
     * @return View
     */ 
    public function create()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Student_Accomplishment'), 403);

        $filePondJS = true;
        $typeAheadJS = true;
        $loadJSWithoutDefer = true;
        $documentTypes = StudentAccomplishmentDocumentType::all();
    	return view($this->viewDirectory . 'create', 
            compact(
                'filePondJS', 
                'typeAheadJS', 
                'loadJSWithoutDefer',
                'documentTypes',
            ));
    }

    /**
     * @param Request $request
     * Function to store a Student Accomplishment
     * @return Redirect
     */ 
    public function store(StudentAccomplishmentStoreRequest $request)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Student_Accomplishment'), 403);

        $returnArray = (new StudentAccomplishmentStoreService())->store($request);
        $message = $returnArray['message'];

        $this->dataLogger->log(Auth::user()->user_id, 'User Created a Student Accomplishment.');

        if ($returnArray['accomplishmentUUID'] === NULL) 
            return redirect()->action(
                [StudentAccomplishmentsController::class, 'index'])
                ->with($message);
        else
            return redirect()->action(
                [StudentAccomplishmentsController::class, 'show'], ['accomplishmentUUID' => $returnArray['accomplishmentUUID'], 'newAccomplishment' => true])
                ->with($message);
    }

    /**
     * @param String $accomplishmentUUID, Boolean $newAccomplishment
     * Function to show a Student Accomplishment
     * @return View
     */
    public function show($accomplishmentUUID, $newAccomplishment = false)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Student_Accomplishment'), 403);
        abort_if(! StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)->exists(), 404);
        
        $accomplishment = StudentAccomplishment::with(
                'level', 
                'fundSource', 
                'event', 
                'student:user_id,first_name,middle_name,last_name,suffix,student_number,email',
                'reviewer',
                'accomplishmentFiles.documentType',)
            ->where('accomplishment_uuid', $accomplishmentUUID)
            ->first();

        return view($this->viewDirectory . 'show', 
            compact(
                'accomplishment',
                'newAccomplishment'
        ));
    }

    /**
     * @param String $accomplishmentUUID
     * Function for Documentation Officer Review for Student Accomplishment
     * @return Redirect if Status is not Pending, View for anything else
     */
    public function initialReview($accomplishmentUUID)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Review_Student_Accomplishment'), 403);
        abort_if(! StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)->exists(), 404);

        $accomplishment = StudentAccomplishment::with(
                'level', 
                'fundSource', 
                'event', 
                'student',
                'accomplishmentFiles',)
            ->where('accomplishment_uuid', $accomplishmentUUID)->first();

        // Go back to Show if Status is not Pending
        if($accomplishment->status != 1)
            return redirect()->action(
                [StudentAccomplishmentsController::class, 'show'], ['accomplishmentUUID' => $accomplishment->accomplishment_uuid,]);

        return view($this->viewDirectory . 'initialReview', compact('accomplishment'));

    }

    /**
     * @param Request $request, String $accomplishmentUUID
     * Function to get the Submission from initalReview Function
     * @return Redirect
     */ 
    public function getSubmissionDecision(Request $request, $accomplishmentUUID)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Review_Student_Accomplishment'), 403);
        abort_if(! StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)->exists(), 404);

        $accomplishment = StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)
            ->first();

        // Validate that Either buttons are clicked
        $request->validate([
            'decline' => 'required_without:success',
            'success' => 'required_without:decline',
        ]);

        // If Submission is declined, Update Submission then redirect to Index
        if(request()->has('decline'))
        {
            $data = $request->validate([
                'remarks' => 'required|string',]);
            $message = $this->declineSubmission($accomplishment, $data['remarks']);
            return redirect()->action(
                [StudentAccomplishmentsController::class, 'index'])
                ->with($message);
        }

        // If Submission is approved, Redirect to Final Review Function
        else if(request()->has('success'))
            return redirect()->action(
                [StudentAccomplishmentsController::class, 'finalReview'], ['accomplishmentUUID' => $accomplishmentUUID]
            );
    }

    /**
     * @param String $accomplishmentUUID
     * Function to show the Final Review Page including the details that only the Documentation Officer can fill up
     * @return View if status is pending, Redirect if not
     */ 
    public function finalReview($accomplishmentUUID)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Review_Student_Accomplishment'), 403);
        abort_if(! StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)->exists(), 404);

        $accomplishment = StudentAccomplishment::with([ 
            'student',
            'accomplishmentFiles.documentType' => function($query){
                $query->orderBy('updated_at', 'DESC')->get();}])
            ->where('accomplishment_uuid', $accomplishmentUUID)->first();

        // Go back to show if Status is not Pending
        if($accomplishment->status != 1)
            return redirect()->action(
                [StudentAccomplishmentsController::class, 'show'], ['accomplishmentUUID' => $accomplishment->accomplishment_uuid,]);
        
        // Get Additional Data for Student Accomplishment
        $relatedEvents = Event::search($accomplishment->title)
            ->select('title',
                DB::raw('DATE_FORMAT(start_date, "%M %Y") as start_date'),
                'slug',
                'accomplished_event_id')
            ->orderby('start_date', 'DESC')
            ->limit(5)
            ->get();
        $studentAccomplishmentDocumentTypes = StudentAccomplishmentDocumentType::all();
        $levels = Level::all();
        $fundSources = FundSource::all();

        return view($this->viewDirectory . 'finalReview', 
            compact(
                'accomplishment', 
                'studentAccomplishmentDocumentTypes', 
                'levels', 
                'fundSources', 
                'relatedEvents'));
    }

    /**
     * @param Collection $accomplishment, String $remarks
     * Function to Decline the Student Accomplishment Submission
     * @return String
     */ 
    public function declineSubmission(StudentAccomplishment $accomplishment, $remarks)
    {
        $message = (new StudentAccomplishmentUpdateService())->decline($accomplishment, $remarks);

        $this->dataLogger->log(Auth::user()->user_id, 'User Declined a Student Accomplishment.');

        return $message;
    }

    /**
     * @param Request $request, String $accomplishmentUUID
     * Function to Decline the Student Accomplishment Submission
     * @return Redirect
     */ 
    public function approveSubmission(StudentAccomplishmentApproveRequest $request, $accomplishmentUUID)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Review_Student_Accomplishment'), 403);
        abort_if(! StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)->exists(), 404);

        // Get Accomplishment Data
        $accomplishment = StudentAccomplishment::withCount('accomplishmentFiles')
            ->where('accomplishment_uuid', $accomplishmentUUID)->first();

        // If Documentation Officer declines that submission...
        if($request->has('decline'))
        {
            $message = $this->declineSubmission($accomplishment, $request->input('remarks'));
            return redirect()->action(
                [StudentAccomplishmentsController::class, 'index'])
                ->with($message);
        }

        // If Documentation Officer accepts that submission...
        else if($request->has('success'))
        {
            $message = (new StudentAccomplishmentUpdateService())->approve($accomplishment, $request);

            $this->dataLogger->log(Auth::user()->user_id, 'User Approved a Student Accomplishment.');

            return redirect()->action(
                [StudentAccomplishmentsController::class, 'index'])
                ->with($message);
        }

    }

    /**
     * @param Request $request
     * Function for FilePond JS File Upload 
     * https://pqina.nl/filepond/
     * @return text/plain JSON Response
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('evidence1'))
        {
            $file = $request->file('evidence1');
            $filename = uniqid() . '-' . now()->timestamp . '.' .$file->extension();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs($this->temporaryFolderDirectory . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);
            return $folder;
        }
        else if ($request->hasFile('evidence2'))
        {
            $file = $request->file('evidence2');
            $filename = uniqid() . '-' . now()->timestamp . '.' .$file->extension();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs($this->temporaryFolderDirectory . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);
            return $folder;
        }
        else if ($request->hasFile('evidence3'))
        {
            $file = $request->file('evidence3');
            $filename = uniqid() . '-' . now()->timestamp . '.' .$file->extension();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs($this->temporaryFolderDirectory . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);
            return $folder;
        }
        return 'not uploaded';
    }

    /**
     * @param Request $request
     * Function for FilePond JS Reverting File Upload 
     * https://pqina.nl/filepond/docs/api/server/#revert
     * @return empty JSON Response
     */
    public function undoUpload(Request $request)
    {
         if ($request->getContent())
         {
            $folder = $request->getContent();
            TemporaryFile::where('folder', $folder)->delete();
            // first delete contents of the directory, but preserve the directory itself
            Storage::deleteDirectory($this->temporaryFolderDirectory . $folder, true);
            // sleep 0.5 second because of race condition with HD
            sleep(0.5);
            // actually delete the folder itself
            Storage::deleteDirectory($this->temporaryFolderDirectory . $folder);
            return 'file deleted';
         }
         return 'file not deleted';
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
