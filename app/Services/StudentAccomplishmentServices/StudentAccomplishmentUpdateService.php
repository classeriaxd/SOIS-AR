<?php

namespace App\Services\StudentAccomplishmentServices;

use App\Models\StudentAccomplishment;
use Illuminate\Support\Facades\Auth;

class StudentAccomplishmentUpdateService
{
    /**
     * Service to Update a Student Accomplishment.
     *
     * @return void
     */
    public function approve(StudentAccomplishment $accomplishment, $request)
    {
        $accomplishmentData = [
            'level_id' => $request->input('level'),
            'fund_source_id' => $request->input('fundSource'),
            'event_id' => $request->input('relatedEvent', NULL),
            'remarks' => $request->input('remarks'),
            'budget' => $request->input('budget', NULL),
            'activity_type' => $request->input('activityType'),
            'beneficiaries' => $request->input('beneficiaries'),
            'status' => 2,
            'reviewed_by' => Auth::user()->user_id,
        ];
        $accomplishment->update($accomplishmentData);
    }

    public function decline(StudentAccomplishment $accomplishment, $remarks)
    {
        $accomplishmentData = [
            'remarks' => $remarks,
            'status' => 3,
            'reviewed_by' => Auth::user()->user_id,
        ];
        $accomplishment->update($accomplishmentData);
    }
}
