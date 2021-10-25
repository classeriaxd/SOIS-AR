<?php

namespace App\Services\Admin\EventMaintenance\EventNature;

use App\Models\EventNature;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventNatureUpdateService
{
    /**
     * @param Collection $nature, Request $request
     * Service to Update an Event Nature.
     * Returns Message on success
     * @return Array
     */
    public function update(EventNature $nature, $request)
    {
        try 
        {
            $nature->update([
                'nature' => $request->input('nature'),
                'helper' => $request->input('helper', NULL),
            ]);
            
            // Notify All Documentation Officers
            if ($request->has('notify')) 
            {
                $adminNotificationService = new AdminNotificationService();
                $adminNotificationService->sendNotification(
                    'All', 
                    'SYSTEM: Update on Event Nature',
                    'The Administrator has made changes to an Event Nature (' . $nature->nature . '). Go to Event Creation Page to view changes.',
                    1,
                );
            }

            return ['success' => 'Updated the Event Nature Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Updating Event Nature:' . $e->getMessage()];
        }
            
    }
}
