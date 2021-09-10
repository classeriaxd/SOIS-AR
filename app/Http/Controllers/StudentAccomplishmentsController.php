<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\TemporaryFile;
use App\Models\PositionTitle;
use App\Models\StudentAccomplishment;
use App\Models\StudentAccomplishmentFile;
use App\Models\User;
use App\Models\Notification;
// Student Accomplishment Status
// 0 - PENDING | 1 - APPROVED | 2 - DISAPPROVED
class StudentAccomplishmentsController extends Controller
{
    public function index()
    {
        if (Auth::check() && $user_id = Auth::user()->user_id) 
        {
            $userPositionTitles = Auth::user()->positionTitles;
            // Array because of Laravel Collection, maybe revise this sometime?
            $orgCurrentPositionArray = $userPositionTitles->where('organization_id', Auth::user()->course->organization_id)->pluck('position_title');
            $orgCurrentPosition = $orgCurrentPositionArray[0];
            $document_officers = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];
            $approvedAccomplishments = StudentAccomplishment::where('status', 1)
                ->where('user_id', $user_id)
                ->select('accomplishment_uuid','title')
                ->get();
            $pendingAccomplishments = StudentAccomplishment::where('status', 0)
                ->where('user_id', $user_id)
                ->select('accomplishment_uuid','title')
                ->get();
            $disapprovedAccomplishments = StudentAccomplishment::where('status', 2)
                ->where('user_id', $user_id)
                ->select('accomplishment_uuid','title')
                ->get();

            // Organization Member
            if ($orgCurrentPosition == 'Member')
            {
                return view('studentaccomplishments.index', compact('approvedAccomplishments', 'pendingAccomplishments', 'disapprovedAccomplishments'));
            }
            // Organization President
            else if($orgCurrentPosition == 'President') {}
            // Other Documentation Officers
            else if(in_array($orgCurrentPosition, $document_officers))
            {
                $accomplishmentSubmissions = DB::table('student_accomplishments')
                    ->join('users','users.user_id','=','student_accomplishments.user_id')
                    ->where('student_accomplishments.organization_id', Auth::user()->course->organization_id)
                    ->where('student_accomplishments.status', 0)
                    ->select(
                        DB::raw('CONCAT(users.last_name, ", ", users.first_name, " ", SUBSTRING(users.middle_name,1,1), ".") as student_name'), 
                        'student_accomplishments.accomplishment_uuid as accomplishment_uuid', 
                        'student_accomplishments.title as title')
                    ->get();
                return view('studentaccomplishments.index', compact('approvedAccomplishments', 'pendingAccomplishments', 'disapprovedAccomplishments', 'accomplishmentSubmissions',));
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
    	return view('studentaccomplishments.create', compact('filePondJS',));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'date_awarded' => 'required|date|before_or_equal:now|after:1992-01-01',
            'evidence1' => 'required|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/',
            'evidence2' => 'nullable|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/',
            'evidence3' => 'nullable|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/',
            'caption1' => 'nullable|string',
            'caption2' => 'nullable|string',
            'caption3' => 'nullable|string',
        ]);

        $accomplishment_uuid = StudentAccomplishment::create([
            'user_id' => Auth::user()->user_id,
            'organization_id' => Auth::user()->course->organization_id,
            'accomplishment_uuid' => Str::uuid(),
            'title' => $data['title'],
            'description' => $data['description'],
            'date_awarded' => $data['date_awarded'],
        ])->accomplishment_uuid;

