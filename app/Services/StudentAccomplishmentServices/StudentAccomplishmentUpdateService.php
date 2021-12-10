<?php

namespace App\Services\StudentAccomplishmentServices;

use App\Models\StudentAccomplishment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Services\StudentAccomplishmentServices\{
    StudentAccomplishmentFileUpdateService,
};
use App\Services\NotificationServices\{
    StudentAccomplishmentNotificationService,
};

class StudentAccomplishmentUpdateService
{
    /**
     * @param Collection $accomplishment, Request $request
     * Service to Approve a Student Accomplishment.
     * Returns Message on success/fail
     * @return Array
     */
    public function approve(StudentAccomplishment $accomplishment, $request): array
    {
        try
        {
            $accomplishmentData = [
                'level_id' => $request->input('level'),
                'fund_source_id' => $request->input('fundSource'),
                'accomplished_event_id' => $request->input('relatedEvent', NULL),
                'remarks' => $request->input('remarks'),
                'budget' => $request->input('budget', NULL),
                'activity_type' => $request->input('activityType'),
                'beneficiaries' => $request->input('beneficiaries'),
                'status' => 2,
                'reviewed_by' => Auth::user()->user_id,
                'reviewed_at' => Carbon::now(),
            ];

            // Update the Accomplishment
            $accomplishment->update($accomplishmentData);

            // Update the Accomplishment Documents
            (new StudentAccomplishmentFileUpdateService())->update($accomplishment, $request);

            // Send Notification to Member
            (new StudentAccomplishmentNotificationService())->sendNotificationToMember($accomplishment->user_id, $accomplishment->accomplishment_uuid, 'approved');

            return ['success' => 'Accepted the Accomplishment! Sent a Notification to that Member.'];
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
             return ['error' => 'Error in Approving Accomplishment:' . $e->getMessage()];
        }
        
    }

    /**
     * @param Collection $accomplishment, String $remarks
     * Service to Decline a Student Accomplishment.
     * Returns Message on success/fail
     * @return Array
     */
    public function decline(StudentAccomplishment $accomplishment, $remarks)
    {
        try
        {
            $accomplishmentData = [
                'remarks' => $remarks,
                'status' => 3,
                'reviewed_by' => Auth::user()->user_id,
                'reviewed_at' => Carbon::now(),
            ];

            // Update the Accomplishment
            $accomplishment->update($accomplishmentData);

            // Send Notification to Member
            (new StudentAccomplishmentNotificationService())->sendNotificationToMember($accomplishment->user_id, $accomplishment->accomplishment_uuid, 'declined');

            return ['success' => 'Declined the Accomplishment. Sent a Notification to that Member.'];
        }
        
        catch (\Illuminate\Database\QueryException $e) 
        {
             return ['error' => 'Error in Declining Accomplishment:' . $e->getMessage()];
        }
        
    }
}
