<?php

namespace App\Services\NotificationServices\Admin;

use App\Models\Notification;
use App\Models\User;

use Illuminate\Database\Eloquent\Builder;

class AdminNotificationService
{
    /**
     * @param String $recievers, String $notificationTitle,  String $notificationDescription, Integer $type
     * Function to Send Notification to All Concerned Officer about changes to Event Categories
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
     * Function to Send Notification to an Organization
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