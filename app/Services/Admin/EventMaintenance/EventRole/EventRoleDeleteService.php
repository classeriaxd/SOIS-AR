<?php

namespace App\Services\Admin\EventMaintenance\EventRole;

use App\Models\EventRole;
use Illuminate\Support\Str;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventRoleDeleteService
{
    /**
     * @param Collection $role, Request $request
     * Service to Soft Delete an event role.
     * Returns message on success.
     * @return Array
     */
    public function delete(EventRole $role, $request)
    {
        try 
        {
            $role->delete();
            
            // Notify All Documentation Officers
            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                $request->input('notificationTitle'),
                $request->input('notificationDescription'),
                1,
            );

            return ['success' => 'Successfully deleted Event Role. Notifications are sent to all Organization Officers'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Deleting Event Role:' . $e->getMessage()];
        }
    }
}
