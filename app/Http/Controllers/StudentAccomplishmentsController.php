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
/**
 * Handles all Student Accomplishment Requests
 */ 

class StudentAccomplishmentsController extends Controller
{
    // Student Accomplishment Status
    // 1 - PENDING | 2 - APPROVED | 3 - DISAPPROVED

    protected $viewDirectory = 'studentAccomplishments.';
    protected $temporaryFolderDirectory = '/public/uploads/tmp/';
    /**
     * Show Index Page, depends on Position title for Submissions/Accomplishment
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

        // If User has a User role...
        if ( ($userRoleKey = $this->hasRole($userRoles, 'User')) !== false ? true : false)
        {
            // Get Student Accomplishments
            $studentAccomplishments = StudentAccomplishment::with('reviewer')
                ->where('user_id', Auth::user()->user_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(30, ['*'], 'myAccomplishments');
                array_push($compactVariables, 'studentAccomplishments');
            //dd($studentAccomplishments);
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
        $studentAccomplishmentStoreService = new StudentAccomplishmentStoreService();
        $accomplishmentUUID = $studentAccomplishmentStoreService->store($request);
        $studentAccomplishmentStoreService->storeAccomplishmentFiles($request, $accomplishmentUUID);
        
        $studentAccomplishmentNotificationService = new StudentAccomplishmentNotificationService();
        $studentAccomplishmentNotificationService->sendNotificationToOfficers(Auth::user()->full_name, Auth::user()->course->organization->organization_id, $accomplishmentUUID);

        return redirect()->action(
                [StudentAccomplishmentsController::class, 'show'], ['accomplishmentUUID' => $accomplishmentUUID])
                ->with(['newAccomplishment' => true]);
    }

    /**
     * @param String $accomplishmentUUID, Boolean $newAccomplishment
     * Function to show a Student Accomplishment
     * @return View
     */
    public function show($accomplishmentUUID, $newAccomplishment = false)
    {
        abort_if(! StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)->exists(), 404);

        $accomplishment = StudentAccomplishment::with(
                'level', 
                'fundSource', 
                'event', 
                'student',
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
        abort_if(! StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)->exists(), 404);

        $accomplishment = StudentAccomplishment::with(['level', 
            'fundSource', 
            'event', 
            'student',
            'accomplishmentFiles' => function($query){
                $query->orderBy('updated_at', 'DESC')->get();
            }])
        ->where('accomplishment_uuid', $accomplishmentUUID)->first();

        // Go back to Show if Status is not Pending
        if($accomplishment->status != 1)
        {
            return redirect()->action(
                [StudentAccomplishmentsController::class, 'show'], ['accomplishmentUUID' => $accomplishment->accomplishment_uuid,]);
        }

        return view($this->viewDirectory . 'initialReview', compact('accomplishment'));

    }

    public function getSubmissionDecision($accomplishmentUUID)
    {
        abort_if(! StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)->exists(), 404);
        /*
         * Get POST Request from initialReview
         */
        $accomplishment = StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)
            ->first();

        if(request()->has('decline'))
        {
            $data = request()->validate([
                'remarks' => 'required|string',
            ]);

            $this->declineSubmission($accomplishment, $data['remarks']);

            return redirect()->action(
                [StudentAccomplishmentsController::class, 'index']
            );
        }

        else if(request()->has('success'))
            return redirect()->action(
                [StudentAccomplishmentsController::class, 'finalReview'], ['accomplishmentUUID' => $accomplishmentUUID]
            );
    }

    public function finalReview($accomplishmentUUID)
    {
        abort_if(! StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)->exists(), 404);
        /*
         * Show Final Review Page
         */
        $accomplishment = StudentAccomplishment::with([ 
            'student',
            'accomplishmentFiles.documentType' => function($query){
                $query->orderBy('updated_at', 'DESC')->get();}])
            ->where('accomplishment_uuid', $accomplishmentUUID)->first();

        if($accomplishment->status != 1)

            return redirect()->route('studentAccomplishment.show',['accomplishmentUUID' => $accomplishment->accomplishment_uuid,]);
        else
        {
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
        
            
    }
    public function declineSubmission(StudentAccomplishment $accomplishment, $remarks)
    {
        /*
         * Decline a Student Accomplishment Submission
         * Get action redirect from getSubmissionDecision and approveDecision
         */
        
        $studentAccomplishmentUpdateService = new StudentAccomplishmentUpdateService();
        $studentAccomplishmentUpdateService->decline($accomplishment, $remarks);

        $studentAccomplishmentNotificationService = new StudentAccomplishmentNotificationService();
        $studentAccomplishmentNotificationService->sendNotificationToMember($accomplishment->user_id, $accomplishment->accomplishment_uuid, 'declined');

    }
    public function approveSubmission(StudentAccomplishmentApproveRequest $request, $accomplishmentUUID)
    {
        dd($request);
        abort_if(! StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)->exists(), 404);
        /*
         * Get POST Request from finalReview
         */
        $accomplishment = StudentAccomplishment::withCount('accomplishmentFiles')
            ->where('accomplishment_uuid', $accomplishmentUUID)->first();

        if($request->has('decline'))
        {
            $this->declineSubmission($accomplishment, $request->input('remarks'));
            return redirect()->route('studentAccomplishment.index');
        }
        else if($request->has('success'))
        {
            $studentAccomplishmentFileUpdateService = new StudentAccomplishmentFileUpdateService();
            $studentAccomplishmentFileUpdateService->update($accomplishment, $request);
            
            $studentAccomplishmentUpdateService = new StudentAccomplishmentUpdateService();
            $studentAccomplishmentUpdateService->approve($accomplishment, $request);

            $studentAccomplishmentNotificationService = new StudentAccomplishmentNotificationService();
            $studentAccomplishmentNotificationService->sendNotificationToMember($accomplishment->user_id, $accomplishment->accomplishment_uuid, 'approved');

            return redirect()->action(
                [StudentAccomplishmentsController::class, 'index']);
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
