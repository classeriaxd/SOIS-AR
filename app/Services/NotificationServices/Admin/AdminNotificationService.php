<?php

namespace App\Services\NotificationServices\Admin;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminAnnouncementMail;
use App\Jobs\SendEmail;
use Illuminate\Database\Eloquent\Builder;

class AdminNotificationService
{
    /**
     * @param String $recievers, String $notificationTitle,  String $notificationDescription, Integer $type
     * Function to Send Notification to All Concerned Officer about changes System Changes
     * @return void
     */ 
    public function sendNotification($recievers, $notificationTitle, $notificationDescription, $type = 1)
    {
        switch ($recievers) {
            case 'Documentation Officers':
                $recievingOfficers = User::whereHas(
                        'roles', function(Builder $query){
                            $query->where('role', 'AR Officer Admin');},)
                    ->get();
                break;
            case 'President':
                $recievingOfficers = User::whereHas(
                        'roles', function(Builder $query){
                            $query->where('role', 'AR President Admin');},)
                    ->get();
                break;
            case 'All':
                $recievingOfficers = User::whereHas(
                        'roles', function(Builder $query){
                            $query->whereIn('role', ['AR Officer Admin', 'AR President Admin']);},)
                    ->get();
                break;
        }

        if ($recievingOfficers->count() > 0)
        {
            foreach ($recievingOfficers as $recievingOfficer) 
            {
                Notification::create([
                    'user_id' => $recievingOfficer->user_id,
                    'title' => $notificationTitle,
                    'description' => $notificationDescription,
                    'type' => $type,
                    'link' => NULL,
                ]);
            }
        }
    }

    /**
     * @param Request $request, Integer $type
     * Function to Send an Announcement Notification to an Organization and its Officers/Presidents
     * @return void
     */ 
    public function sendNotificationToOrganization($request, $type = 1)
    {
        switch ($request->input('reciever')) {
            case 'All':
                $recievers = ['AR Officer Admin', 'AR President Admin'];
                break;
            case 'Officers':
                $recievers = ['AR Officer Admin'];
                break;
            case 'Presidents':
                $recievers = ['AR President Admin'];
                break;
        }

        foreach ($request->input('organization') as $organizationID) 
        {
            $recievingOfficers = User::whereHas(
                    'roles', function(Builder $query) use ($recievers, $organizationID) {
                        $query->whereIn('role', $recievers)
                            ->where('organization_id', $organizationID);},)
                ->get();

            if ($recievingOfficers->count() > 0)
            {
                foreach ($recievingOfficers as $recievingOfficer) 
                {

                    Notification::create([
                        'user_id' => $recievingOfficer->user_id,
                        'title' => 'Announcement: ' . $request->input('title'),
                        'description' => $request->input('description'),
                        'type' => $type,
                        'link' => NULL,
                    ]);

                    // Send Email thru Jobs
                    dispatch(new SendEmail($recievingOfficer->email, $recievingOfficer->full_name, $request->input('title'), $request->input('description')));
                }
            }
        }
    }

    /**
     * @param Integer $userID, String $userEmail, String $userFullName, String $notificationTitle, String $notificationDescription, Integer $type
     * Function to Send a Notification to a Member/Officer that had been assigned a new role to their account
     */
    public function sendNotificationForRoleAssignment($userID, $userEmail, $userFullName, $notificationTitle, $notificationDescription, $type = 1)
    {
        Notification::create([
            'user_id' => $userID,
            'title' => $notificationTitle,
            'description' => $notificationDescription,
            'type' => $type,
            'link' => NULL,
        ]);
        
        // Send Email thru Jobs
        dispatch(new SendEmail($userEmail, $userFullName, $notificationTitle, $notificationDescription));
    } 

    /**
     * @param Integer $userID, String $userEmail, String $userFullName, String $notificationTitle, String $notificationDescription, Integer $type
     * Function to Send a Notification to a Member/Officer that had a role detached from their account
     */
    public function sendNotificationForRoleDetachment($userID, $userEmail, $userFullName, $notificationTitle, $notificationDescription, $type = 1)
    {
        Notification::create([
            'user_id' => $userID,
            'title' => $notificationTitle,
            'description' => $notificationDescription,
            'type' => $type,
            'link' => NULL,
        ]);

        // Send Email thru Jobs
        dispatch(new SendEmail($userEmail, $userFullName, $notificationTitle, $notificationDescription));
    } 

    /**
     * @param Collection $schoolYear, Integer $type
     * Function to Send Notification to all Officers about the Yearly Backup
     */
    public function sendNotificationForYearlyHousekeeping($schoolYear, $type = 1)
    {
        $notificationTitle = "SOIS-AR Yearly Backup (" . 
        date_format(date_create($schoolYear->annual_start), 'Y') . '-' . 
        date_format(date_create($schoolYear->annual_end), 'Y') . ")";

        $notificationDescription = "
            A SOIS-AR Backup has been initialized by the System Administrator. 
            All data from Events, Student Accomplishments, Accomplishment Reports, and Organization Documents will be permanently deleted.
            A Backup copy of all Accomplishment Reports and Organization Documents in that School Year will be available on request.";
        
        // Get all Users with Roles: Officer, President, and HSS
        $recievingOfficers = User::whereHas(
                'roles', function(Builder $query){
                    $query->whereIn('role', ['AR Officer Admin', 'AR President Admin', 'Head of Student Services']);},)
            ->get();
        
        // Collect Data to Insert in Notification Table
        $notificationData = array();
        foreach ($recievingOfficers as $recievingOfficer) 
        {
            array_push($notificationData,
                [
                    'user_id' => $recievingOfficer->user_id,
                    'title' => $notificationTitle,
                    'description' => $notificationDescription,
                    'type' => $type,
                    'link' => NULL,
                ]
            );

            // Send Email thru Jobs
            dispatch(new SendEmail($recievingOfficer->email, $recievingOfficer->first_name, $notificationTitle, $notificationDescription));
        }

        // Mass Insert of notifications
        Notification::insert($notificationData);
    }
}