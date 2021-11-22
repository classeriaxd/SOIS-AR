<?php

namespace App\Services\NotificationServices;

use App\Models\Notification;
use App\Models\User;

use Illuminate\Database\Eloquent\Builder;

class AccomplishmentReportNotificationService
{
    /**
     * @param String $sender, Integer $recieverOrganizationID, String $accomplishmentReportUUID, Integer $type
     * Function to Send Notification to Organization President about new Accomplishment Report
     * @return void
     */ 
    public function sendNotificationToPresident($sender, $recieverOrganizationID, $accomplishmentReportUUID, $type = 4)
    {
        $recievingOfficers = User::whereHas(
                'roles', function(Builder $query){
                    $query->where('role', 'AR President Admin');},)
            ->whereHas(
                'course.organization', function(Builder $query) use($recieverOrganizationID){
                    $query->where('organization_id', $recieverOrganizationID);},)
            ->get();

        if ($recievingOfficers->count() > 0)
        {
            foreach ($recievingOfficers as $recievingOfficer) 
            {
                Notification::create([
                    'user_id' => $recievingOfficer->user_id,
                    'title' => 'New Accomplishment Report Submission',
                    'description' => 'An Officer named ' . $sender . ' sent an Accomplishment Report Submission. Please review it!',
                    'type' => $type,
                    'link' => $accomplishmentReportUUID,
                ]);
            }
        }
    }
    /**
     * @param Integer $recieverOrganizationID, String $accomplishmentReportUUID, String $status, Integer $type
     * Function to Send Notification to Documentation Officer about Accomplishment Report status
     * @return void
     */ 
    public function sendNotificationToOfficer($recieverOrganizationID, $accomplishmentReportUUID, $status, $type = 4)
    {
        $recievingOfficers = User::whereHas(
                'roles', function(Builder $query){
                    $query->where('role', 'AR Officer Admin');},)
            ->whereHas(
                'course.organization', function(Builder $query) use($recieverOrganizationID){
                    $query->where('organization_id', $recieverOrganizationID);},)
            ->get();

        if ($recievingOfficers->count() > 0)
        {
            foreach ($recievingOfficers as $recievingOfficer) 
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
                    'user_id' => $recievingOfficer->user_id,
                    'title' => $notificationTitle,
                    'description' => $notificationDescription,
                    'type' => $type,
                    'link' => $accomplishmentReportUUID,
                ]);
            }
        }
    }
}