<?php

namespace App\Services\Admin\EventMaintenance\EventCategory;

use App\Models\EventCategory;
use Illuminate\Support\Str;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventCategoryDeleteService
{
    /**
     * Service to Soft Delete an event.
     * Returns message on success.
     * @return Array
     */
    public function delete(EventCategory $category, $request)
    {
        try 
        {
            $category->delete();
            
            // Notify All Documentation Officers
            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                $request->input('notificationTitle'),
                $request->input('notificationDescription'),
                1,
            );

            return ['success' => 'Successfully deleted Event Category. Notifications are sent to all Organization Officers'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Deleting Event Category:' . $e->getMessage()];
        }
    }
}
