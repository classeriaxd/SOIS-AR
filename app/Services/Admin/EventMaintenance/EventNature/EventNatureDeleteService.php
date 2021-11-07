<?php

namespace App\Services\Admin\EventMaintenance\EventNature;

use App\Models\EventNature;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventNatureDeleteService
{
    /**
     * @param Collection $nature, Request $request
     * Service to Soft Delete an event nature.
     * Returns message on success.
     * @return Array
     */
    public function delete(EventNature $nature, $request): array
    {
        try 
        {
            $nature->delete();
            
            // Notify All Documentation Officers
            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                $request->input('notificationTitle'),
                $request->input('notificationDescription'),
                1,
            );

            return ['success' => 'Successfully deleted Event Nature. Notifications are sent to all Organization Officers'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Deleting Event Nature:' . $e->getMessage()];
        }
    }
}