        if ($accomplishment_uuid) 
        {
            $temp_path = '/public/uploads/tmp/';
            $final_path = '/public/uploads/student_accomplishments/';
            $db_path = '/uploads/student_accomplishments/';
            $accomplishment_id = StudentAccomplishment::where('accomplishment_uuid', $accomplishment_uuid)->value('student_accomplishment_id');
            
            if($data['evidence1'] ?? false)
            {
                $caption = ($data['caption1'])?$data['caption1']:NULL;
                $file = TemporaryFile::where('folder', $data['evidence1'])->value('filename');

                Storage::move($temp_path . $data['evidence1'] . '/' . $file, $final_path . $file);
                Storage::deleteDirectory($temp_path . $data['evidence1'], true);
                sleep(0.5);
                Storage::deleteDirectory($temp_path . $data['evidence1']);
                StudentAccomplishmentFile::create([
                    'student_accomplishment_id' => $accomplishment_id,
                    'file' =>  $db_path . $file, 
                    'caption' => $caption,
                ]);
            }

            if($data['evidence2'] ?? false)
            {
                $caption = ($data['caption2'])?$data['caption2']:NULL;
                $file = TemporaryFile::where('folder', $data['evidence2'])->value('filename');

                Storage::move($temp_path . $data['evidence2'] . '/' . $file, $final_path . $file);
                Storage::deleteDirectory($temp_path . $data['evidence2'], true);
                sleep(0.5);
                Storage::deleteDirectory($temp_path . $data['evidence2']);
                StudentAccomplishmentFile::create([
                    'student_accomplishment_id' => $accomplishment_id,
                    'file' => $db_path . $file,
                    'caption' => $caption, 
                ]);
            }

            if($data['evidence3'] ?? false)
            {
                $caption = ($data['caption3'])?$data['caption3']:NULL;
                $file = TemporaryFile::where('folder', $data['evidence3'])->value('filename');

                Storage::move($temp_path . $data['evidence3'] . '/' . $file, $final_path . $file);
                Storage::deleteDirectory($temp_path . $data['evidence3'], true);
                sleep(0.5);
                Storage::deleteDirectory($temp_path . $data['evidence3']);
                StudentAccomplishmentFile::create([
                    'student_accomplishment_id' => $accomplishment_id,
                    'file' => $db_path . $file, 
                    'caption' => $caption,
                ]);
            }
            $sender = User::where('user_id', Auth::user()->user_id)->value('first_name');
            $this->sendNotificationToOfficers($sender, Auth::user()->course->organization_id, $accomplishment_uuid);

            return redirect()->route('student_accomplishment.show',['accomplishment_uuid' => $accomplishment_uuid, 'newAccomplishment' => true]);
        }
        else
            abort(404);
    }
    public function show($accomplishment_uuid, $newAccomplishment = false)
    {
        if($accomplishment = StudentAccomplishment::where('accomplishment_uuid', $accomplishment_uuid)
            ->first())
        {
            $accomplishmentFiles = StudentAccomplishmentFile::where('student_accomplishment_id', $accomplishment->student_accomplishment_id)->select('file', 'caption')
                ->orderBy('updated_at', 'DESC')
                ->get();
            if ($newAccomplishment)
                return view('studentaccomplishments.show', compact('accomplishment', 'accomplishmentFiles', 'newAccomplishment'));
            else
                return view('studentaccomplishments.show', compact('accomplishment', 'accomplishmentFiles'));
        }
        else
            abort(404);
    }

    /*
     * Documentation Officer Review
     */
    public function initialReview($accomplishment_uuid)
    {
        /*
         * Show Initial Review Page
         */
        if($accomplishment = StudentAccomplishment::where('accomplishment_uuid', $accomplishment_uuid)
            ->first())
        {
            if($accomplishment->status == 0)
            {
                $accomplishmentFiles = StudentAccomplishmentFile::where('student_accomplishment_id', $accomplishment->student_accomplishment_id)->select('file', 'caption')
                    ->orderBy('updated_at', 'DESC')
                    ->get();
                $student = User::where('user_id', $accomplishment->user_id)
                    ->select(DB::raw('CONCAT(last_name, ", ", first_name, " ", SUBSTRING(middle_name,1,1), ".") as name'), 'email', 'student_number')
                    ->first();
                return view('studentaccomplishments.initialReview', compact('accomplishment', 'accomplishmentFiles', 'student'));
            }
            else
                return redirect()->route('student_accomplishment.show',['accomplishment_uuid' => $accomplishment_uuid,]);

        }
        else
            abort(404);
    }

    public function getSubmissionDecision($accomplishment_uuid)
    {
        /*
         * Get POST Request from initialReview
         */
        if($accomplishment = StudentAccomplishment::where('accomplishment_uuid', $accomplishment_uuid)
            ->first())
        {
            if(request()->has('decline'))
            {
                $data = request()->validate([
                    'remarks' => 'required|string',
                ]);
                $this->declineSubmission($accomplishment, $data['remarks']);
                return redirect()->route('student_accomplishment.index');
            }
            else if(request()->has('success'))
            {
                return redirect()->action(
                    [StudentAccomplishmentsController::class, 'finalReview'], ['accomplishment_uuid' => $accomplishment_uuid]
                );
            }
                
        }
        else
            abort(404);     
    }
    public function finalReview($accomplishment_uuid)
    {
        /*
         * Show Final Review Page
         */
        if($accomplishment = StudentAccomplishment::where('accomplishment_uuid', $accomplishment_uuid)
            ->first())
        {
            if($accomplishment->status == 0)
            {
                $accomplishmentFiles = StudentAccomplishmentFile::where('student_accomplishment_id', $accomplishment->student_accomplishment_id)->select('file', 'caption')
                    ->orderBy('updated_at', 'DESC')
                    ->get();
                $student = User::where('user_id', $accomplishment->user_id)
                    ->select(DB::raw('CONCAT(last_name, ", ", first_name, " ", SUBSTRING(middle_name,1,1), ".") as name'), 'email', 'student_number')
                    ->first();
                return view('studentaccomplishments.finalReview', compact('accomplishment', 'accomplishmentFiles', 'student'));
            }
            else
                return redirect()->route('student_accomplishment.show',['accomplishment_uuid' => $accomplishment_uuid,]);

        }
        else
            abort(404);
    }
    public function declineSubmission(StudentAccomplishment $accomplishment, $remarks)
    {
        /*
         * Decline a Student Accomplishment Submission
         * Get action redirect from getSubmissionDecision and approveDecision
         */
        $accomplishment_data = [
            'remarks' => $remarks,
            'status' => 2,
            'reviewed_by' => Auth::user()->user_id,
        ];
        $accomplishment->update($accomplishment_data);
        $this->sendNotificationToMember($accomplishment->user_id, 'declined', $accomplishment->accomplishment_uuid);

    }
    public function approveSubmission($accomplishment_uuid)
    {
        /*
         * Get POST Request from finalReview
         */
        if($accomplishment = StudentAccomplishment::where('accomplishment_uuid', $accomplishment_uuid)
            ->first())
        {
            if ($accomplishment->status != 0)
            {
                return redirect()->route('student_accomplishment.show',['accomplishment_uuid' => $accomplishment_uuid,]);
            }

            if(request()->has('decline'))
            {
                $data = request()->validate([
                    'remarks' => 'required|string',
                ]);
                $this->declineSubmission($accomplishment, $data['remarks']);
                return redirect()->route('student_accomplishment.index');
            }
            else if(request()->has('success'))
            {
                $accomplishmentCount = $accomplishment->accomplishmentFiles->count();
                $accomplishmentFiles = StudentAccomplishmentFile::where('student_accomplishment_id', $accomplishment->student_accomplishment_id)->select('student_accomplishment_file_id')
                    ->orderBy('updated_at', 'DESC')
                    ->get();
                if($accomplishmentCount == 1)
                {
                    $data = request()->validate([
                        'remarks' => 'required|string',
                        'title' => 'required|string',
                        'description' => 'required|string',
                        'date_awarded' => 'required|date|before_or_equal:now|after:1992-01-01',
                        'evidence1' => 'required',
                    ]);
                }
                else if ($accomplishmentCount == 2)
                {
                    $data = request()->validate([
                        'remarks' => 'required|string',
                        'title' => 'required|string',
                        'description' => 'required|string',
                        'date_awarded' => 'required|date|before_or_equal:now|after:1992-01-01',
                        'evidence1' => 'required_without:evidence2',
                        'evidence2' => 'required_without:evidence1',
                    ]);
                    if (!(isset($data['evidence1'])))
                    {
                        foreach ($accomplishmentFiles as $file)
                        {
                            $file->delete();
                            break;
                        }
                    }
                    $accomplishmentFiles = $accomplishmentFiles->skip(1);
                    if (!(isset($data['evidence2'])))
                    {
                        foreach ($accomplishmentFiles as $file)
                        {
                            $file->delete();
                            break;
                        }
                    }
                }
                else if ($accomplishmentCount == 3)
                {
                    $data = request()->validate([
                        'remarks' => 'required|string',
                        'title' => 'required|string',
                        'description' => 'required|string',
                        'date_awarded' => 'required|date|before_or_equal:now|after:1992-01-01',
                        'evidence1' => 'required_without_all:evidence2,evidence3',
                        'evidence2' => 'required_without_all:evidence1,evidence3',
                        'evidence3' => 'required_without_all:evidence1,evidence2',
                    ]);
                    if (!(isset($data['evidence1'])))
                    {
                        foreach ($accomplishmentFiles as $file)
                        {
                            $file->delete();
                            break;
                        }
                    }
                    $accomplishmentFiles = $accomplishmentFiles->skip(1);
                    if (!(isset($data['evidence2'])))
                    {
                        foreach ($accomplishmentFiles as $file)
                        {
                            $file->delete();
                            break;
                        }
                    }
                    $accomplishmentFiles = $accomplishmentFiles->skip(1);
                    if (!(isset($data['evidence3'])))
                    {
                        foreach ($accomplishmentFiles as $file)
                        {
                            $file->delete();
                            break;
                        }
                    }
                }

                $accomplishment_data = [
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'date_awarded' => $data['date_awarded'],
                    'remarks' => $data['remarks'],
                    'status' => 1,
                    'reviewed_by' => Auth::user()->user_id,
                ];
                $accomplishment->update($accomplishment_data);
                $this->sendNotificationToMember($accomplishment->user_id, 'approved', $accomplishment->accomplishment_uuid);
                return redirect()->route('student_accomplishment.index');
            }
        }
        else
            abort(404);
    }
    /*
     * Send Notification to Officers
     */
    public function sendNotificationToOfficers($sender, $reciever_organization_id, $accomplishment_uuid)
    {
        $valid_positions = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];
        $recieving_positions = PositionTitle::where('organization_id', $reciever_organization_id)
            ->whereIn('position_title', $valid_positions)
            ->pluck('position_title_id');
        $recieving_users = array();
        foreach($recieving_positions as $reciever)
        {
            $recieving_user_id = DB::table('users_position_titles')->where('position_title_position_title_id', $reciever)->value('user_user_id');
            if ($recieving_user_id != NULL) 
                array_push($recieving_users,$recieving_user_id);
        }

        if (count($recieving_users) > 0)
        {
            foreach($recieving_users as $reciever)
            {
                if ($reciever != NULL)
                {
                    $notification_title = "New Student Accomplishment Submission";
                    $notification_description = 'A student named ' . $sender . ' sent an Accomplishment Submission. Please review it!';
                    $notification_link = route('student_accomplishment.review',['accomplishment_uuid' => $accomplishment_uuid,]);
                    Notification::create([
                        'user_id' => $reciever,
                        'title' => $notification_title,
                        'description' => $notification_description,
                        'link' => $notification_link,
                    ]);
                }
            }
        }
    }
    /*
     * Send Notification to Member
     */
    public function sendNotificationToMember($reciever_id, $status, $accomplishment_uuid)
    {
        if ($reciever_id != NULL)
        {
            if ($status == 'approved')
            {
                $notification_title = "Submission Approved";
                $notification_description = 'Your Accomplishment Submission has been approved. Cheers!';
                $notification_link = route('student_accomplishment.show',['accomplishment_uuid' => $accomplishment_uuid,]);
                Notification::create([
                    'user_id' => $reciever_id,
                    'title' => $notification_title,
                    'description' => $notification_description,
                    'link' => $notification_link,
                ]);
            }
            else if ($status == 'declined')
            {
                $notification_title = "Submission Declined";
                $notification_description = 'Your Accomplishment Submission has been declined.';
                $notification_link = route('student_accomplishment.show',['accomplishment_uuid' => $accomplishment_uuid,]);
                Notification::create([
                    'user_id' => $reciever_id,
                    'title' => $notification_title,
                    'description' => $notification_description,
                    'link' => $notification_link,
                ]);
            }
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
