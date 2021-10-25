<?php

namespace App\Services\Admin\EventMaintenance\EventNature;

use App\Models\EventNature;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventNatureStoreService
{
    /**
     * @param Request $request
     * Service to Store an Event Nature.
     * Returns Message on success
     * @return Array
     */
    public function store($request)
    {
        try 
        {
            $eventNature = EventNature::create([
                'nature' => $request->input('nature'),
                'helper' => $request->input('helper', NULL),
            ]);

            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                'SYSTEM: Added an Event Nature',
                'The Administrator has added a new Event Nature (' . $eventNature->nature . '). Go to Event Creation Page to view it.',
                1,
            );
                
            return ['success' => 'Added the Event Nature Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in adding Event Nature:' . $e->getMessage()];
        }
    }
}
