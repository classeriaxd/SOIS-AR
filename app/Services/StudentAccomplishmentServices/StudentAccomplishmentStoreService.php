<?php

namespace App\Services\StudentAccomplishmentServices;

use App\Models\StudentAccomplishment;
use App\Models\StudentAccomplishmentFile;
use App\Models\TemporaryFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class StudentAccomplishmentStoreService
{
    /**
     * Service to Store a Student Accomplishment.
     * Returns Accomplishment UUID on success.
     *
     * @return String
     */
    public function store($request)
    {
        $accomplishmentUUID = StudentAccomplishment::create([
            'user_id' => Auth::user()->user_id,
            'organization_id' => Auth::user()->course->organization_id,
            'accomplishment_uuid' => Str::uuid(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'objective' => $request->input('objective'),
            'start_date' => $request->input('startDate'),
            'end_date' => $request->input('endDate'),
            'start_time' => $request->input('startTime'),
            'end_time' => $request->input('endTime'),
            'venue' => $request->input('venue'),
            'organizer' => $request->input('organizer'),
        ])->accomplishment_uuid;
        return $accomplishmentUUID;
    }

    /**
     * Service to Store a Student Accomplishment Files.
     *
     * @return void
     */
    public function storeAccomplishmentFiles($request, $accomplishmentUUID)
    {
        $temp_path = '/public/uploads/tmp/';
        $final_path = '/public/uploads/student_accomplishments/';
        $db_path = '/uploads/student_accomplishments/';
        $accomplishmentID = StudentAccomplishment::where('accomplishment_uuid', $accomplishmentUUID)->value('student_accomplishment_id');
        
        // SHORTEN ME MOFO WAY TOO REDUNDANT
        if($request->has('evidence1'))
        {
            $caption = $request->input('caption1', NULL);
            $file = TemporaryFile::where('folder', $request->input('evidence1'))->value('filename');

            Storage::move($temp_path . $request->input('evidence1') . '/' . $file, $final_path . $file);
            $this->deleteDirectory($temp_path . $request->input('evidence1'));

            // type: 1 - IMG | 2 - PDF
            if(Str::endsWith($file, '.pdf'))
                $type = 2;
            elseif ((Str::endsWith($file, '.png')) || (Str::endsWith($file, '.jpg')) || (Str::endsWith($file, '.jpeg'))) 
                $type = 1;
            StudentAccomplishmentFile::create([
                'student_accomplishment_id' => $accomplishmentID,
                'SA_document_type_id' => $request->input('documentType1'),
                'file' =>  $db_path . $file, 
                'caption' => $caption,
                'type' => $type
            ]);
        }

        if($request->has('evidence2'))
        {
            $caption = $request->input('caption2', NULL);
            $file = TemporaryFile::where('folder', $request->input('evidence2'))->value('filename');

            Storage::move($temp_path . $request->input('evidence2') . '/' . $file, $final_path . $file);
            $this->deleteDirectory($temp_path . $request->input('evidence2'));

            // type: 1 - IMG | 2 - PDF
            if(Str::endsWith($file, '.pdf'))
                $type = 2;
            elseif ((Str::endsWith($file, '.png')) || (Str::endsWith($file, '.jpg')) || (Str::endsWith($file, '.jpeg'))) 
                $type = 1;
            StudentAccomplishmentFile::create([
                'student_accomplishment_id' => $accomplishmentID,
                'SA_document_type_id' => $request->input('documentType2'),
                'file' =>  $db_path . $file, 
                'caption' => $caption,
                'type' => $type
            ]);
        }
        if($request->has('evidence3'))
        {
             $caption = $request->input('caption3', NULL);
            $file = TemporaryFile::where('folder', $request->input('evidence3'))->value('filename');

            Storage::move($temp_path . $request->input('evidence3') . '/' . $file, $final_path . $file);
            $this->deleteDirectory($temp_path . $request->input('evidence3'));
            
            // type: 1 - IMG | 2 - PDF
            if(Str::endsWith($file, '.pdf'))
                $type = 2;
            elseif ((Str::endsWith($file, '.png')) || (Str::endsWith($file, '.jpg')) || (Str::endsWith($file, '.jpeg'))) 
                $type = 1;
            StudentAccomplishmentFile::create([
                'student_accomplishment_id' => $accomplishmentID,
                'SA_document_type_id' => $request->input('documentType3'),
                'file' =>  $db_path . $file, 
                'caption' => $caption,
                'type' => $type
            ]);
        }  
    }

    /**
     * Private Function to delete temporary directories.
     *
     * @return void
     */
    private function deleteDirectory($folderPath)
    {
        Storage::deleteDirectory($folderPath, true);
        sleep(0.3);
        Storage::deleteDirectory($folderPath);
    }
}
