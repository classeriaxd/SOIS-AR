<?php

namespace App\Services\Admin\EventMaintenance\Level;

use App\Models\Level;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class LevelDeleteService
{
    /**
     * @param Collection $level, Request $request
     * Service to Soft Delete a level.
     * Returns message on success.
     * @return Array
     */
    public function delete(Level $level, $request): array
    {
        try 
        {
            $level->delete();
            
            // Notify All Documentation Officers
            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                $request->input('notificationTitle'),
                $request->input('notificationDescription'),
                1,
            );

            return ['success' => 'Successfully deleted Level. Notifications are sent to all Organization Officers'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Deleting Level:' . $e->getMessage()];
        }
    }
}
