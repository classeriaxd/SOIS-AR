<?php

namespace App\Services\NotificationServices;

use App\Models\Notification;
use App\Models\User;

use Illuminate\Database\Eloquent\Builder;

class StudentAccomplishmentNotificationService
{
    /**
     * @param String $sender, Integer $recieverOrganizationID, String $accomplishmentUUID, Integer $type
     * Service to Send Notifications to Documentation Officer.
     * @return void
     */
    public function sendNotificationToOfficers($sender, $recieverOrganizationID, $accomplishmentUUID, $type = 3)
    {
        $recievingOfficers = User::whereHas(
                'roles', function(Builder $query){
                    $query->where('role', 'AR Officer Admin');},)
            ->whereHas(
                'course.organization', function(Builder $query) use($recieverOrganizationID){
                    $query->where('organization_id', $recieverOrganizationID);},)
            ->get();

        $notificationTitle = "New Student Accomplishment Submission";
        $notificationDescription = 'A student named ' . $sender . ' sent an Accomplishment Submission. Please review it!';
        $notificationType = $type;
        $notificationLink = $accomplishmentUUID;

        if ($recievingOfficers->count() > 0)
        {
            foreach ($recievingOfficers as $recievingOfficer) 
            {
                Notification::create([
                    'user_id' => $recievingOfficer->user_id,
                    'title' => $notificationTitle,
                    'description' => $notificationDescription,
                    'type' => $notificationType,
                    'link' => $notificationLink,
                ]);
            }
        }
    }

    /**
     * @param Integer $recieverID, String $accomplishmentUUID, Integer $status, Integer $type
     * Service to Send Notifications to member.
     * @return void
     */
    public function sendNotificationToMember($recieverID, $accomplishmentUUID, $status, $type = 3)
    {
        if ($recieverID !== NULL)
        {
            $notificationLink = $accomplishmentUUID;
            $notificationType = $type;

            if ($status === 'approved')
            {
                $notificationTitle = "Submission Approved";
                $notificationDescription = 'Your Accomplishment Submission has been approved. \'Grats!';
            }
            else if ($status === 'declined')
            {
                $notificationTitle = "Submission Declined";
                $notificationDescription = 'Your Accomplishment Submission has been declined.';
            }

            Notification::create([
                'user_id' => $recieverID,
                'title' => $notificationTitle,
                'description' => $notificationDescription,
                'type' => $notificationType,
                'link' => $notificationLink,
            ]);

        }
    }
}