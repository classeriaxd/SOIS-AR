<?php

namespace App\Services\Admin\EventMaintenance\Level;

use App\Models\Level;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class LevelUpdateService
{
    /**
     * @param Request $request
     * Service to Update a Level.
     * Returns Message on success
     * @return Array
     */
    public function update(Level $level, $request): array
    {
        try 
        {
            $level->update([
                'level' => $request->input('level'),
                'helper' => $request->input('helper', NULL),
            ]);
            
            // Notify All Documentation Officers
            if ($request->has('notify')) 
            {
                $adminNotificationService = new AdminNotificationService();
                $adminNotificationService->sendNotification(
                    'All', 
                    'SYSTEM: Update on Level',
                    'The Administrator has made changes to an Level (' . $level->level . '). Go to Event Creation Page to view changes.',
                    1,
                );
            }

            return ['success' => 'Updated the Level Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Updating Level:' . $e->getMessage()];
        }
            
    }
}
