<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use App\Models\TemporaryFile;
use App\Models\StudentAccomplishment;
use App\Models\StudentAccomplishmentFile;
// Student Accomplishment Status
// 0 - PENDING | 1 - APPROVED | 2 - DISAPPROVED
class StudentAccomplishmentsController extends Controller
{
    public function index()
    {
        if (Auth::check() && $user_id = Auth::user()->user_id) 
        {
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
            return view('studentaccomplishments.index', compact('approvedAccomplishments', 'pendingAccomplishments', 'disapprovedAccomplishments'));
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
            'title' => 'required',
            'description' => 'required',
            'evidence1' => 'required|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/',
            'evidence2' => 'nullable|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/',
            'evidence3' => 'nullable|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/',
        ]);

        $accomplishment_uuid = StudentAccomplishment::create([
            'user_id' => Auth::user()->user_id,
            'organization_id' => Auth::user()->course->organization_id,
            'accomplishment_uuid' => Str::uuid(),
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => 0,
            'remarks' => 'PENDING',
        ])->accomplishment_uuid;

        if ($accomplishment_uuid) 
        {
            $temp_path = '/public/uploads/tmp/';
            $final_path = '/public/uploads/student_accomplishments/';
            $db_path = '/uploads/student_accomplishments/';
            $accomplishment_id = StudentAccomplishment::where('accomplishment_uuid', $accomplishment_uuid)->value('student_accomplishment_id');

            if($data['evidence1'] ?? false)
            {
                $file = TemporaryFile::where('folder', $data['evidence1'])->value('filename');

                Storage::move($temp_path . $data['evidence1'] . '/' . $file, $final_path . $file);
                Storage::deleteDirectory($temp_path . $data['evidence1'], true);
                sleep(0.5);
                Storage::deleteDirectory($temp_path . $data['evidence1']);
                StudentAccomplishmentFile::create([
                    'student_accomplishment_id' => $accomplishment_id,
                    'file' =>  $db_path . $file, 
                ]);
            }

            if($data['evidence2'] ?? false)
            {
                $file = TemporaryFile::where('folder', $data['evidence2'])->value('filename');

                Storage::move($temp_path . $data['evidence2'] . '/' . $file, $final_path . $file);
                Storage::deleteDirectory($temp_path . $data['evidence2'], true);
                sleep(0.5);
                Storage::deleteDirectory($temp_path . $data['evidence2']);
                StudentAccomplishmentFile::create([
                    'student_accomplishment_id' => $accomplishment_id,
                    'file' => $db_path . $file, 
                ]);
            }

            if($data['evidence3'] ?? false)
            {
                $file = TemporaryFile::where('folder', $data['evidence3'])->value('filename');

                Storage::move($temp_path . $data['evidence3'] . '/' . $file, $final_path . $file);
                Storage::deleteDirectory($temp_path . $data['evidence3'], true);
                sleep(0.5);
                Storage::deleteDirectory($temp_path . $data['evidence3']);
                StudentAccomplishmentFile::create([
                    'student_accomplishment_id' => $accomplishment_id,
                    'file' => $db_path . $file, 
                ]);
            }
            return redirect()->route('student_accomplishment.show',['accomplishment_uuid' => $accomplishment_uuid,]);
        }
        else
            abort(404);
    }
    public function show($accomplishment_uuid)
    {
        if($accomplishment = StudentAccomplishment::where('accomplishment_uuid', $accomplishment_uuid)
            ->first())
        {
            $accomplishmentFiles = StudentAccomplishmentFile::where('student_accomplishment_id', $accomplishment->student_accomplishment_id)->pluck('file');
            return view('studentaccomplishments.show', compact('accomplishment', 'accomplishmentFiles'));
        }
        else
            abort(404);
    }
    // FilePond
    // Upload Functions
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
