<?php

namespace App\Services\NotificationServices\Admin;

use App\Models\PositionTitle;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminNotificationService
{
    /**
     * @param String $recievingOfficers, String $notificationTitle,  String $notificationDescription, Integer $type
     * Function to Send Notification to All Concerned Officer about changes to Event Categories
     * @return void
     */ 
    public function sendNotification($recievingOfficers, $notificationTitle, $notificationDescription, $type = 1)
    {
        switch ($recievingOfficers) {
            case 'Documentation Officers':
                $validPositions = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];
                break;
            case 'President':
                $validPositions = ['President'];
                break;
            case 'All':
                $validPositions = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation', 'President'];
                break;
        }

        $recievingPositions = PositionTitle::whereIn('position_title', $validPositions)
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
                    Notification::create([
                        'user_id' => $reciever,
                        'title' => $notificationTitle,
                        'description' => $notificationDescription,
                        'type' => $type,
                        'link' => NULL,
                    ]);
                }
            }
        }
    }

    /**
     * @param Request $request, Integer $type
     * Function to Send Notification to an Organization
     * @return void
     */ 
    public function sendNotificationToOrganization($request, $type = 1)
    {
        switch ($request->input('reciever')) {
            case 'All':
                $validPositions = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation', 'President'];
                break;
            case 'Officers':
                $validPositions = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];
                break;
            case 'Presidents':
                $validPositions = ['President'];
                break;
            
        }

        // Temporary: will change after implementing new roles

        foreach ($request->input('organization') as $organization_id) 
        {
            $recievingPositions = PositionTitle::whereIn('position_title', $validPositions)
                ->where('organization_id', $organization_id)
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
                        Notification::create([
                            'user_id' => $reciever,
                            'title' => $request->input('title'),
                            'description' => $request->input('description'),
                            'type' => $type,
                            'link' => NULL,
                        ]);
                    }
                }
            }
        }


    }
}