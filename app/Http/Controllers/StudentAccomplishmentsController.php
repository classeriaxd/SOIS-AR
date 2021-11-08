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

    /**
     * Show Index Page, depends on Position title for Submissions/Accomplishment
     */ 
    public function index()
    {
        if (Auth::check() && $user_id = Auth::user()->user_id) 
        {
            $userPositionTitles = Auth::user()->positionTitles;
            // Array because of Laravel Collection, maybe revise this sometime?
            $orgCurrentPositionArray = $userPositionTitles->where('organization_id', Auth::user()->course->organization_id)->pluck('position_title');
            $orgCurrentPosition = $orgCurrentPositionArray[0];
            $document_officers = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];

            // Organization Member
            if ($orgCurrentPosition == 'Member')
            {
                $approvedAccomplishments = StudentAccomplishment::where('status', 2)
                    ->where('user_id', $user_id)
                    ->select('accomplishment_uuid','title')
                    ->get();
                $pendingAccomplishments = StudentAccomplishment::where('status', 1)
                    ->where('user_id', $user_id)
                    ->select('accomplishment_uuid','title')
                    ->get();
                $disapprovedAccomplishments = StudentAccomplishment::where('status', 3)
                    ->where('user_id', $user_id)
                    ->select('accomplishment_uuid','title')
                    ->get();
                return view('studentaccomplishments.index', compact('approvedAccomplishments', 'pendingAccomplishments', 'disapprovedAccomplishments'));
            }
            // Documentation Officers
            else if(in_array($orgCurrentPosition, $document_officers))
            {
                $accomplishmentSubmissions = DB::table('student_accomplishments')
                    ->join('users','users.user_id','=','student_accomplishments.user_id')
                    ->where('student_accomplishments.organization_id', Auth::user()->course->organization_id)
                    ->where('student_accomplishments.status', 1)
                    ->select(
                        DB::raw('CONCAT(users.last_name, ", ", users.first_name, " ", SUBSTRING(users.middle_name,1,1), ".") as student_name'), 
                        'student_accomplishments.accomplishment_uuid as accomplishment_uuid', 
                        'student_accomplishments.title as title')
                    ->paginate(10);
                return view('studentaccomplishments.index', compact('accomplishmentSubmissions',));
            }
            else
                abort(404);
        }
        else
            abort(404);
    }
    public function create()
    {
        $filePondJS = true;
        $typeAheadJS = true;
        $loadJSWithoutDefer = true;
    	return view('studentaccomplishments.create', compact('filePondJS', 'typeAheadJS', 'loadJSWithoutDefer'));
    }
    public function store(StudentAccomplishmentStoreRequest $request)
    {
        $studentAccomplishmentStoreService = new StudentAccomplishmentStoreService();
        $accomplishmentUUID = $studentAccomplishmentStoreService->store($request);
        $studentAccomplishmentStoreService->storeAccomplishmentFiles($request, $accomplishmentUUID);
        
        $studentAccomplishmentNotificationService = new StudentAccomplishmentNotificationService();
        $sender = Auth::user()->last_name . ', '. Auth::user()->first_name . ' ' . Auth::user()->middle_name;
        $studentAccomplishmentNotificationService->sendNotificationToOfficers($sender, Auth::user()->course->organization_id, $accomplishmentUUID);

        return redirect()->route('studentAccomplishment.show',['accomplishmentUUID' => $accomplishmentUUID, 'newAccomplishment' => true]);
    }
    public function show($accomplishmentUUID, $newAccomplishment = false)
    {
        $accomplishment = StudentAccomplishment::with(['level', 
            'fundSource', 
            'event', 
            'student',
            'accomplishmentFiles' => function($query){
                $query->orderBy('updated_at', 'DESC')->get();
            }])
        ->where('accomplishment_uuid', $accomplishmentUUID)->first();
        
        if($accomplishment)
            return view('studentaccomplishments.show', compact('accomplishment','newAccomplishment'));
        else
            abort(404);
    }

    /*
     * Documentation Officer Review
     */
    public function initialReview($accomplishmentUUID)
    {
        /*
         * Show Initial Review Page
         */
        $accomplishment = StudentAccomplishment::with(['level', 
            'fundSource', 
            'event', 
            'student',
            'accomplishmentFiles' => function($query){
                $query->orderBy('updated_at', 'DESC')->get();
            }])
        ->where('accomplishment_uuid', $accomplishmentUUID)->first();
        
        if($accomplishment)
            if($accomplishment->status != 1)
                return redirect()->route('studentAccomplishment.show',['accomplishmentUUID' => $accomplishment->accomplishment_uuid,]);
            else
                return view('studentaccomplishments.initialReview', compact('accomplishment'));
        else
            abort(404);
    }

    public function getSubmissionDecision($accomplishmentUUID)
    {
        /*
         * Get POST Request from initialReview
         */
        if($accomplishment = StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)
            ->first())
        {
            if(request()->has('decline'))
            {
                $data = request()->validate([
                    'remarks' => 'required|string',
                ]);
                $this->declineSubmission($accomplishment, $data['remarks']);
                return redirect()->route('studentAccomplishment.index');
            }
            else if(request()->has('success'))
            {
                return redirect()->action(
                    [StudentAccomplishmentsController::class, 'finalReview'], ['accomplishmentUUID' => $accomplishmentUUID]
                );
            }
        }
        else
            abort(404);     
    }
    public function finalReview($accomplishmentUUID)
    {
        /*
         * Show Final Review Page
         */
        $accomplishment = StudentAccomplishment::with([ 
            'student',
            'accomplishmentFiles' => function($query){
                $query->orderBy('updated_at', 'DESC')->get();
            }])
        ->where('accomplishment_uuid', $accomplishmentUUID)->first();
        
        if($accomplishment)
        {
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
                
                $levels = Level::all();
                $fundSources = FundSource::all();
                $loadJSWithoutDefer = true;
                return view('studentaccomplishments.finalReview', compact('accomplishment', 'levels', 'fundSources', 'relatedEvents', 'loadJSWithoutDefer'));
            }
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
        /*
         * Get POST Request from finalReview
         */
        $accomplishment = StudentAccomplishment::withCount('accomplishmentFiles')
            ->where('accomplishment_uuid', $accomplishmentUUID)->first();
        
        if(!($accomplishment))
            abort(404);

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
            return redirect()->route('studentAccomplishment.index');
        }

    }

    /* FilePond JS
    /* Upload Functions
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('evidence1'))
        {
            $file = $request->file('evidence1');
            $filename = uniqid() . '-' . now()->timestamp . '.' .$file->extension();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('/public/uploads/tmp/' . $folder, $filename);

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
            $file->storeAs('/public/uploads/tmp/' . $folder, $filename);

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
            $file->storeAs('/public/uploads/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);
            return $folder;
        }
        return 'not uploaded';
    }
    public function undoUpload(Request $request)
    {
         if ($request->getContent())
         {
            $folder = $request->getContent();
            TemporaryFile::where('folder', $folder)->delete();
            // first delete contents of the directory, but preserve the directory itself
            Storage::deleteDirectory('/public/uploads/tmp/' . $folder, true);
            // sleep 0.5 second because of race condition with HD
            sleep(0.5);
            // actually delete the folder itself
            Storage::deleteDirectory('/public/uploads/tmp/' . $folder);
            return 'file deleted';
         }
         return 'file not deleted';
    }
}
