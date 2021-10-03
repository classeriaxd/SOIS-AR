<?php

namespace App\Services\NotificationServices;

use App\Models\PositionTitle;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentAccomplishmentNotificationService
{
    /**
     * Service to Send Notifications to Officer.
     *
     * @return void
     */
    public function sendNotificationToOfficers($sender, $recieverOrganizationID, $accomplishmentUUID, $type = 3)
    {
        $valid_positions = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];
        $recieving_positions = PositionTitle::where('organization_id', $recieverOrganizationID)
            ->whereIn('position_title', $valid_positions)
            ->pluck('position_title_id');
        $recieving_users = array();
        foreach($recieving_positions as $reciever)
        {
            $recieving_user_id = DB::table('users_position_titles')->where('position_title_position_title_id', $reciever)->value('user_user_id');
            if ($recieving_user_id != NULL) 
                array_push($recieving_users,$recieving_user_id);
        }

        $notificationTitle = "New Student Accomplishment Submission";
        $notificationDescription = 'A student named ' . $sender . ' sent an Accomplishment Submission. Please review it!';
        $notificationType = $type;
        $notificationLink = $accomplishmentUUID;

        if (count($recieving_users) > 0)
        {
            foreach($recieving_users as $reciever)
            {
                if ($reciever != NULL)
                {
                    Notification::create([
                        'user_id' => $reciever,
                        'title' => $notificationTitle,
                        'description' => $notificationDescription,
                        'type' => $notificationType,
                        'link' => $notificationLink,
                    ]);
                }
            }
        }
    }

    /**
     * Service to Send Notifications to member.
     *
     * @return void
     */
    public function sendNotificationToMember($recieverID, $accomplishmentUUID, $status, $type = 3)
    {
        if ($recieverID != NULL)
        {
            $notificationLink = $accomplishmentUUID;
            $notificationType = $type;

            if ($status == 'approved')
            {
                $notificationTitle = "Submission Approved";
                $notificationDescription = 'Your Accomplishment Submission has been approved. Cheers!';
            }
            else if ($status == 'declined')
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