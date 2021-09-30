<?php

namespace App\Services\NotificationServices;

use App\Models\PositionTitle;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccomplishmentReportNotificationService
{
    /**
     * Function to Send Notification to Organization President
     * about new Accomplishment Report
     * 
     * sender = String
     * recieverOrganizationId = int
     * accomplishmentReportUUID = String
     * type = String (System,Event,SA,AR)
     */ 
    public function sendNotificationToPresident($sender, $recieverOrganizationId, $accomplishmentReportUUID, $type = 4)
    {
        $validPositions = ['President'];
        $recievingPositions = PositionTitle::where('organization_id', $recieverOrganizationId)
            ->whereIn('position_title', $validPositions)
            ->pluck('position_title_id');
        $recievingUsers = array();
        foreach($recievingPositions as $reciever)
        {
            $recievingUserId = DB::table('users_position_titles')->where('position_title_position_title_id', $reciever)->value('user_user_id');
            if ($recievingUserId != NULL) 
                array_push($recievingUsers,$recievingUserId);
        }

        if (count($recievingUsers) > 0)
        {
            foreach($recievingUsers as $reciever)
            {
                if ($reciever != NULL)
                {
                    $notificationTitle = "New Accomplishment Report Submission";
                    $notificationDescription = 'An Officer named ' . $sender . ' sent an Accomplishment Report Submission. Please review it!';
                    $notificationType = $type;
                    $notificationLink = $accomplishmentReportUUID;
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
     * Function to Send Notification to Documentation Officer
     * about Accomplishment Report status
     * 
     * sender = String
     * recieverOrganizationId = int
     * accomplishmentReportUUID = String
     * status = String(approved,declined)
     * type = String (System,Event,SA,AR)
     */ 
    public function sendNotificationToOfficer($recieverOrganizationId, $accomplishmentReportUUID, $status, $type = 4)
    {
        $validPositions = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];
        $recievingPositions = PositionTitle::where('organization_id', $recieverOrganizationId)
            ->whereIn('position_title', $validPositions)
            ->pluck('position_title_id');
        $recievingUsers = array();
        foreach($recievingPositions as $reciever)
        {
            $recievingUserId = DB::table('users_position_titles')->where('position_title_position_title_id', $reciever)->value('user_user_id');
            if ($recievingUserId != NULL) 
                array_push($recievingUsers,$recievingUserId);
        }

        $notificationType = $type;
        $notificationLink = $accomplishmentReportUUID;

        if (count($recievingUsers) > 0)
        {
            foreach($recievingUsers as $reciever)
            {
                if ($reciever != NULL)
                {
                    if($status == 'approved')
                    {
                        $notificationTitle = "AR Submission approved!";
                        $notificationDescription = "Your Accomplishment Report Submission has been approved.";

                    }
                    else if($status == 'declined')
                    {
                        $notificationTitle = "AR Submission declined.";
                        $notificationDescription = "Your Accomplishment Report Submission has been declined.";
                    }
                    
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
}