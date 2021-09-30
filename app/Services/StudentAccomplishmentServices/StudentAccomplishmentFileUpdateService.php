<?php

namespace App\Services\StudentAccomplishmentServices;

use App\Models\StudentAccomplishment;
use App\Models\StudentAccomplishmentFile;
use Illuminate\Support\Facades\Auth;

class StudentAccomplishmentFileUpdateService
{
    /**
     * Service to Update Student Accomplishment Files.
     *
     * @return void
     */
    public function update(StudentAccomplishment $accomplishment, $request)
    {
        $accomplishmentFiles = StudentAccomplishmentFile::where('student_accomplishment_id', $accomplishment->student_accomplishment_id)->get();
        switch ($accomplishment->accomplishment_files_count) 
        {
            case 1:
                $data = request()->validate([
                    'evidence1' => 'required',
                ]);
                break;

            case 2:
                $data = request()->validate([
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
                break;

            case 3:
                $data = request()->validate([
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
                break;
        }
    }
    
}
